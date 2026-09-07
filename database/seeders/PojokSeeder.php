<?php

namespace Database\Seeders;

use App\Models\Pojok;
use Illuminate\Database\Seeder;

class PojokSeeder extends Seeder
{
    public function run(): void
    {
        $pojoks = [
            [
                'id' => 1,
                'nama' => 'Pojok Harmoni',
                'deskripsi_singkat' => 'Hadir bersama ibu-ibu caregiver keluarga dan ODGJ melalui pelatihan Psychological First Aid dan penguatan komunikasi keluarga, agar masyarakat memiliki bekal untuk memberikan dukungan psikologis secara tepat.',
            ],
            [
                'id' => 2,
                'nama' => 'Pojok Ceria',
                'deskripsi_singkat' => 'Menjadi ruang belajar dan tumbuh bagi anak-anak komunitas TPA melalui kegiatan edukatif dan literasi yang dikemas secara menyenangkan.',
            ],
            [
                'id' => 3,
                'nama' => 'Pojok UMKM Go Digital',
                'deskripsi_singkat' => 'Mendampingi ibu-ibu pelaku usaha rumahan untuk mengenal pemanfaatan WhatsApp Bisnis dan teknologi digital sebagai bagian dari pengembangan usaha.',
            ],
            [
                'id' => 4,
                'nama' => 'Pojok Budaya',
                'deskripsi_singkat' => 'Menjadi ruang bagi remaja Desa Catur bersama komunitas Karang Taruna untuk mengenal, menjaga, dan mengembangkan potensi budaya di tengah perubahan zaman.',
            ],
            [
                'id' => 5,
                'nama' => 'Pojok Tani',
                'deskripsi_singkat' => 'Hadir bersama komunitas gabungan kelompok tani untuk mendorong penguatan pengetahuan dan optimalisasi potensi pertanian sebagai salah satu kekuatan desa.',
            ],
        ];

        foreach ($pojoks as $data) {
            Pojok::updateOrCreate(
                ['id' => $data['id']],
                [
                    'nama' => $data['nama'],
                    'deskripsi_singkat' => $data['deskripsi_singkat'],
                ]
            );
        }

        // Seeding Kurikulum & Modul untuk Semua 5 Pojok
        $sampleFile = 'ppko/kurikulum/ueR48R7NL9WWsQgr5p2VWbqNHQ25kjUinmJFNukX.pdf';

        // 1. Pojok Harmoni
        \App\Models\Kurikulum::updateOrCreate(
            ['pojok_id' => 1, 'judul' => 'Kurikulum Pelatihan PFA & Harmoni Sosial'],
            [
                'deskripsi' => 'Silabus dan kurikulum terpadu pendampingan Psychological First Aid bagi keluarga dan kader kesehatan Desa Catur.',
                'file_path' => $sampleFile,
                'file_name' => 'Kurikulum_Pelatihan_PFA_Harmoni_Sosial.pdf',
                'file_size' => 1245000,
            ]
        );
        \App\Models\Kurikulum::updateOrCreate(
            ['pojok_id' => 1, 'judul' => 'Modul Psychological First Aid (PFA)'],
            [
                'deskripsi' => 'Panduan praktis langkah-langkah PFA (Look, Listen, Link) untuk caregiver keluarga dan penanganan dukungan psikososial warga.',
                'file_path' => $sampleFile,
                'file_name' => 'Modul_Panduan_PFA_Caregiver.pdf',
                'file_size' => 2450000,
            ]
        );

        // 2. Pojok Ceria
        \App\Models\Kurikulum::updateOrCreate(
            ['pojok_id' => 2, 'judul' => 'Kurikulum Pembelajaran Kreatif & Literasi TPA'],
            [
                'deskripsi' => 'Silabus kurikulum pendidikan karakter, literasi membaca, dan aktivitas kreatif santri TPA Desa Catur.',
                'file_path' => $sampleFile,
                'file_name' => 'Kurikulum_Literasi_Ceria_TPA.pdf',
                'file_size' => 1120000,
            ]
        );
        \App\Models\Kurikulum::updateOrCreate(
            ['pojok_id' => 2, 'judul' => 'Modul Praktik Edukasi & Permainan Anak'],
            [
                'deskripsi' => 'Panduan modul ice breaking, literasi membaca, dan lembar kerja kreatif anak-anak Desa Catur.',
                'file_path' => $sampleFile,
                'file_name' => 'Modul_Edukasi_Literasi_Anak.pdf',
                'file_size' => 1980000,
            ]
        );

        // 3. Pojok UMKM Go Digital
        \App\Models\Kurikulum::updateOrCreate(
            ['pojok_id' => 3, 'judul' => 'Kurikulum Inkubasi Bisnis & Transformasi Digital UMKM'],
            [
                'deskripsi' => 'Silabus pendampingan digitalisasi usaha mikro desa dari manajemen produk hingga transaksi online.',
                'file_path' => $sampleFile,
                'file_name' => 'Kurikulum_Digitalisasi_UMKM_Catur.pdf',
                'file_size' => 1430000,
            ]
        );
        \App\Models\Kurikulum::updateOrCreate(
            ['pojok_id' => 3, 'judul' => 'Modul Panduan Digital Marketing & Foto Produk UMKM'],
            [
                'deskripsi' => 'Panduan praktis WhatsApp Bisnis, teknik foto produk smartphone, dan pembuatan kemasan menarik.',
                'file_path' => $sampleFile,
                'file_name' => 'Modul_Digital_Marketing_UMKM.pdf',
                'file_size' => 2850000,
            ]
        );

        // 4. Pojok Budaya
        \App\Models\Kurikulum::updateOrCreate(
            ['pojok_id' => 4, 'judul' => 'Kurikulum Penguatan Karang Taruna & Pelestarian Tradisi'],
            [
                'deskripsi' => 'Silabus pembinaan kepemudaan desa dalam menjaga seni budaya dan tradisi kearifan lokal Desa Catur.',
                'file_path' => $sampleFile,
                'file_name' => 'Kurikulum_Seni_Budaya_Karang_Taruna.pdf',
                'file_size' => 1340000,
            ]
        );
        \App\Models\Kurikulum::updateOrCreate(
            ['pojok_id' => 4, 'judul' => 'Modul Panduan Sanggar Budaya & Dokumentasi Tradisi'],
            [
                'deskripsi' => 'Buku panduan pengenalan gamelan, seni tari, serta dokumentasi digital tradisi budaya warga.',
                'file_path' => $sampleFile,
                'file_name' => 'Modul_Pelestarian_Budaya_Desa.pdf',
                'file_size' => 2100000,
            ]
        );

        // 5. Pojok Tani
        \App\Models\Kurikulum::updateOrCreate(
            ['pojok_id' => 5, 'judul' => 'Kurikulum Pertanian Berkelanjutan & Mandiri Gapoktan'],
            [
                'deskripsi' => 'Silabus pendampingan kelompok tani dalam pemanfaatan pupuk ramah lingkungan dan optimalisasi hasil panen.',
                'file_path' => $sampleFile,
                'file_name' => 'Kurikulum_Pertanian_Berkelanjutan.pdf',
                'file_size' => 1560000,
            ]
        );
        \App\Models\Kurikulum::updateOrCreate(
            ['pojok_id' => 5, 'judul' => 'Modul Pembuatan Pupuk Organik & Perawatan Lahan'],
            [
                'deskripsi' => 'Panduan praktis formula pupuk organik cair/padat dan manajemen perlindungan hama terpadu.',
                'file_path' => $sampleFile,
                'file_name' => 'Modul_Pupuk_Organik_Pertanian.pdf',
                'file_size' => 2300000,
            ]
        );
    }
}
