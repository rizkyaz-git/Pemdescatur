<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Partner;
use App\Models\VillageProfile;
use Illuminate\View\View;

class PpkoController extends Controller
{
    public function index(): View
    {
        $profile = VillageProfile::first();
        $partners = Partner::where('is_active', true)->orderBy('order')->get();
        $recentNews = News::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('public.ppko', compact('profile', 'partners', 'recentNews'));
    }
}
