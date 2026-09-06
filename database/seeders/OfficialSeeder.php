<?php

namespace Database\Seeders;

use App\Models\Official;
use Illuminate\Database\Seeder;

class OfficialSeeder extends Seeder
{
    public function run(): void
    {
        Official::truncate();

        // Level 1: Kepala Desa Catur
        $kades = Official::create([
            'name' => 'Dra. NUNIK S RAHAYU, M.Pd',
            'position' => 'Kepala Desa Catur (Periode 2019 - 2025)',
            'order' => 1,
            'phone' => '0812-3456-7890',
            'email' => 'kades@desacatur-boyolali.id',
        ]);

        // Level 2: Sekretaris Desa (Parent: Kades)
        $sekdes = Official::create([
            'name' => 'Bambang Sugeng, S.Sos.',
            'position' => 'Sekretaris Desa',
            'parent_id' => $kades->id,
            'order' => 1,
            'phone' => '0812-3456-7891',
            'email' => 'sekdes@desacatur-boyolali.id',
        ]);

        // Level 3: Kepala Seksi & Urusan (Parent: Sekdes)
        Official::create([
            'name' => 'Siti Rahmawati, A.Md.',
            'position' => 'Kaur Keuangan',
            'parent_id' => $sekdes->id,
            'order' => 1,
        ]);

        Official::create([
            'name' => 'Tri Santoso, S.T.',
            'position' => 'Kaur Perencanaan & Umum',
            'parent_id' => $sekdes->id,
            'order' => 2,
        ]);

        Official::create([
            'name' => 'Agus Priyono',
            'position' => 'Kasi Pemerintahan',
            'parent_id' => $sekdes->id,
            'order' => 3,
        ]);

        Official::create([
            'name' => 'Endang Lestari, S.Pd.',
            'position' => 'Kasi Kesejahteraan & Pelayanan',
            'parent_id' => $sekdes->id,
            'order' => 4,
        ]);

        // Level 4: Kepala Dusun / Kadus Pedukuhan (Parent: Kades)
        Official::create([
            'name' => 'Joko Susilo',
            'position' => 'Kadus I (Pedukuhan Catur & Sabrangan)',
            'parent_id' => $kades->id,
            'order' => 10,
        ]);

        Official::create([
            'name' => 'Suryanto',
            'position' => 'Kadus II (Pedukuhan Wonotoro & Kragan)',
            'parent_id' => $kades->id,
            'order' => 11,
        ]);

        Official::create([
            'name' => 'Supriyadi',
            'position' => 'Kadus III (Pedukuhan Karakan & Tropayan)',
            'parent_id' => $kades->id,
            'order' => 12,
        ]);
    }
}
