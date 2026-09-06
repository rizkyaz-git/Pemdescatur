<?php

namespace Database\Seeders;

use App\Models\Statistic;
use Illuminate\Database\Seeder;

class StatisticSeeder extends Seeder
{
    public function run(): void
    {
        Statistic::truncate();

        // Kependudukan & Wilayah
        Statistic::create([
            'category' => 'Wilayah & Penduduk',
            'label' => 'Pedukuhan (Dusun)',
            'value' => '13',
            'unit' => 'Dusun',
            'period' => '2026',
            'order' => 1,
        ]);

        Statistic::create([
            'category' => 'Wilayah & Penduduk',
            'label' => 'Frekuensi Panen Padi',
            'value' => '3',
            'unit' => 'Kali / Tahun',
            'period' => '2026',
            'order' => 2,
        ]);

        // Sarana Pendidikan
        Statistic::create([
            'category' => 'Pendidikan',
            'label' => 'Taman Kanak-Kanak (TK)',
            'value' => '3',
            'unit' => 'Sekolah (TK Islam Kyai Mojo, Wonotoro, Pertiwi)',
            'period' => '2026',
            'order' => 1,
        ]);

        Statistic::create([
            'category' => 'Pendidikan',
            'label' => 'Sekolah Dasar (SD/MI)',
            'value' => '3',
            'unit' => 'Sekolah (SDN Inpres Catur, SDN Wonotoro, MIN Wonotoro)',
            'period' => '2026',
            'order' => 2,
        ]);

        Statistic::create([
            'category' => 'Pendidikan',
            'label' => 'SMP & SMA/SMK',
            'value' => '2',
            'unit' => 'Sekolah (MTsN Wonotoro & SMKN 1 Sambi)',
            'period' => '2026',
            'order' => 3,
        ]);

        // Sektor Wisata & Ekonomi
        Statistic::create([
            'category' => 'Wisata & Ekonomi',
            'label' => 'Status Desa Wisata',
            'value' => '2022',
            'unit' => 'Tahun Penetapan Desa Wisata Boyolali',
            'period' => '2026',
            'order' => 1,
        ]);
    }
}
