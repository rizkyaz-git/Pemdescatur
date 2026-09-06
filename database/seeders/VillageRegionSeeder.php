<?php

namespace Database\Seeders;

use App\Models\VillageRegion;
use Illuminate\Database\Seeder;

class VillageRegionSeeder extends Seeder
{
    public function run(): void
    {
        $regions = [
            // Kadus I
            ['kadus' => 1, 'nama_dukuh' => 'Catur',       'luas_ha' => 24.80, 'keterangan' => 'Pusat desa, lokasi kantor desa', 'order' => 1],
            ['kadus' => 1, 'nama_dukuh' => 'Sabrangan',   'luas_ha' => 18.60, 'keterangan' => 'Dekat jalur utama', 'order' => 2],
            ['kadus' => 1, 'nama_dukuh' => 'Karakan',     'luas_ha' => 16.40, 'keterangan' => 'Area pertanian aktif', 'order' => 3],
            ['kadus' => 1, 'nama_dukuh' => 'Gunung Puyuh','luas_ha' => 21.20, 'keterangan' => 'Dataran tinggi, view panoramik', 'order' => 4],
            // Kadus II
            ['kadus' => 2, 'nama_dukuh' => 'Gumuk Ngembes','luas_ha' => 19.50, 'keterangan' => 'Area persawahan', 'order' => 5],
            ['kadus' => 2, 'nama_dukuh' => 'Tropayan',    'luas_ha' => 17.80, 'keterangan' => 'Daerah irigasi Waduk Wonotoro', 'order' => 6],
            ['kadus' => 2, 'nama_dukuh' => 'Giring',      'luas_ha' => 14.30, 'keterangan' => 'Pemukiman padat', 'order' => 7],
            ['kadus' => 2, 'nama_dukuh' => 'Karang Jowo', 'luas_ha' => 20.10, 'keterangan' => 'Area pertanian campur', 'order' => 8],
            ['kadus' => 2, 'nama_dukuh' => 'Bakalan',     'luas_ha' => 15.60, 'keterangan' => 'Potensi UMKM', 'order' => 9],
            // Kadus III
            ['kadus' => 3, 'nama_dukuh' => 'Kragan',      'luas_ha' => 18.90, 'keterangan' => 'Dekat sumber air Umbul Siraman', 'order' => 10],
            ['kadus' => 3, 'nama_dukuh' => 'Wonotoro',    'luas_ha' => 22.40, 'keterangan' => 'Lokasi Waduk Wonotoro', 'order' => 11],
            ['kadus' => 3, 'nama_dukuh' => 'Gumuk Rejo',  'luas_ha' => 16.75, 'keterangan' => 'Dukuh terluar timur', 'order' => 12],
            ['kadus' => 3, 'nama_dukuh' => 'Kungon',      'luas_ha' => 18.12, 'keterangan' => 'Dekat batas desa barat', 'order' => 13],
        ];

        foreach ($regions as $region) {
            VillageRegion::updateOrCreate(
                ['nama_dukuh' => $region['nama_dukuh']],
                $region
            );
        }
    }
}
