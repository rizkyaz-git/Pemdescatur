<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\GaleriFoto;
use App\Models\Kegiatan;
use App\Models\Kurikulum;
use App\Models\News;
use App\Models\Partner;
use App\Models\Pojok;
use App\Models\VillageProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PpkoController extends Controller
{
    /**
     * Display the public landing page for PPKO Catur Cerdas UMS 2026.
     */
    public function index(Request $request): View
    {
        $profile = VillageProfile::first();
        $partners = Partner::where('is_active', true)->orderBy('order')->get();
        $recentNews = News::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // 5 Pilar Pojok Pemberdayaan beserta kegiatan dan kurikulum masing-masing
        $pojoks = Pojok::with([
            'kegiatans' => fn($q) => $q->latest('tanggal_kegiatan'),
            'kegiatans.galeriFotos',
            'kurikulums' => fn($q) => $q->latest(),
        ])->orderBy('id')->get();

        // Galeri foto dokumentasi komprehensif untuk section galeri foto lapangan
        $galeriFotos = GaleriFoto::with(['kegiatan.pojok'])
            ->latest()
            ->take(12)
            ->get();

        return view('public.ppko', compact(
            'profile',
            'partners',
            'recentNews',
            'pojoks',
            'galeriFotos'
        ));
    }

    /**
     * Download curriculum document.
     */
    public function downloadKurikulum(Kurikulum $kurikulum): StreamedResponse
    {
        if (!Storage::disk('public')->exists($kurikulum->file_path)) {
            abort(404, 'File kurikulum tidak ditemukan di penyimpanan server.');
        }

        return Storage::disk('public')->download($kurikulum->file_path, $kurikulum->file_name);
    }
}
