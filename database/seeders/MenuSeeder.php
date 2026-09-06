<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::truncate();

        Menu::create([
            'label' => 'Beranda',
            'slug_or_url' => '/',
            'order' => 1,
            'is_active' => true,
            'is_external' => false,
        ]);

        Menu::create([
            'label' => 'Profil Desa',
            'slug_or_url' => '/profil',
            'order' => 2,
            'is_active' => true,
            'is_external' => false,
        ]);

        $layananMenu = Menu::create([
            'label' => 'Layanan',
            'slug_or_url' => '/layanan',
            'order' => 3,
            'is_active' => true,
            'is_external' => false,
        ]);

        Menu::create([
            'label' => 'Pusat Layanan Desa',
            'slug_or_url' => '/layanan',
            'order' => 1,
            'is_active' => true,
            'is_external' => false,
            'parent_id' => $layananMenu->id,
        ]);

        Menu::create([
            'label' => 'Surat Online Mandiri',
            'slug_or_url' => '/layanan/surat',
            'order' => 2,
            'is_active' => true,
            'is_external' => false,
            'parent_id' => $layananMenu->id,
        ]);

        Menu::create([
            'label' => 'Pengaduan & Aspirasi',
            'slug_or_url' => '/layanan/pengaduan',
            'order' => 3,
            'is_active' => true,
            'is_external' => false,
            'parent_id' => $layananMenu->id,
        ]);

        Menu::create([
            'label' => 'Struktur Pemerintahan',
            'slug_or_url' => '/struktur',
            'order' => 4,
            'is_active' => true,
            'is_external' => false,
        ]);

        Menu::create([
            'label' => 'Berita & Pengumuman',
            'slug_or_url' => '/berita',
            'order' => 5,
            'is_active' => true,
            'is_external' => false,
        ]);

        Menu::create([
            'label' => 'Statistik Desa',
            'slug_or_url' => '/statistik',
            'order' => 6,
            'is_active' => true,
            'is_external' => false,
        ]);

        Menu::create([
            'label' => 'Galeri Foto',
            'slug_or_url' => '/galeri',
            'order' => 7,
            'is_active' => true,
            'is_external' => false,
        ]);

        Menu::create([
            'label' => 'Kontak & Lokasi',
            'slug_or_url' => '/kontak',
            'order' => 8,
            'is_active' => true,
            'is_external' => false,
        ]);
    }
}
