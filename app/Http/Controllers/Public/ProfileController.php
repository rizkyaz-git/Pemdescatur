<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Official;
use App\Models\StatCategory;
use App\Models\VillageProfile;
use App\Models\VillageRegion;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        $profile = VillageProfile::first();

        // Load semua kategori statistik beserta datanya, group per section
        $categories = StatCategory::with(['stats' => function ($q) {
            $q->orderBy('order')->orderBy('year');
        }])->orderBy('order')->get()->groupBy('section');

        // Load data dukuh, group per Kadus
        $regions = VillageRegion::orderBy('kadus')->orderBy('order')->get()->groupBy('kadus');

        // Pimpinan / Kepala Desa
        $kades = Official::where('order', 1)->first() ?? Official::first();

        // APBDes: pisahkan pendapatan & belanja dan group per tahun untuk line chart
        $apbdesYears    = [];
        $apbdesPendapatan = [];
        $apbdesBelanja  = [];
        if (isset($categories['ekonomi'])) {
            $pendapatanCat = $categories['ekonomi']->firstWhere('key', 'apbdes_pendapatan');
            $belanjaCat    = $categories['ekonomi']->firstWhere('key', 'apbdes_belanja');
            if ($pendapatanCat) {
                foreach ($pendapatanCat->stats as $s) {
                    $apbdesYears[]      = $s->year;
                    $apbdesPendapatan[] = $s->value;
                }
            }
            if ($belanjaCat) {
                foreach ($belanjaCat->stats as $s) {
                    $apbdesBelanja[] = $s->value;
                }
            }
        }

        return view('public.profile', compact(
            'profile',
            'categories',
            'regions',
            'kades',
            'apbdesYears',
            'apbdesPendapatan',
            'apbdesBelanja'
        ));
    }
}
