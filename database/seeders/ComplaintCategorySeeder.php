<?php

namespace Database\Seeders;

use App\Models\ComplaintCategory;
use Illuminate\Database\Seeder;

class ComplaintCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Infrastruktur', 'description' => 'Pengaduan terkait jalan, jembatan, gorong-gorong, dll'],
            ['name' => 'Layanan Publik', 'description' => 'Pengaduan terkait pelayanan publik pemerintah desa'],
            ['name' => 'Keamanan & Ketertiban', 'description' => 'Pengaduan terkait keamanan dan ketertiban masyarakat'],
            ['name' => 'Kesehatan', 'description' => 'Pengaduan terkait kesehatan dan sanitasi'],
            ['name' => 'Pendidikan', 'description' => 'Pengaduan terkait sektor pendidikan'],
            ['name' => 'Lingkungan', 'description' => 'Pengaduan terkait lingkungan hidup'],
            ['name' => 'Sosial', 'description' => 'Pengaduan terkait masalah sosial kemasyarakatan'],
            ['name' => 'Lainnya', 'description' => 'Pengaduan lainnya yang tidak masuk kategori di atas'],
        ];

        foreach ($categories as $category) {
            ComplaintCategory::firstOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}
