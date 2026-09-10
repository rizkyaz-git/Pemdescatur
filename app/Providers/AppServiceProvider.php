<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Carbon::setLocale('id');

        View::composer('*', function ($view) {
            static $globalData = null;

            if ($globalData === null) {
                try {
                    if (Schema::hasTable('settings')) {
                        $allSettings = Setting::all()->pluck('value', 'key')->all();

                        $globalData = [
                            'globalLogo' => $allSettings['village_logo_path'] ?? null,
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
