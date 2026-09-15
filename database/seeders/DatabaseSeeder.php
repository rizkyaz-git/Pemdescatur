<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            VillageProfileSeeder::class,
            VillageRegionSeeder::class,
            OfficialSeeder::class,
            NewsSeeder::class,
            GallerySeeder::class,
            SettingSeeder::class,
            // Phase 1 Seeders
            // ComplaintCategorySeeder dihapus (tabel sudah tidak ada, kategori kini string di tabel laporans)
            LetterTemplateSeeder::class,
            SamplePublicServicesSeeder::class,
            // PPKO Catur Cerdas Seeder
            PojokSeeder::class,
        ]);
    }
}
