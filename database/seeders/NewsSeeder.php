<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Pojok Harmoni Edisi Kemerdekaan Hadirkan Edukasi Psikologi dan Layanan Kesehatan',
                'slug' => Str::slug('Pojok Harmoni Edisi Kemerdekaan Hadirkan Edukasi Psikologi dan Layanan Kesehatan'),
                'excerpt' => 'Program PPK Ormawa Catur Cerdas menghadirkan pos pelayanan kesehatan dan konsultasi psikologi bagi warga desa.',
                'content' => 'Pelaksanaan kegiatan Pojok Harmoni dalam rangka peringatan HUT Kemerdekaan di Desa Catur disambut hangat oleh ratusan warga. Kegiatan ini melibatkan pemeriksaan kesehatan gratis, cek tensi darah, dan konsultasi kesehatan keluarga.',
                'image_path' => 'news/DVziXVTsRnJ0aarepNGm3fz9xNz9FHCpS5xShvq7.jpg',
                'image_caption' => 'Pelaksanaan Pojok Harmoni Catur Cerdas bersama warga Desa Catur',
                'category' => 'PPK Ormawa',
                'status' => 'published',
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Desa Catur Sambi Terus Kembangkan Potensi Desa Wisata & Desa Cerdas Kemendes',
                'slug' => Str::slug('Desa Catur Sambi Terus Kembangkan Potensi Desa Wisata Desa Cerdas Kemendes'),
                'excerpt' => 'Sejak ditetapkan sebagai salah satu dari 45 Desa Wisata Boyolali pada tahun 2022, Desa Catur terus berinovasi dalam sektor wisata dan teknologi desa.',
                'content' => 'Desa Catur, Kecamatan Sambi, Kabupaten Boyolali yang dipimpin oleh Kepala Desa Ibu Dra. NUNIK S RAHAYU, M.Pd terus mengoptimalkan statusnya sebagai salah satu dari 45 Desa Wisata Kabupaten Boyolali sekaligus Desa Cerdas perintisan Kementerian Desa PDTT. Potensi unggulan seperti Umbul Siraman, pemandangan hamparan sawah hijau dengan irigasi Waduk Wonotoro, serta cagar budaya Masjid Wonokusumo di Pedukuhan Wonotoro menjadi daya tarik utama wisatawan.',
                'image_path' => 'news/umbul_siraman.png',
                'image_caption' => 'Destinasi wisata alam dan kejernihan air Umbul Siraman Desa Catur',
                'category' => 'Desa Wisata',
                'status' => 'published',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Panen Padi Organik Melimpah 3 Kali Setahun Didukung Irigasi Waduk Wonotoro',
                'slug' => Str::slug('Panen Padi Organik Melimpah 3 Kali Setahun Didukung Irigasi Waduk Wonotoro'),
                'excerpt' => 'Pertanian Desa Catur unggul dengan pengairan irigasi Waduk Wonotoro sepanjang tahun yang memungkinkan panen padi 3 kali setahun.',
                'content' => 'Sektor pertanian Desa Catur, Kecamatan Sambi Boyolali tergolong sangat produktif. Didukung aliran air irigasi yang stabil dari Waduk Wonotoro sepanjang tahun, para petani di 13 pedukuhan mampu memanen padi hingga 3 kali dalam setahun.',
                'image_path' => 'news/sawah_irigasi.png',
                'image_caption' => 'Hamparan sawah padi dengan irigasi Waduk Wonotoro Desa Catur',
                'category' => 'Pertanian',
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Cagar Budaya Masjid Wonokusumo: Saksi Sejarah & Religi Desa Catur Sejak 1825',
                'slug' => Str::slug('Cagar Budaya Masjid Wonokusumo Saksi Sejarah Religi Desa Catur Sejak 1825'),
                'excerpt' => 'Masjid bersejarah Wonokusumo di Dukuh Wonotoro tetap kokoh berdiri dan menjadi pusat peribadatan serta wisata religi desa.',
                'content' => 'Masjid Wonokusumo merupakan salah satu peninggalan bersejarah kebanggaan warga Desa Catur. Didirikan pada masa perjuangan Pangeran Diponegoro, masjid ini terus dilestarikan kelestarian arsitekturnya.',
                'image_path' => 'news/masjid_wonokusumo.png',
                'image_caption' => 'Bangunan bersejarah cagar budaya Masjid Wonokusumo',
                'category' => 'Budaya & Sejarah',
                'status' => 'published',
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Pengembangan Sentra Kopi Robusta & Edukasi Petani Muda Desa Catur',
                'slug' => Str::slug('Pengembangan Sentra Kopi Robusta Edukasi Petani Muda Desa Catur'),
                'excerpt' => 'Kelompok tani desa menggeliatkan budidaya kopi perkebunan ramah lingkungan dengan teknik panen petik merah.',
                'content' => 'Potensi perkebunan kopi di perbukitan Desa Catur mulai dikembangkan secara terpadu. Para pemuda desa dilatih budidaya modern dan pascapanen kopi bernilai ekonomi tinggi.',
                'image_path' => 'news/coffee_plantation.png',
                'image_caption' => 'Budidaya perkebunan kopi robusta rakyat di kawasan Desa Catur',
                'category' => 'Perkebunan',
                'status' => 'published',
                'published_at' => now()->subDays(9),
            ],
            [
                'title' => 'Hilirisasi Pascapanen Kopi Desa Catur Menuju Pasar Kopi Spesialti Jawa Tengah',
                'slug' => Str::slug('Hilirisasi Pascapanen Kopi Desa Catur Menuju Pasar Kopi Spesialti'),
                'excerpt' => 'Proses roasting dan pengolahan biji kopi lokal Desa Catur siap menembus kafe dan gerai UMKM di Boyolali dan sekitarnya.',
                'content' => 'Melalui sentuhan teknologi tepat guna, pengolahan biji kopi pascapanen di Desa Catur mampu menghasilkan aroma dan cita rasa khas yang diminati para penikmat kopi.',
                'image_path' => 'news/coffee_processing.png',
                'image_caption' => 'Proses pengolahan pascapanen biji kopi lokal Desa Catur',
                'category' => 'Ekonomi & UMKM',
                'status' => 'published',
                'published_at' => now()->subDays(11),
            ],
            [
                'title' => 'Harmoni Kebudayaan Tradisional & Kerukunan Masyarakat Desa Catur',
                'slug' => Str::slug('Harmoni Kebudayaan Tradisional Kerukunan Masyarakat Desa Catur'),
                'excerpt' => 'Kehidupan beragama dan tradisi adat di Desa Catur senantiasa rukun, harmonis, dan menjadi teladan kerukunan bermasyarakat.',
                'content' => 'Desa Catur dikenal dengan kerukunan warganya yang menjunjung tinggi toleransi antarumat beragama dan pelestarian adat istiadat leluhur.',
                'image_path' => 'news/culture_pura.png',
                'image_caption' => 'Potret kerukunan dan pelestarian tradisi budaya di Desa Catur',
                'category' => 'Sosial Budaya',
                'status' => 'published',
                'published_at' => now()->subDays(14),
            ],
        ];

        foreach ($articles as $article) {
            News::firstOrCreate(['slug' => $article['slug']], $article);
        }
    }
}

