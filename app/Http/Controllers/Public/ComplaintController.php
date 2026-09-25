<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLaporanRequest;
use App\Models\Laporan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ComplaintController extends Controller
{
    /**
     * Tampilkan form pengaduan publik.
     */
    public function create(): View
    {
        return view('public.layanan.pengaduan.create');
    }

    /**
     * Simpan laporan pengaduan baru.
     * Pelapor tidak memiliki akun — identifikasi lewat nama & no_whatsapp.
     */
    public function store(StoreLaporanRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $attachmentPath = null;

        try {
            // Simpan lampiran sebelum transaksi, lalu hapus path bila insert DB gagal.
            if ($request->hasFile('lampiran')) {
                $attachmentPath = $request->file('lampiran')->store('laporans', 'public');
                $validated['lampiran'] = $attachmentPath;
            }

            $laporan = DB::transaction(function () use ($validated) {
                return Laporan::create(array_merge($validated, [
                    'status' => 'baru',
                ]));
            });

            Log::info('Pengaduan warga berhasil disimpan.', [
                'laporan_id' => $laporan->id,
                'has_attachment' => (bool) $laporan->lampiran,
            ]);
        } catch (\Throwable $e) {
            if ($attachmentPath) {
                Storage::disk('public')->delete($attachmentPath);
            }

            Log::error('Gagal menyimpan pengaduan warga.', [
                'nama' => $validated['nama'] ?? null,
                'no_whatsapp' => $validated['no_whatsapp'] ?? null,
                'exception' => $e,
            ]);

            return back()->withInput()->with('error', 'Pengaduan gagal disimpan. Silakan coba lagi atau hubungi admin Desa Catur.');
        }

        return redirect()
            ->route('warga.complaint.create')
            ->with('success', 'Laporan pengaduan Anda berhasil dikirim! Admin Desa Catur akan menghubungi Anda melalui WhatsApp ke nomor '.$validated['no_whatsapp'].' untuk menindaklanjuti laporan ini.');
    }
}
