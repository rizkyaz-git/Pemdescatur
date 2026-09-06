<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        Location::truncate();

        // Balai Kantor Desa Catur, Sambi, Boyolali, Jawa Tengah
        Location::create([
            'name' => 'Kantor Desa Catur',
            'latitude' => -7.48331200,
            'longitude' => 110.70014500,
            'description' => 'Kantor Pusat Pemerintahan Desa Catur, Kecamatan Sambi, Kabupaten Boyolali, Jawa Tengah 57376.',
            'is_primary' => true,
        ]);

        Location::create([
            'name' => 'Lapangan Desa Catur',
            'latitude' => -7.48280000,
            'longitude' => 110.70210000,
            'description' => 'Lapangan olahraga dan kegiatan warga Desa Catur.',
            'is_primary' => false,
        ]);

        Location::create([
            'name' => 'Warung Mie Ayam & Bakso Mas Adi',
            'latitude' => -7.48510000,
            'longitude' => 110.69940000,
            'description' => 'Kuliner lokal UMKM kuliner favorit di Desa Catur.',
            'is_umkm' => true,
        ]);

        Location::create([
            'name' => 'SD Negeri 1 Catur',
            'latitude' => -7.48420000,
            'longitude' => 110.70150000,
            'description' => 'Sekolah Dasar Negeri 1 Desa Catur, Kec. Sambi, Kab. Boyolali.',
            'is_education' => true,
        ]);

        Location::create([
            'name' => 'PAUD & TK Pertiwi Catur',
            'latitude' => -7.48210000,
            'longitude' => 110.69890000,
            'description' => 'Taman Kanak-kanak & PAUD Desa Catur.',
            'is_education' => true,
        ]);
    }
}
