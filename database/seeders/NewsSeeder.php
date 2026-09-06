<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        News::truncate();

        News::create([
            'title' => 'Desa Catur Sambi Terus Kembangkan Potensi Desa Wisata & Desa Cerdas Kemendes',
            'slug' => Str::slug('Desa Catur Sambi Terus Kembangkan Potensi Desa Wisata Desa Cerdas Kemendes'),
            'excerpt' => 'Sejak ditetapkan sebagai salah satu dari 45 Desa Wisata Boyolali pada tahun 2022, Desa Catur terus berinovasi dalam sektor wisata dan teknologi desa.',
            'content' => 'Desa Catur, Kecamatan Sambi, Kabupaten Boyolali yang dipimpin oleh Kepala Desa Ibu Dra. NUNIK S RAHAYU, M.Pd terus mengoptimalkan statusnya sebagai salah satu dari 45 Desa Wisata Kabupaten Boyolali sekaligus Desa Cerdas perintisan Kementerian Desa PDTT. Potensi unggulan seperti Umbul Siraman, pemandangan hamparan sawah hijau dengan irigasi Waduk Wonotoro, serta cagar budaya Masjid Wonokusumo di Pedukuhan Wonotoro menjadi daya tarik utama wisatawan.',
            'category' => 'Desa Wisata',
            'status' => 'published',
            'published_at' => now()->subDays(2),
        ]);

        News::create([
            'title' => 'Panen Padi Organik Melimpah 3 Kali Sehatun Didukung Irigasi Waduk Wonotoro',
            'slug' => Str::slug('Panen Padi Organik Melimpah 3 Kali Sehatun Didukung Irigasi Waduk Wonotoro'),
            'excerpt' => 'Pertanian Desa Catur unggul dengan pengairan irigasi Waduk Wonotoro sepanjang tahun yang memungkinkan panen padi 3 kali sebulan/setahun.',
            'content' => 'Sektor pertanian Desa Catur, Kecamatan Sambi Boyolali tergolong sangat produktif. Didukung aliran air irigasi yang stabil dari Waduk Wonotoro sepanjang tahun, para petani di 13 pedukuhan mampu memanen padi hingga 3 kali dalam setahun. Tradisi keberhasilan pertanian ini meleset sejak tahun 1987 ketika Desa Catur di bawah kepemimpinan Kepala Desa Bapak H. Duto Moelyono menerima penghargaan percontohan pertanian nasional langsung dari Presiden Soeharto di Istana Negara.',
            'category' => 'Pertanian',
            'status' => 'published',
            'published_at' => now()->subDays(5),
        ]);

        News::create([
            'title' => 'Kemajuan Pesat Sektor Peternakan Ayam Potong & Pemberdayaan UMKM Herbal',
            'slug' => Str::slug('Kemajuan Pesat Sektor Peternakan Ayam Potong Pemberdayaan UMKM Herbal'),
            'excerpt' => 'Selain pertanian, peternakan ayam potong dan UMKM beras organik serta jamu herbal makin diminati warga Desa Catur.',
            'content' => 'Perkembangan ekonomi Desa Catur semakin beragam. Selain sektor pertanian, sektor peternakan ayam potong berkembang pesat dengan banyaknya warga pedukuhan yang menjadi wirausaha ayam potong. Di samping itu, UMKM lokal Desa Catur juga aktif memproduksi beras organik, olahan tanaman obat/herbal, serta produk makanan ringan berkualitas tinggi.',
            'category' => 'Ekonomi & UMKM',
            'status' => 'published',
            'published_at' => now()->subDays(9),
        ]);
    }
}
