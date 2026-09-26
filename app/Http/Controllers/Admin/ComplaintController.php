<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComplaintController extends Controller
{
    /**
     * Tampilkan daftar pengaduan pada tab "Baru" (belum selesai) atau "Riwayat" (sudah selesai).
     */
    public function index(Request $request): View
    {
        $activeTab = $request->input('tab') === 'riwayat' ? 'riwayat' : 'baru';
        $query = Laporan::query();

        if ($activeTab === 'riwayat') {
            $query->completed();
        } else {
            $query->unfinished();
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('no_whatsapp', 'like', "%{$search}%")
                    ->orWhere('isi_laporan', 'like', "%{$search}%");
            });
        }

        $paginationParams = array_filter([
            'tab' => $activeTab,
            'kategori' => $request->input('kategori'),
            'search' => $request->input('search'),
        ], static fn (mixed $value): bool => $value !== null && $value !== '');

        $laporans = $query->latest()->paginate(15)->appends($paginationParams);
        $kategoriLabels = Laporan::KATEGORI_LABELS;

        return view('admin.complaints.index', compact('laporans', 'kategoriLabels', 'activeTab'));
    }

    /**
     * Tampilkan detail satu laporan (read-only).
     */
    public function show(Laporan $complaint): View
    {
        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Tandai pengaduan selesai sehingga berpindah dari tab "Baru" ke "Riwayat".
     * Satu-satunya backend aksi "Selesai" untuk list maupun detail.
     */
    public function complete(Laporan $complaint): RedirectResponse
    {
        if ($complaint->isCompleted()) {
            return redirect()->route('admin.complaints.index', ['tab' => 'riwayat'])
                ->with('success', 'Pengaduan ini sudah berada di Riwayat.');
        }

        $complaint->markCompleted();

        return redirect()->route('admin.complaints.index', ['tab' => 'riwayat'])
            ->with('success', 'Pengaduan berhasil ditandai selesai.');
    }

    /**
     * Hapus pengaduan yang sudah selesai beserta lampirannya.
     */
    public function destroy(Laporan $complaint): RedirectResponse
    {
        if (! $complaint->isCompleted()) {
            return redirect()->route('admin.complaints.index', ['tab' => 'baru'])
                ->with('error', 'Hanya pengaduan yang sudah selesai yang dapat dihapus.');
        }

        MediaHelper::delete($complaint->lampiran);
        $complaint->delete();

        return redirect()->route('admin.complaints.index', ['tab' => 'riwayat'])
            ->with('success', 'Pengaduan selesai berhasil dihapus.');
    }
}
