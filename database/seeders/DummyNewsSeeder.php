<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyNewsSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Pertanian',
            'Desa Wisata',
            'PPK Ormawa',
            'Budaya & Sejarah',
            'Ekonomi & UMKM',
        ];

        foreach ($categories as $catName) {
            NewsCategory::firstOrCreate(
                ['slug' => Str::slug($catName)],
                ['name' => $catName]
            );
        }

        $articles = [
            // 1. Pertanian
            [
                'title' => 'Uji Coba Pupuk Organik Hayati dan Pembuatan Kompos Mandiri oleh Kelompok Tani',
                'slug' => Str::slug('Uji Coba Pupuk Organik Hayati dan Pembuatan Kompos Mandiri oleh Kelompok Tani'),
                'excerpt' => 'Para petani Desa Catur mengembangkan pupuk organik mandiri untuk menjaga kesuburan tanah dan menekan biaya produksi.',
                'content' => 'Kelompok tani di Desa Catur mulai memanfaatkan limbah pertanian dan kotoran ternak sebagai bahan baku pupuk organik hayati. Inisiatif ini didukung oleh penyuluh pertanian untuk mewujudkan pertanian ramah lingkungan dan berkelanjutan.',
                'image_path' => null,
                'category' => 'Pertanian',
                'views_count' => 312,
                'status' => 'published',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Penyuluhan Pola Tanam Terpadu Menjelang Musim Tanam Kedua di Dukuh Catur',
                'slug' => Str::slug('Penyuluhan Pola Tanam Terpadu Menjelang Musim Tanam Kedua di Dukuh Catur'),
                'excerpt' => 'Sosialisasi pola tanam terpadu dilaksanakan guna mengoptimalkan pemanfaatan debit air irigasi Waduk Wonotoro.',
                'content' => 'Menghadapi musim tanam berikutnya, petani di kawasan Desa Catur mengikuti sosialisasi pola rotasi tanaman terpadu. Langkah ini bertujuan memutus siklus hama dan mengoptimalkan pembagian air irigasi.',
                'image_path' => null,
                'category' => 'Pertanian',
                'views_count' => 180,
                'status' => 'published',
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'Bantuan Alsintan Mesin Tanam Padi Modern Diserahkan untuk Dukung Efisiensi Tani',
                'slug' => Str::slug('Bantuan Alsintan Mesin Tanam Padi Modern Diserahkan untuk Dukung Efisiensi Tani'),
                'excerpt' => 'Alat dan mesin pertanian modern mulai diterapkan petani untuk mempercepat waktu penanaman bibit padi.',
                'content' => 'Pemerintah desa bersama kelompok tani menyerahkan unit alsintan transplanter padi untuk digunakan bersama. Alat ini diharapkan menghemat waktu dan biaya tanam petani.',
                'image_path' => null,
                'category' => 'Pertanian',
                'views_count' => 420,
                'status' => 'published',
                'published_at' => now()->subDays(6),
            ],

            // 2. Desa Wisata
            [
                'title' => 'Revitalisasi Fasilitas Umbul Siraman untuk Tingkatkan Kenyamanan Pengunjung',
                'slug' => Str::slug('Revitalisasi Fasilitas Umbul Siraman untuk Tingkatkan Kenyamanan Pengunjung'),
                'excerpt' => 'Kawasan wisata Umbul Siraman Desa Catur dipercantik dengan penambahan gazebo dan area santai keluarga.',
                'content' => 'Destinasi wisata unggulan Umbul Siraman terus berbenah. Fasilitas ruang ganti, gazebo istirahat, serta jalan setapak tepi kolam kini ditata lebih rapi dan asri menyambut wisatawan akhir pekan.',
                'image_path' => 'news/umbul_siraman.png',
                'category' => 'Desa Wisata',
                'views_count' => 650,
                'status' => 'published',
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Paket Wisata Edukasi Petik Kopi & Jelajah Desa Mulai Ramai Dikunjungi Wisatawan',
                'slug' => Str::slug('Paket Wisata Edukasi Petik Kopi Jelajah Desa Mulai Ramai Dikunjungi Wisatawan'),
                'excerpt' => 'Wisatawan dari berbagai kota antusias mencoba pengalaman memetik kopi langsung dari pohonnya di perbukitan desa.',
                'content' => 'Inovasi paket wisata berbasis agroedukasi di Desa Catur mendapatkan respons positif. Para pengunjung diajak melihat budidaya kopi, menikmati udara sejuk pedesaan, dan mencicipi seduhan kopi lokal segar.',
                'image_path' => 'news/coffee_plantation.png',
                'category' => 'Desa Wisata',
                'views_count' => 490,
                'status' => 'published',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Pemandangan Hamparan Sawah Terasering Jadi Spot Foto Favorit Wisatawan',
                'slug' => Str::slug('Pemandangan Hamparan Sawah Terasering Jadi Spot Foto Favorit Wisatawan'),
                'excerpt' => 'Keindahan lanskap persawahan hijau dengan latar perbukitan menjadi daya tarik visual bagi pencinta fotografi alam.',
                'content' => 'Panorama alam persawahan Desa Catur yang subur dan berundak menjadi magnet tersendiri bagi pengunjung yang ingin melepas penat dan berfoto di alam terbuka.',
                'image_path' => 'news/sawah_irigasi.png',
                'category' => 'Desa Wisata',
                'views_count' => 290,
                'status' => 'published',
                'published_at' => now()->subDays(8),
            ],

            // 3. PPK Ormawa
            [
                'title' => 'Pojok Literasi Catur Cerdas Sediakan Fasilitas Baca Digital untuk Anak dan Remaja',
                'slug' => Str::slug('Pojok Literasi Catur Cerdas Sediakan Fasilitas Baca Digital untuk Anak dan Remaja'),
                'excerpt' => 'Program penguatan literasi desa menghadirkan koleksi buku anak dan komputer edukatif untuk warga.',
                'content' => 'Pojok Literasi dalam program Catur Cerdas resmi dibuka untuk umum. Anak-anak dan pelajar desa antusias membaca beragam buku dongeng, ensiklopedia, serta mengakses portal belajar digital.',
                'image_path' => null,
                'category' => 'PPK Ormawa',
                'views_count' => 380,
                'status' => 'published',
                'published_at' => now()->subHours(18),
            ],
            [
                'title' => 'Pelatihan Pembuatan Produk Olahan Kopi Bersama Tim PPK Ormawa dan Kelompok Wanita Tani',
                'slug' => Str::slug('Pelatihan Pembuatan Produk Olahan Kopi Bersama Tim PPK Ormawa dan Kelompok Wanita Tani'),
                'excerpt' => 'Ibu-ibu warga desa dilatih membuat camilan dan produk bernilai tambah dari biji kopi lokal.',
                'content' => 'Melalui kolaborasi dengan tim PPK Ormawa, kelompok wanita tani mempraktikkan pengolahan kue berbahan kopi, sirup kopi, dan sabun aromaterapi kopi untuk menambah penghasilan keluarga.',
                'image_path' => 'news/coffee_processing.png',
                'category' => 'PPK Ormawa',
                'views_count' => 410,
                'status' => 'published',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Pojok Kewirausahaan Dampingi Pengrajin dan UMKM Lokal Menuju Pemasaran Online',
                'slug' => Str::slug('Pojok Kewirausahaan Dampingi Pengrajin dan UMKM Lokal Menuju Pemasaran Online'),
                'excerpt' => 'Pendampingan branding kemasan dan pembuatan akun marketplace membantu produk desa tembus pasar luar daerah.',
                'content' => 'Pojok Kewirausahaan aktif menggelar klinik bisnis mingguan bagi para pelaku usaha rumahan di Desa Catur. Pendampingan difokuskan pada foto produk dan pembuatan katalog digital.',
                'image_path' => null,
                'category' => 'PPK Ormawa',
                'views_count' => 260,
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ],

            // 4. Budaya & Sejarah
            [
                'title' => 'Tradisi Bersih Dusun dan Doa Bersama Simbol Rasa Syukur Masyarakat Desa',
                'slug' => Str::slug('Tradisi Bersih Dusun dan Doa Bersama Simbol Rasa Syukur Masyarakat Desa'),
                'excerpt' => 'Warga dari berbagai dukuh berkumpul membersihkan lingkungan dan melantunkan doa keselamatan bersama.',
                'content' => 'Kegiatan bersih dusun rutin digelar warga setiap menjelang panen raya. Tradisi gotong royong ini mempererat silaturahmi antarwarga serta menjaga kelestarian kearifan lokal leluhur.',
                'image_path' => 'news/culture_pura.png',
                'category' => 'Budaya & Sejarah',
                'views_count' => 520,
                'status' => 'published',
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'Pelestarian Seni Tari Tradisional dan Karawitan Generasi Muda Dukuh Wonotoro',
                'slug' => Str::slug('Pelestarian Seni Tari Tradisional dan Karawitan Generasi Muda Dukuh Wonotoro'),
                'excerpt' => 'Anak-anak dan remaja desa giat berlatih gamelan dan tari kreasi setiap akhir pekan di balai sanggar desa.',
                'content' => 'Upaya regenerasi kesenian tradisional berjalan dinamis di Desa Catur. Di bawah bimbingan para sesepuh seni, kelompok karawitan muda rutin berlatih untuk tampil di pentas budaya kecamatan.',
                'image_path' => 'news/culture_pura.png',
                'category' => 'Budaya & Sejarah',
                'views_count' => 340,
                'status' => 'published',
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Pameran Arsip Sejarah dan Dokumentasi Warisan Desa Catur Digelar di Pendopo',
                'slug' => Str::slug('Pameran Arsip Sejarah dan Dokumentasi Warisan Desa Catur Digelar di Pendopo'),
                'excerpt' => 'Foto-foto lawas dan manuskrip sejarah desa dipamerkan untuk edukasi sejarah lokal bagi generasi penerus.',
                'content' => 'Pendopo Balai Desa Catur diramaikan oleh pameran dokumentasi perjalanan sejarah desa dari masa ke masa. Warga dan pelajar antusias menyimak linimasa perkembangan desa sejak abad ke-19.',
                'image_path' => 'news/masjid_wonokusumo.png',
                'category' => 'Budaya & Sejarah',
                'views_count' => 275,
                'status' => 'published',
                'published_at' => now()->subDays(12),
            ],

            // 5. Ekonomi & UMKM
            [
                'title' => 'Bazar UMKM Produk Olahan Singkong dan Keripik Tempe Laris Manis di Pasar Desa',
                'slug' => Str::slug('Bazar UMKM Produk Olahan Singkong dan Keripik Tempe Laris Manis di Pasar Desa'),
                'excerpt' => 'Aneka camilan khas pedesaan hasil kreasi ibu-ibu warga ludes diborong pembeli dalam ajang bazar desa.',
                'content' => 'Pasar mingguan Desa Catur semakin semarak dengan tersedianya stan khusus produk olahan warga, mulai dari keripik singkong gurih, tempe mendoan, hingga gula kelapa cetak alami.',
                'image_path' => null,
                'category' => 'Ekonomi & UMKM',
                'views_count' => 450,
                'status' => 'published',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Pelatihan Digital Marketing & Pembuatan Kemasan Menarik bagi Pelaku Usaha Rumahan',
                'slug' => Str::slug('Pelatihan Digital Marketing Pembuatan Kemasan Menarik bagi Pelaku Usaha Rumahan'),
                'excerpt' => 'Pemerintah desa memberikan pendampingan agar kemasan produk UMKM lebih tahan lama dan bernilai jual tinggi.',
                'content' => 'Dua puluh pelaku UMKM Desa Catur mengikuti pelatihan pengemasan vakum dan desain label kemasan. Kualitas kemasan yang baik terbukti meningkatkan kepercayaan konsumen dan daya simpan produk.',
                'image_path' => null,
                'category' => 'Ekonomi & UMKM',
                'views_count' => 330,
                'status' => 'published',
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Koperasi Simpan Pinjam Desa Perluas Akses Permodalan Ringan untuk Pedagang Kecil',
                'slug' => Str::slug('Koperasi Simpan Pinjam Desa Perluas Akses Permodalan Ringan untuk Pedagang Kecil'),
                'excerpt' => 'Fasilitas pinjaman modal bergulir bunga rendah membantu pedagang dan peternak mengembangkan usahanya.',
                'content' => 'Koperasi desa meluncurkan program pembiayaan mikro syariah tanpa agunan berat bagi pedagang keliling dan warung makan desa untuk membebaskan warga dari jeratan rentenir.',
                'image_path' => null,
                'category' => 'Ekonomi & UMKM',
                'views_count' => 215,
                'status' => 'published',
                'published_at' => now()->subDays(9),
            ],
        ];

        foreach ($articles as $article) {
            News::firstOrCreate(
                ['slug' => $article['slug']],
                $article
            );
        }

        // Update view counts on several existing items to create rich ranking in 'Sering Dilihat'
        News::where('slug', 'like', '%cagar-budaya-masjid%')->update(['views_count' => 980]);
        News::where('slug', 'like', '%desa-catur-sambi-terus-kembangkan%')->update(['views_count' => 840]);
        News::where('slug', 'like', '%pojok-harmoni%')->update(['views_count' => 760]);
        News::where('slug', 'like', '%hilirisasi-pascapanen-kopi%')->update(['views_count' => 610]);
        News::where('slug', 'like', '%panen-padi-organik%')->update(['views_count' => 540]);
    }
}
