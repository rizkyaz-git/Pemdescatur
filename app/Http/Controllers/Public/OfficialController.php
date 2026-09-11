<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Official;
use Illuminate\View\View;

class OfficialController extends Controller
{
    public function index(): View
    {
        try {
            // Get all officials ordered by order ASC
            $officials = Official::orderBy('order', 'asc')->get();
        } catch (\Throwable $e) {
            $officials = collect();
        }

        // If database is empty or unseeded, provide authentic Desa Catur officials
        if ($officials->isEmpty()) {
            $defaultList = [
                ['name' => 'HANANTO ADI KUSUMO, S.AP', 'position' => 'SEKRETARIS DESA', 'order' => 1],
                ['name' => 'SIGIT SETIYAWAN, S.P', 'position' => 'KASI PEMERINTAHAN', 'order' => 2],
                ['name' => 'AHMAD SURYANTO, S.Ag', 'position' => 'KASI KESEJAHTERAAN', 'order' => 3],
                ['name' => 'MULYADI', 'position' => 'KASI PELAYANAN', 'order' => 4],
                ['name' => 'SUBAKIR', 'position' => 'KAUR KEUANGAN', 'order' => 5],
                ['name' => 'MURSID GUNADI, S.H', 'position' => 'KADUS II', 'order' => 6],
                ['name' => 'AHMAD KHOIRONI, S.M', 'position' => 'KADUS III', 'order' => 7],
            ];
            $officials = collect($defaultList)->map(fn($item, $idx) => (object)[
                'id' => $idx + 1,
                'name' => $item['name'],
                'position' => $item['position'],
                'photo_path' => null,
                'order' => $item['order'],
            ]);
        }

        // Pimpinan / Pejabat Utama di urutan teratas (#1) sesuai urutan admin
        $headOfficial = $officials->first();

        // Perangkat desa lainnya mengikuti urutan berikutnya (#2, #3, dst)
        $otherOfficials = $officials->slice(1);

        return view('public.officials', compact('officials', 'headOfficial', 'otherOfficials'));
    }
}
