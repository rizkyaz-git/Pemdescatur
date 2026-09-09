<?php

namespace Database\Seeders;

use App\Models\Official;
use Illuminate\Database\Seeder;

class OfficialSeeder extends Seeder
{
    public function run(): void
    {
        Official::truncate();

        // 1: Kepala Desa Catur
        Official::create([
            'name' => 'Dra. NUNIK S RAHAYU, M.Pd',
            'position' => 'Kepala Desa Catur (Periode 2019 - 2025)',
            'order' => 1,
            'phone' => '0812-3456-7890',
            'email' => 'kades@desacatur-boyolali.id',
        ]);

        // 2: Sekretaris Desa
        Official::create([
            'name' => 'Bambang Sugeng, S.Sos.',
            'position' => 'Sekretaris Desa',
            'order' => 2,
            'phone' => '0812-3456-7891',
            'email' => 'sekdes@desacatur-boyolali.id',
        ]);

        // 3: Kepala Seksi & Urusan
        Official::create([
            'name' => 'Siti Rahmawati, A.Md.',
            'position' => 'Kaur Keuangan',
            'order' => 3,
        ]);

        Official::create([
            'name' => 'Tri Santoso, S.T.',
            'position' => 'Kaur Perencanaan & Umum',
            'order' => 4,
        ]);

        Official::create([
            'name' => 'Agus Priyono',
            'position' => 'Kasi Pemerintahan',
            'order' => 5,
        ]);

        Official::create([
            'name' => 'Endang Lestari, S.Pd.',
            'position' => 'Kasi Kesejahteraan & Pelayanan',
            'order' => 6,
        ]);

        // 4: Kepala Dusun / Kadus Pedukuhan
        Official::create([
            'name' => 'Joko Susilo',
            'position' => 'Kadus I (Pedukuhan Catur & Sabrangan)',
            'order' => 7,
        ]);

        Official::create([
            'name' => 'Suryanto',
            'position' => 'Kadus II (Pedukuhan Wonotoro & Kragan)',
            'order' => 8,
        ]);

        Official::create([
            'name' => 'Supriyadi',
            'position' => 'Kadus III (Pedukuhan Karakan & Tropayan)',
            'order' => 9,
        ]);
    }
}
