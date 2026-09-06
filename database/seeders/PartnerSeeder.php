<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            [
                'name' => 'Desa Cerdas Kemendes',
                'url' => 'https://kemendes.go.id',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Desa Wisata Boyolali',
                'url' => 'https://boyolali.go.id',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Padi Organik Wonotoro',
                'url' => null,
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Irigasi Waduk Wonotoro',
                'url' => null,
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Perpustakaan Daerah Boyolali',
                'url' => 'https://perpustakaan.boyolali.go.id',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Posyandu & PKK Catur',
                'url' => null,
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'SMKN 1 Sambi Boyolali',
                'url' => null,
                'order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'UMKM Beras & Herbal Catur',
                'url' => null,
                'order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($partners as $partnerData) {
            Partner::updateOrCreate(
                ['name' => $partnerData['name']],
                $partnerData
            );
        }
    }
}
