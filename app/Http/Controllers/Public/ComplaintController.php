<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLaporanRequest;
use App\Models\Laporan;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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

        // Simpan lampiran jika ada
        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')
                ->store('laporans', 'public');
        }

        Laporan::create($validated);

        return redirect()
            ->route('warga.complaint.create')
            ->with('success', 'Laporan pengaduan Anda berhasil dikirim! Admin Desa Catur akan menghubungi Anda melalui WhatsApp ke nomor ' . $validated['no_whatsapp'] . ' untuk menindaklanjuti laporan ini.');
    }
}
