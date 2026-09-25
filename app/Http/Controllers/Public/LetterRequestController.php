<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLetterRequestRequest;
use App\Models\LetterRequest;
use App\Models\LetterTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LetterRequestController extends Controller
{
    /**
     * Display list / search of ready-to-print letter templates
     * (now accessible via /layanan/surat/template → warga.letter.templates)
     */
    public function index(Request $request): View
    {
        $search = trim($request->input('search', ''));

        $query = LetterTemplate::whereNotNull('file_path');

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('requirements', 'like', "%{$search}%");
            });
        }

        $templates = $query->orderBy('name')->get();

        return view('public.layanan.surat.index', compact('templates', 'search'));
    }

    /**
     * Download the ready-to-print template file
     */
    public function downloadTemplate(LetterTemplate $letterTemplate)
    {
        if (! $letterTemplate->file_path || ! Storage::disk('public')->exists($letterTemplate->file_path)) {
            return back()->with('error', 'File template surat belum tersedia untuk diunduh. Silakan hubungi perangkat Desa Catur.');
        }

        $ext = pathinfo($letterTemplate->file_path, PATHINFO_EXTENSION);
        $filename = 'Template_'.Str::slug($letterTemplate->name, '_').($ext ? '.'.$ext : '.doc');
        $fullPath = Storage::disk('public')->path($letterTemplate->file_path);

        return response()->download($fullPath, $filename);
    }

    /**
     * Show form for creating new letter request.
     * Now the main entry point via /layanan/cetak-surat-mandiri (warga.letter.index).
     */
    public function create(): View
    {
        // Pastikan Surat Keterangan dan Surat Pengantar selalu tersedia di database
        if (LetterTemplate::whereIn('name', ['Surat Keterangan', 'Surat Pengantar'])->count() < 2) {
            LetterTemplate::firstOrCreate(
                ['name' => 'Surat Keterangan'],
                [
                    'code' => 'SK',
                    'description' => 'Surat Keterangan resmi dari Pemerintah Desa Catur untuk berbagai keperluan warga.',
                    'requirements' => "- Fotokopi KTP Pemohon\n- Fotokopi Kartu Keluarga (KK)\n- Surat Pengantar RT/RW",
                ]
            );
            LetterTemplate::firstOrCreate(
                ['name' => 'Surat Pengantar'],
                [
                    'code' => 'SP',
                    'description' => 'Surat Pengantar resmi dari Pemerintah Desa Catur untuk pengurusan dokumen di instansi terkait.',
                    'requirements' => "- Fotokopi KTP Pemohon\n- Fotokopi Kartu Keluarga (KK)\n- Surat Pengantar RT/RW",
                ]
            );
        }

        // Urutkan: Surat Keterangan paling atas, lalu Surat Pengantar, kemudian jenis surat lainnya
        $templates = LetterTemplate::where('name', '!=', 'Lainnya')->get()->sortBy(function ($item) {
            if ($item->name === 'Surat Keterangan') {
                return 1;
            }
            if ($item->name === 'Surat Pengantar') {
                return 2;
            }

            return 3;
        })->values();

        $isEmpty = false;

        return view('public.layanan.surat.create', compact('templates', 'isEmpty'));
    }

    /**
     * Store new letter request (guest & logged-in user)
     */
    public function store(StoreLetterRequestRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $templateId = $validated['template_id'];

        try {
            if ($templateId === 'lainnya') {
                $otherTpl = LetterTemplate::firstOrCreate(
                    ['name' => 'Lainnya'],
                    [
                        'code' => 'LAINNYA',
                        'description' => 'Jenis surat permohonan lainnya yang diisi secara spesifik oleh warga.',
                    ]
                );
                $templateId = $otherTpl->id;
            }

            $letterRequest = DB::transaction(function () use ($templateId, $validated) {
                return LetterRequest::create([
                    'user_id' => auth()->id(), // null if guest
                    'template_id' => $templateId,
                    'form_data' => $validated['form_data'],
                    'status' => 'pending',
                ]);
            });
        } catch (\Throwable $e) {
            Log::error('Gagal menyimpan pengajuan surat warga.', [
                'template_id' => $templateId,
                'user_id' => auth()->id(),
                'exception' => $e,
            ]);

            return back()->withInput()->with('error', 'Pengajuan surat gagal disimpan. Silakan coba lagi atau hubungi admin Desa Catur.');
        }

        Log::info('Pengajuan surat warga berhasil disimpan.', [
            'letter_request_id' => $letterRequest->id,
            'ticket_number' => $letterRequest->ticket_number,
            'user_id' => $letterRequest->user_id,
        ]);

        $noWa = data_get($validated, 'form_data.telepon', '');

        return redirect()->route('warga.letter.show', $letterRequest->id)
            ->with('success', "Permohonan surat berhasil dikirim! Nomor Tiket Anda: {$letterRequest->ticket_number}. Admin Desa Catur akan menghubungi Anda melalui WhatsApp ke nomor {$noWa} untuk menindaklanjuti.");
    }

    /**
     * Show letter request detail with ticket number.
     * Hanya pemilik permohonan yang dapat mengakses (mencegah IDOR).
     */
    public function show(LetterRequest $letterRequest): View
    {
        // Jika user sedang login dan bukan admin, pastikan surat ini miliknya
        if (auth()->check() && ! auth()->user()->isAdmin()) {
            if ($letterRequest->user_id && $letterRequest->user_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki izin untuk mengakses permohonan surat ini.');
            }
        }

        $letterRequest->load('template');

        return view('public.layanan.surat.show', compact('letterRequest'));
    }
}
