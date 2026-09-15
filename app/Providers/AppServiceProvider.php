<?php

namespace App\Providers;

use App\Models\Setting;
use App\Events\LaporanDiperbarui;
use App\Listeners\KirimNotifikasiEmailPelapor;
use App\Models\Laporan;
use App\Policies\LaporanPolicy;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Explicit registration keeps queued notification delivery reliable even when event
        // auto-discovery is disabled in a production deployment.
        Event::listen(LaporanDiperbarui::class, KirimNotifikasiEmailPelapor::class);
        Gate::policy(Laporan::class, LaporanPolicy::class);
        Carbon::setLocale('id');

        View::composer('*', function ($view) {
            static $globalData = null;

            if ($globalData === null) {
                try {
                    if (Schema::hasTable('settings')) {
                        $allSettings = Setting::all()->pluck('value', 'key')->all();
                        $globalLogo = $allSettings['village_logo_path'] ?? null;

                        $siteFavicon = ($globalLogo && Storage::disk('public')->exists($globalLogo))
                            ? asset('storage/' . $globalLogo)
                            : (file_exists(public_path('favicon.png')) ? asset('favicon.png') : (file_exists(public_path('images/logo_catur.png')) ? asset('images/logo_catur.png') : asset('favicon.ico')));

                        $globalData = [
                            'globalLogo' => $globalLogo,
                            'siteFavicon' => $siteFavicon,
                            'globalHeroImage' => $allSettings['hero_image_path'] ?? null,
                            'globalVillageName' => $allSettings['village_name'] ?? 'Pemerintah Desa Catur',
                            'globalLibraryUrl' => $allSettings['library_url'] ?? 'https://perpustakaan.boyolali.go.id',
                            'globalInstagram' => $allSettings['village_instagram'] ?? 'https://www.instagram.com/pemerintahdesacatur',
                            'globalPhone' => $allSettings['village_phone'] ?? '0812-3456-7890',
                            'globalEmail' => $allSettings['village_email'] ?? 'pemerintahdesacatur@gmail.com',
                            'globalAddress' => $allSettings['village_address'] ?? 'Jl. Raya Catur - Sambi, Desa Catur, Kec. Sambi, Kab. Boyolali, Jawa Tengah 57376',
                        ];
                    } else {
                        $globalData = [];
                    }
                } catch (\Throwable $e) {
                    $globalData = [];
                }
            }

            if (!empty($globalData)) {
                $view->with($globalData);
            }
        });
    }
}
