<?php
namespace App\Http\Controllers\Admin;
use App\Events\LaporanDiperbarui;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateLaporanRequest;
use App\Models\Laporan;
use App\Models\LaporanTanggapan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
class LaporanController extends Controller
{
    public function index(Request $request): View { $laporans = Laporan::with('pelapor')->when($request->filled('status'), fn($q) => $q->where('status', $request->status))->latest()->paginate(20); return view('admin.laporans.index', compact('laporans')); }
    public function show(Laporan $laporan): View { $laporan->load('pelapor', 'tanggapans.admin'); return view('admin.laporans.show', compact('laporan')); }
    public function edit(Laporan $laporan): View { return view('admin.laporans.edit', compact('laporan')); }
    public function update(UpdateLaporanRequest $request, Laporan $laporan): RedirectResponse
    {
        $data = $request->validated(); $changed = $laporan->status !== $data['status']; $tanggapan = null;
        DB::transaction(function () use ($data, $laporan, $changed, &$tanggapan) {
            if ($changed) $laporan->update(['status' => $data['status']]);
            if (!empty($data['isi_tanggapan'])) $tanggapan = LaporanTanggapan::create(['laporan_id' => $laporan->id, 'admin_id' => auth()->id(), 'isi_tanggapan' => $data['isi_tanggapan'], 'status_baru' => $changed ? $data['status'] : null]);
        });
        if ($changed || $tanggapan) event(new LaporanDiperbarui($laporan->fresh(), $tanggapan));
        return redirect()->route('admin.laporans.show', $laporan)->with('success', 'Laporan diperbarui.');
    }
}
