<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestMagicLinkRequest;
use App\Http\Requests\StoreLaporanRequest;
use App\Mail\MagicLoginMail;
use App\Mail\VerifikasiLaporanMail;
use App\Models\Laporan;
use App\Models\LoginAttempt;
use App\Models\LoginToken;
use App\Models\Pelapor;
use App\Services\MagicLinkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function landing(): View
    {
        $categories = config('pengaduan.categories', []);
        return view('public.laporan.landing', compact('categories'));
    }

    public function create(Request $request): View
    {
        $categories = config('pengaduan.categories', []);
        $selectedCategory = $request->query('kategori');
        return view('public.laporan.create', compact('categories', 'selectedCategory'));
    }

    public function store(StoreLaporanRequest $request, MagicLinkService $magicLinks): RedirectResponse
    {
        $data = $request->validated();
        $pelapor = Pelapor::where('email', $data['email'])->first();
        if ($pelapor && !Hash::check($data['nik'], $pelapor->nik_hash)) {
            return back()->withInput($request->except('nik'))->withErrors(['email' => 'Data pelapor tidak dapat diverifikasi. Gunakan email lain atau hubungi desa.']);
        }
        $path = null;
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $extension = match ($file->getMimeType()) { 'image/jpeg' => 'jpg', 'image/png' => 'png', 'application/pdf' => 'pdf' };
            $path = $file->storeAs('laporans', Str::uuid()->toString().'.'.$extension, 'local');
        }
        [$laporan, $token] = DB::transaction(function () use ($data, $pelapor, $path, $magicLinks) {
            $pelapor ??= Pelapor::create(['nama' => $data['nama'], 'nik_hash' => Hash::make($data['nik']), 'email' => $data['email']]);
            $laporan = Laporan::create(['pelapor_id' => $pelapor->id, 'kategori' => $data['kategori'], 'isi_laporan' => $data['isi_laporan'], 'lampiran' => $path, 'status' => 'pending_verification']);
            [, $token] = $magicLinks->create($pelapor, LoginToken::VERIFY_LAPORAN, 15, $laporan);
            return [$laporan, $token];
        });
        Mail::to($laporan->pelapor->email)->send(new VerifikasiLaporanMail($laporan, $token));
        return redirect()->route('pelapor.login.request')->with('success', 'Laporan tersimpan. Periksa email Anda untuk memverifikasi laporan.');
    }

    public function requestLogin(): View { return view('public.laporan.login'); }

    public function sendLogin(RequestMagicLinkRequest $request, MagicLinkService $magicLinks): RedirectResponse
    {
        $email = $request->validated('email');
        $key = 'pelapor-magic:'.hash('sha256', $email.'|'.$request->ip());
        if (RateLimiter::tooManyAttempts($key, 5)) return back()->withErrors(['email' => 'Terlalu banyak percobaan, coba lagi nanti']);
        RateLimiter::hit($key, 3600);
        LoginAttempt::create(['email' => $email, 'ip_address' => $request->ip(), 'attempted_at' => now()]);
        $pelapor = Pelapor::where('email', $email)->first();
        if ($pelapor) {
            [, $token] = $magicLinks->create($pelapor, LoginToken::MAGIC_LOGIN, 10);
            Mail::to($pelapor->email)->send(new MagicLoginMail($token));
        }
        return back()->with('success', 'Jika email tersebut terdaftar, link login akan dikirim.');
    }

    public function verify(Request $request): RedirectResponse|View
    {
        $raw = $request->query('token');
        if (!is_string($raw) || strlen($raw) !== 40 || !ctype_alnum($raw)) return $this->invalidToken();
        $result = DB::transaction(function () use ($raw) {
            $token = LoginToken::where('token_hash', hash('sha256', $raw))->lockForUpdate()->first();
            if (!$token || $token->is_used || $token->expires_at->isPast() || !$token->pelapor_id || !$token->pelapor) return null;
            if (!in_array($token->purpose, [LoginToken::VERIFY_LAPORAN, LoginToken::MAGIC_LOGIN, LoginToken::NOTIFICATION_LOGIN], true)) return null;
            if ($token->purpose === LoginToken::VERIFY_LAPORAN && (!$token->laporan || $token->laporan->pelapor_id !== $token->pelapor_id)) return null;
            $token->update(['is_used' => true, 'used_at' => now()]);
            if ($token->purpose === LoginToken::VERIFY_LAPORAN && $token->laporan->status === 'pending_verification') $token->laporan->update(['status' => 'diterima']);
            return $token->fresh(['pelapor', 'laporan']);
        });
        if (!$result) return $this->invalidToken();
        Auth::guard('pelapor')->login($result->pelapor);
        $request->session()->regenerate();
        return $result->purpose === LoginToken::VERIFY_LAPORAN
            ? redirect()->route('pelapor.laporan.show', $result->laporan->id)
            : redirect()->route('pelapor.laporan.index');
    }

    public function index(): View
    {
        $laporans = auth('pelapor')->user()->laporans()->latest()->paginate(15);
        return view('public.laporan.index', compact('laporans'));
    }
    public function show(string $laporan): View
    {
        $laporan = auth('pelapor')->user()->laporans()->with('tanggapans.admin')->findOrFail($laporan);
        Gate::forUser(auth('pelapor')->user())->authorize('view', $laporan);
        return view('public.laporan.show', compact('laporan'));
    }
    public function attachment(string $laporan)
    {
        $laporan = auth('pelapor')->user()->laporans()->findOrFail($laporan);
        abort_unless($laporan->lampiran && Storage::disk('local')->exists($laporan->lampiran), 404);
        return Storage::disk('local')->download($laporan->lampiran, 'lampiran-laporan.'.$this->extension($laporan->lampiran));
    }
    public function logout(Request $request): RedirectResponse
    {
        // Do not invalidate the entire browser session: the web/admin guard is independent.
        Auth::guard('pelapor')->logout(); $request->session()->regenerateToken();
        return redirect()->route('pelapor.login.request');
    }
    private function invalidToken(): View { return view('public.laporan.token-invalid'); }
    private function extension(string $path): string { return pathinfo($path, PATHINFO_EXTENSION); }
}
