<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ComplaintController extends Controller
{
    /**
     * Tampilkan daftar laporan pengaduan dengan filter status.
     */
    public function index(Request $request): View
    {
        $query = Laporan::query();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('isi_laporan', 'like', "%{$search}%");
            });
        }

        $laporans   = $query->latest()->paginate(15)->withQueryString();
        $kategoris  = ['infrastruktur', 'kependudukan', 'keamanan', 'lingkungan', 'layanan_publik', 'lainnya'];

        return view('admin.complaints.index', compact('laporans', 'kategoris'));
    }

    /**
     * Tampilkan detail satu laporan.
     */
    public function show(Laporan $complaint): View
    {
        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Tampilkan form edit status & catatan admin.
     */
    public function edit(Laporan $complaint): View
    {
        return view('admin.complaints.edit', compact('complaint'));
    }

    /**
     * Update status dan catatan admin untuk laporan.
     */
    public function update(Request $request, Laporan $complaint): RedirectResponse
    {
        $validated = $request->validate([
            'status'         => ['required', 'in:baru,diproses,selesai,ditolak'],
            'catatan_admin'  => ['nullable', 'string', 'max:2000'],
        ]);

        $complaint->update($validated);

        return redirect()
            ->route('admin.complaints.index')
            ->with('success', 'Laporan pengaduan berhasil diperbarui.');
    }

    /**
     * Hapus laporan pengaduan beserta lampirannya.
     */
    public function destroy(Laporan $complaint): RedirectResponse
    {
        if ($complaint->lampiran) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($complaint->lampiran);
        }

        $complaint->delete();

        return redirect()
            ->route('admin.complaints.index')
            ->with('success', 'Laporan pengaduan berhasil dihapus.');
    }
}
