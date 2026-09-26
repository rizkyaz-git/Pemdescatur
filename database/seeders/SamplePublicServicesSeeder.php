<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Laporan;
use App\Models\LetterTemplate;
use App\Models\LetterRequest;
use Illuminate\Database\Seeder;

class SamplePublicServicesSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create sample warga user
        $wargaUser = User::firstOrCreate(
            ['email' => 'warga@desacatur.id'],
            [
                'name'               => 'Budi Santoso',
                'password'           => bcrypt('password123'),
                'email_verified_at'  => now(),
            ]
        );

        // Sample Letter Template (Ensure SKU exists)
        $skuTemplate = LetterTemplate::where('code', 'SKU')->first();

        if ($skuTemplate) {
            LetterRequest::firstOrCreate(
                [
                    'user_id' => $wargaUser->id,
                    'template_id' => $skuTemplate->id,
                ],
                [
                    'form_data'   => [
                        'nama_pemohon' => 'Budi Santoso',
                        'nik'          => '3309121508850001',
                        'jenis_usaha'  => 'Budidaya Padi Organik & Kopi Sambi',
                        'lokasi_usaha' => 'Dukuh Catur RT 02 / RW 01, Desa Catur',
                        'tahun_berdiri' => '2019',
                        'keperluan'    => 'Pengajuan Kemitraan UMKM & Kredit Usaha Rakyat',
                    ],
                    'status'       => 'pending',
                    'submitted_at' => now()->subHours(5),
                ]
            );
        }

        // Sample Laporans (Pengaduan Warga — tanpa akun)
        // Alur admin saat ini hanya dua tab: Baru (belum selesai) & Riwayat (sudah selesai).
        Laporan::firstOrCreate(
            ['nama' => 'Budi Santoso', 'isi_laporan' => 'Mohon bantuan perbaikan lampu penerangan jalan umum (PJU) di dekat batas pertigaan RT 02 Dukuh Catur yang padam sejak 2 hari lalu.'],
            [
                'no_whatsapp' => '6281234567890',
                'kategori'    => 'infrastruktur',
                'status'      => 'baru',
            ]
        );

        Laporan::firstOrCreate(
            ['nama' => 'Siti Rahayu', 'isi_laporan' => 'Diperlukan tambahan tempat pembuangan sampah terpilah di sekitar area balai pertemuan warga dan pasar desa.'],
            [
                'no_whatsapp' => '6285678901234',
                'kategori'    => 'lingkungan',
                'status'      => 'selesai',
            ]
        );
    }
}
