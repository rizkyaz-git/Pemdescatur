<?php

namespace Database\Seeders;

use App\Models\StatCategory;
use App\Models\VillageStat;
use Illuminate\Database\Seeder;

class VillageStatSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================================
        // KATEGORI & DATA STATISTIK DESA CATUR
        // Sumber: Dokumen Profil Desa Catur 2013-2018
        // =========================================================

        $categories = [
            // ---- DEMOGRAFI ----
            [
                'key' => 'mata_pencaharian', 'label' => 'Mata Pencaharian Penduduk',
                'chart_type' => 'bar', 'unit' => 'orang', 'section' => 'demografi', 'order' => 1,
                'stats' => [
                    ['label' => 'Petani', 'value' => 624, 'year' => null, 'order' => 1],
                    ['label' => 'Buruh Tani', 'value' => 342, 'year' => null, 'order' => 2],
                    ['label' => 'Buruh Swasta', 'value' => 186, 'year' => null, 'order' => 3],
                    ['label' => 'Pegawai Negeri', 'value' => 52, 'year' => null, 'order' => 4],
                    ['label' => 'Pedagang', 'value' => 98, 'year' => null, 'order' => 5],
                    ['label' => 'Peternak', 'value' => 45, 'year' => null, 'order' => 6],
                    ['label' => 'Pengrajin', 'value' => 28, 'year' => null, 'order' => 7],
                    ['label' => 'Lainnya', 'value' => 124, 'year' => null, 'order' => 8],
                ],
            ],
            [
                'key' => 'penggunaan_lahan', 'label' => 'Penggunaan Lahan',
                'chart_type' => 'pie', 'unit' => 'Ha', 'section' => 'geografis', 'order' => 2,
                'stats' => [
                    ['label' => 'Sawah Irigasi', 'value' => 128.50, 'year' => null, 'order' => 1],
                    ['label' => 'Tanah Kering/Tegalan', 'value' => 62.30, 'year' => null, 'order' => 2],
                    ['label' => 'Pekarangan/Bangunan', 'value' => 38.70, 'year' => null, 'order' => 3],
                    ['label' => 'Hutan Rakyat', 'value' => 8.20, 'year' => null, 'order' => 4],
                    ['label' => 'Fasilitas Umum/Sosial', 'value' => 6.82, 'year' => null, 'order' => 5],
                ],
            ],
            [
                'key' => 'kelompok_usia', 'label' => 'Penduduk per Kelompok Usia',
                'chart_type' => 'bar', 'unit' => 'orang', 'section' => 'demografi', 'order' => 3,
                'stats' => [
                    ['label' => '0-4 tahun', 'value' => 148, 'year' => null, 'order' => 1],
                    ['label' => '5-9 tahun', 'value' => 162, 'year' => null, 'order' => 2],
                    ['label' => '10-14 tahun', 'value' => 178, 'year' => null, 'order' => 3],
                    ['label' => '15-19 tahun', 'value' => 192, 'year' => null, 'order' => 4],
                    ['label' => '20-24 tahun', 'value' => 185, 'year' => null, 'order' => 5],
                    ['label' => '25-29 tahun', 'value' => 196, 'year' => null, 'order' => 6],
                    ['label' => '30-34 tahun', 'value' => 204, 'year' => null, 'order' => 7],
                    ['label' => '35-39 tahun', 'value' => 198, 'year' => null, 'order' => 8],
                    ['label' => '40-44 tahun', 'value' => 176, 'year' => null, 'order' => 9],
                    ['label' => '45-49 tahun', 'value' => 148, 'year' => null, 'order' => 10],
                    ['label' => '50-54 tahun', 'value' => 124, 'year' => null, 'order' => 11],
                    ['label' => '55-59 tahun', 'value' => 98, 'year' => null, 'order' => 12],
                    ['label' => '60+ tahun', 'value' => 184, 'year' => null, 'order' => 13],
                ],
            ],
            [
                'key' => 'ternak', 'label' => 'Populasi Ternak',
                'chart_type' => 'bar', 'unit' => 'ekor', 'section' => 'demografi', 'order' => 4,
                'stats' => [
                    ['label' => 'Ayam Potong', 'value' => 12500, 'year' => null, 'order' => 1],
                    ['label' => 'Kambing', 'value' => 348, 'year' => null, 'order' => 2],
                    ['label' => 'Sapi', 'value' => 124, 'year' => null, 'order' => 3],
                    ['label' => 'Bebek/Itik', 'value' => 256, 'year' => null, 'order' => 4],
                    ['label' => 'Ikan (kolam)', 'value' => 8400, 'year' => null, 'order' => 5],
                ],
            ],

            // ---- KESEHATAN ----
            [
                'key' => 'kb_akseptor', 'label' => 'Akseptor KB per Metode',
                'chart_type' => 'pie', 'unit' => 'orang', 'section' => 'kesehatan', 'order' => 5,
                'stats' => [
                    ['label' => 'Suntik', 'value' => 186, 'year' => null, 'order' => 1],
                    ['label' => 'Pil', 'value' => 142, 'year' => null, 'order' => 2],
                    ['label' => 'IUD', 'value' => 78, 'year' => null, 'order' => 3],
                    ['label' => 'Implant', 'value' => 54, 'year' => null, 'order' => 4],
                    ['label' => 'Lainnya', 'value' => 32, 'year' => null, 'order' => 5],
                ],
            ],

            // ---- EKONOMI ----
            [
                'key' => 'apbdes_pendapatan', 'label' => 'APBDes – Pendapatan',
                'chart_type' => 'line', 'unit' => 'juta Rp', 'section' => 'ekonomi', 'order' => 6,
                'stats' => [
                    ['label' => 'Pendapatan', 'value' => 742.50, 'year' => 2013, 'order' => 1],
                    ['label' => 'Pendapatan', 'value' => 812.00, 'year' => 2014, 'order' => 2],
                    ['label' => 'Pendapatan', 'value' => 986.30, 'year' => 2015, 'order' => 3],
                    ['label' => 'Pendapatan', 'value' => 1243.80, 'year' => 2016, 'order' => 4],
                    ['label' => 'Pendapatan', 'value' => 1512.40, 'year' => 2017, 'order' => 5],
                    ['label' => 'Pendapatan', 'value' => 1678.90, 'year' => 2018, 'order' => 6],
                ],
            ],
            [
                'key' => 'apbdes_belanja', 'label' => 'APBDes – Belanja',
                'chart_type' => 'line', 'unit' => 'juta Rp', 'section' => 'ekonomi', 'order' => 7,
                'stats' => [
                    ['label' => 'Belanja', 'value' => 718.20, 'year' => 2013, 'order' => 1],
                    ['label' => 'Belanja', 'value' => 796.50, 'year' => 2014, 'order' => 2],
                    ['label' => 'Belanja', 'value' => 942.60, 'year' => 2015, 'order' => 3],
                    ['label' => 'Belanja', 'value' => 1198.30, 'year' => 2016, 'order' => 4],
                    ['label' => 'Belanja', 'value' => 1480.00, 'year' => 2017, 'order' => 5],
                    ['label' => 'Belanja', 'value' => 1652.40, 'year' => 2018, 'order' => 6],
                ],
            ],

            // ---- INFRASTRUKTUR ----
            [
                'key' => 'kondisi_jalan', 'label' => 'Kondisi Jalan Desa',
                'chart_type' => 'stacked_bar', 'unit' => 'km', 'section' => 'infrastruktur', 'order' => 8,
                'stats' => [
                    ['label' => 'Aspal', 'value' => 4.2, 'year' => null, 'sub_group' => 'Baik', 'order' => 1],
                    ['label' => 'Aspal', 'value' => 1.8, 'year' => null, 'sub_group' => 'Sedang', 'order' => 2],
                    ['label' => 'Aspal', 'value' => 0.6, 'year' => null, 'sub_group' => 'Rusak', 'order' => 3],
                    ['label' => 'Diperkeras', 'value' => 2.4, 'year' => null, 'sub_group' => 'Baik', 'order' => 4],
                    ['label' => 'Diperkeras', 'value' => 1.2, 'year' => null, 'sub_group' => 'Sedang', 'order' => 5],
                    ['label' => 'Diperkeras', 'value' => 0.8, 'year' => null, 'sub_group' => 'Rusak', 'order' => 6],
                    ['label' => 'Tanah', 'value' => 0.6, 'year' => null, 'sub_group' => 'Baik', 'order' => 7],
                    ['label' => 'Tanah', 'value' => 1.4, 'year' => null, 'sub_group' => 'Sedang', 'order' => 8],
                    ['label' => 'Tanah', 'value' => 2.2, 'year' => null, 'sub_group' => 'Rusak', 'order' => 9],
                ],
            ],

            // ---- PEMERINTAHAN ----
            [
                'key' => 'pelayanan_publik', 'label' => 'Pelayanan Publik per Tahun',
                'chart_type' => 'line', 'unit' => 'permohonan', 'section' => 'pemerintahan', 'order' => 9,
                'stats' => [
                    ['label' => 'KTP', 'value' => 142, 'year' => 2013, 'order' => 1],
                    ['label' => 'KTP', 'value' => 164, 'year' => 2014, 'order' => 2],
                    ['label' => 'KTP', 'value' => 198, 'year' => 2015, 'order' => 3],
                    ['label' => 'KTP', 'value' => 187, 'year' => 2016, 'order' => 4],
                    ['label' => 'KTP', 'value' => 201, 'year' => 2017, 'order' => 5],
                    ['label' => 'KTP', 'value' => 218, 'year' => 2018, 'order' => 6],
                    ['label' => 'KK', 'value' => 86, 'year' => 2013, 'order' => 7],
                    ['label' => 'KK', 'value' => 94, 'year' => 2014, 'order' => 8],
                    ['label' => 'KK', 'value' => 108, 'year' => 2015, 'order' => 9],
                    ['label' => 'KK', 'value' => 112, 'year' => 2016, 'order' => 10],
                    ['label' => 'KK', 'value' => 124, 'year' => 2017, 'order' => 11],
                    ['label' => 'KK', 'value' => 118, 'year' => 2018, 'order' => 12],
                    ['label' => 'Akta', 'value' => 38, 'year' => 2013, 'order' => 13],
                    ['label' => 'Akta', 'value' => 42, 'year' => 2014, 'order' => 14],
                    ['label' => 'Akta', 'value' => 56, 'year' => 2015, 'order' => 15],
                    ['label' => 'Akta', 'value' => 61, 'year' => 2016, 'order' => 16],
                    ['label' => 'Akta', 'value' => 74, 'year' => 2017, 'order' => 17],
                    ['label' => 'Akta', 'value' => 82, 'year' => 2018, 'order' => 18],
                ],
            ],
            [
                'key' => 'tempat_ibadah', 'label' => 'Tempat Ibadah',
                'chart_type' => 'pie', 'unit' => 'unit', 'section' => 'sosial', 'order' => 10,
                'stats' => [
                    ['label' => 'Masjid', 'value' => 8, 'year' => null, 'order' => 1],
                    ['label' => 'Musholla', 'value' => 18, 'year' => null, 'order' => 2],
                    ['label' => 'Gereja', 'value' => 1, 'year' => null, 'order' => 3],
                ],
            ],
        ];

        foreach ($categories as $catData) {
            $stats = $catData['stats'];
            unset($catData['stats']);

            $category = StatCategory::updateOrCreate(
                ['key' => $catData['key']],
                $catData
            );

            foreach ($stats as $statData) {
                VillageStat::updateOrCreate(
                    [
                        'category_id' => $category->id,
                        'label'       => $statData['label'],
                        'year'        => $statData['year'] ?? null,
                        'sub_group'   => $statData['sub_group'] ?? null,
                    ],
                    $statData + ['category_id' => $category->id]
                );
            }
        }
    }
}
