<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\StatCategory;
use App\Models\Statistic;
use App\Models\VillageProfile;
use App\Models\VillageRegion;
use Illuminate\View\View;

class StatisticController extends Controller
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

        $groupedStats = Statistic::orderBy('order', 'asc')
            ->get()
            ->groupBy('category');

        return view('public.statistics', compact(
            'profile',
            'categories',
            'regions',
            'apbdesYears',
            'apbdesPendapatan',
            'apbdesBelanja',
            'groupedStats'
        ));
    }
}

