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
            LocationSeeder::class,
            MenuSeeder::class,
            SettingSeeder::class,
            PartnerSeeder::class,
            // Phase 1 Seeders
            ComplaintCategorySeeder::class,
            LetterTemplateSeeder::class,
            SamplePublicServicesSeeder::class,
            // PPKO Catur Cerdas Seeder
            PojokSeeder::class,
        ]);
    }
}
