<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('village_name', 'Pemerintah Desa Catur');
        Setting::set('village_district', 'Kecamatan Sambi, Kabupaten Boyolali, Jawa Tengah');
        Setting::set('village_address', 'Jl. Raya Catur - Sambi, Desa Catur, Kec. Sambi, Kab. Boyolali, Jawa Tengah 57376');
        Setting::set('village_instagram', 'https://www.instagram.com/pemdescatur');
        Setting::set('village_phone', '0812-3456-7890');
        Setting::set('village_email', 'pemerintahdesacatur@gmail.com');
        Setting::set('library_url', 'https://perpustakaan.boyolali.go.id');
        Setting::set('village_logo_path', null);
        Setting::set('hero_title', 'Selamat Datang di Portal Resmi Desa Catur');
        Setting::set('hero_subtitle', 'Pusat Informasi Terpadu, Desa Wisata Boyolali, Pertanian Padi Organik & Desa Cerdas Kemendes');
    }
}
