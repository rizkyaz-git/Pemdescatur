<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Location;
use App\Models\News;
use App\Models\Official;
use App\Models\Partner;
use App\Models\Setting;
use App\Models\VillageProfile;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $profile = VillageProfile::first();
        $latestNews = News::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(4)
            ->get();
        $galleries = Gallery::latest()->take(4)->get();
        $partners = Partner::where('is_active', true)->orderBy('order', 'asc')->get();
        $officials = Official::orderBy('order', 'asc')->take(8)->get();
        $locations = Location::all();
        $primaryLocation = Location::where('is_primary', true)->first() ?? Location::first();
        $libraryUrl = Setting::get('library_url', 'https://perpustakaan.boyolali.go.id');
        $libraryDesktopImage = Setting::get('library_desktop_image_path');
        $libraryTabletImage = Setting::get('library_tablet_image_path');
        $libraryMobileImage = Setting::get('library_mobile_image_path');

        return view('public.home', compact('profile', 'latestNews', 'galleries', 'partners', 'officials', 'locations', 'primaryLocation', 'libraryUrl', 'libraryDesktopImage', 'libraryTabletImage', 'libraryMobileImage'));
    }
}
