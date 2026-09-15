<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Seed existing categories from news table + defaults
        $existing = DB::table('news')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category')
            ->toArray();

        $defaultCategories = array_unique(array_merge(['Berita', 'Pengumuman', 'Kegiatan', 'PPK Ormawa'], $existing));

        foreach ($defaultCategories as $categoryName) {
            $name = trim($categoryName);
            if ($name !== '') {
                DB::table('news_categories')->insertOrIgnore([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('news_categories');
    }
};
