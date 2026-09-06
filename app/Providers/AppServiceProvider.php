<?php

namespace App\Providers;

use App\Models\Menu;
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
                    if (Schema::hasTable('menus') && Schema::hasTable('settings')) {
                        $allSettings = Setting::all()->pluck('value', 'key');

                        $globalMenus = Menu::where('is_active', true)
                            ->whereNull('parent_id')
                            ->with(['children' => function ($q) {
                                $q->where('is_active', true)->orderBy('order', 'asc');
                            }])
                            ->orderBy('order', 'asc')
                            ->get();

                        $globalData = [
                            'globalMenus' => $globalMenus,
                            'globalLogo' => $allSettings->get('village_logo_path'),
                            'globalHeroImage' => $allSettings->get('hero_image_path'),
                            'globalVillageName' => $allSettings->get('village_name', 'Pemerintah Desa Catur'),
                            'globalLibraryUrl' => $allSettings->get('library_url', 'https://perpustakaan.boyolali.go.id'),
                            'globalPhone' => $allSettings->get('village_phone', '0812-3456-7890'),
                            'globalEmail' => $allSettings->get('village_email', 'info@desacatur.id'),
                            'globalAddress' => $allSettings->get('village_address', 'Jl. Raya Catur - Sambi, Desa Catur, Kec. Sambi, Kab. Boyolali, Jawa Tengah 57376'),
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

