<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        Gallery::truncate();

        Gallery::create([
            'title' => 'Dokumentasi Panen Kopi Kintamani Desa Catur',
            'image_path' => 'galleries/kopi-catur.jpg',
            'description' => 'Aktivitas peretikan biji kopi merah organik di perkebunan Desa Catur.',
            'published_at' => now()->subDays(3),
        ]);

        Gallery::create([
            'title' => 'Gotong Royong Pembersihan Saluran Irigasi Desa',
            'image_path' => 'galleries/gotong-royong.jpg',
            'description' => 'Kebersamaan warga Desa Catur merawat saluran air pendukung lahan pertanian.',
            'published_at' => now()->subDays(8),
        ]);

        Gallery::create([
            'title' => 'Pelatihan Literasi Digital & Pojok Baca Desa',
            'image_path' => 'galleries/literasi-desa.jpg',
            'description' => 'Sosialisasi pemanfaatan tautan Perpustakaan Daerah bagi anak sekolah Desa Catur.',
            'published_at' => now()->subDays(15),
        ]);
    }
}
