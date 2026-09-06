<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Family;
use App\Models\Resident;
use App\Models\LetterTemplate;
use App\Models\LetterRequest;
use App\Models\ComplaintCategory;
use App\Models\Complaint;
use Illuminate\Database\Seeder;

class SamplePublicServicesSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create sample warga user
        $wargaUser = User::firstOrCreate(
            ['email' => 'warga@desacatur.id'],
            [
                'name' => 'Budi Santoso',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ]
        );

        $adminUser = User::where('email', 'admin@desacatur.id')->first() ?? $wargaUser;

        // Sample Family
        $family = Family::firstOrCreate(
            ['kk_number' => '3309120101260001'],
            [
                'head_of_family' => 'Budi Santoso',
                'address' => 'Dukuh Catur RT 02 / RW 01',
                'total_members' => 2,
            ]
        );

        // Sample Residents
        Resident::firstOrCreate(
            ['nik' => '3309121508850001'],
            [
                'family_id' => $family->id,
                'name' => 'Budi Santoso',
                'birth_place' => 'Boyolali',
                'birth_date' => '1985-08-15',
                'gender' => 'L',
                'relationship_to_head' => 'Kepala Keluarga',
                'status' => 'hidup',
            ]
        );

        Resident::firstOrCreate(
            ['nik' => '3309125204880002'],
            [
                'family_id' => $family->id,
                'name' => 'Siti Rahmawati',
                'birth_place' => 'Boyolali',
                'birth_date' => '1988-04-12',
                'gender' => 'P',
                'relationship_to_head' => 'Istri',
                'status' => 'hidup',
            ]
        );

        // Sample Letter Template (Ensure SKU exists)
        $skuTemplate = LetterTemplate::where('code', 'SKU')->first();

        if ($skuTemplate) {
            LetterRequest::firstOrCreate(
                ['ticket_number' => 'TKT-202609-00001'],
                [
                    'user_id' => $wargaUser->id,
                    'template_id' => $skuTemplate->id,
                    'form_data' => [
                        'nama_pemohon' => 'Budi Santoso',
                        'nik' => '3309121508850001',
                        'jenis_usaha' => 'Budidaya Padi Organik & Kopi Sambi',
                        'lokasi_usaha' => 'Dukuh Catur RT 02 / RW 01, Desa Catur',
                        'tahun_berdiri' => '2019',
                        'keperluan' => 'Pengajuan Kemitraan UMKM & Kredit Usaha Rakyat',
                    ],
                    'status' => 'pending',
                    'submitted_at' => now()->subHours(5),
                ]
            );
        }

        // Sample Complaint Categories
        $infrastrukturCategory = ComplaintCategory::where('name', 'Infrastruktur & Jalan')->first() ??
            ComplaintCategory::firstOrCreate(
                ['name' => 'Infrastruktur & Jalan'],
                ['description' => 'Laporan perbaikan jalan, penerangan jalan, dam perairan']
            );

        ComplaintCategory::firstOrCreate(
            ['name' => 'Pelayanan Publik'],
            ['description' => 'Masukan dan pelayanan administrasi balai desa']
        );

        // Sample Complaints
        Complaint::firstOrCreate(
            ['title' => 'Lampu Penerangan Jalan Utama Dukuh Catur Padam'],
            [
                'user_id' => $wargaUser->id,
                'category_id' => $infrastrukturCategory->id,
                'description' => 'Mohon bantuan perbaikan lampu penerangan jalan umum (PJU) di dekat batas pertigaan RT 02 Dukuh Catur yang padam sejak 2 hari lalu.',
                'status' => 'new',
            ]
        );

        Complaint::firstOrCreate(
            ['title' => 'Usulan Penambahan Tempat Sampah Organik di Pasar Desa'],
            [
                'user_id' => $wargaUser->id,
                'category_id' => $infrastrukturCategory->id,
                'description' => 'Diperlukan tambahan tempat pembuangan sampah terpilah di sekitar area balai pertemuan warga.',
                'status' => 'processing',
                'admin_response' => 'Terima kasih atas masukannya. Tim kebersihan desa akan mengalokasikan 2 unit tong sampah baru minggu ini.',
                'responded_at' => now()->subHours(2),
            ]
        );
    }
}
