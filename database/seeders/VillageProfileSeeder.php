<?php

namespace Database\Seeders;

use App\Models\VillageProfile;
use Illuminate\Database\Seeder;

class VillageProfileSeeder extends Seeder
{
    public function run(): void
    {
        VillageProfile::updateOrCreate(
            ['id' => 1],
            [
                'nama_desa'       => 'Catur',
                'asal_usul_nama'  => 'Nama "Catur" konon berasal dari kisah empat (catur) sesepuh pendiri desa yang bersepakat membangun permukiman subur dan aman. Mereka membagi tugas: menjaga keamanan, mengelola pertanian, memelihara adat, dan menyebarkan pendidikan agama.',
                'history'         => '<p>Desa Catur merupakan salah satu desa di Kecamatan Sambi, Kabupaten Boyolali, Provinsi Jawa Tengah yang membawahi 13 pedukuhan (dusun) yaitu: Catur, Sabrangan, Karakan, Gunung Puyuh, Gumuk Ngembes, Tropayan, Giring, Karang Jowo, Bakalan, Kragan, Wonotoro, Gumuk Rejo, dan Kungon.</p><p>Sejak dahulu Desa Catur terkenal dengan sektor pertanian padi organik yang sangat baik karena didukung oleh sistem pengairan dan irigasi melimpah yang mengalir sepanjang tahun dari Waduk Wonotoro, sehingga masyarakat dapat memanen padi hingga 3 kali dalam setahun.</p><p>Pada tahun 1987, Desa Catur di bawah kepemimpinan Kepala Desa Bapak H. Duto Moelyono pernah menjadi daerah percontohan pertanian nasional dan diundang langsung ke Istana Negara untuk menerima penghargaan khusus dari Presiden Soeharto.</p><p>Pada tahun 2022, Desa Catur resmi ditetapkan sebagai salah satu dari 45 Desa Wisata Kabupaten Boyolali dan menjadi salah satu Desa Cerdas perintisan Kementerian Desa PDTT.</p>',
                'vision'          => 'Terwujudnya Desa Catur yang Mandiri, Sejahtera, Berdaya Saing, dan Berkelanjutan Berbasis Desa Wisata, Agribisnis Organik, dan Transparansi Digital.',
                'mission'         => "1. Mewujudkan tata kelola pemerintahan Desa Catur yang transparan, akuntabel, dan berbasis teknologi Desa Cerdas (Smart Village).\n2. Mengembangkan potensi agribisnis padi organik, irigasi Waduk Wonotoro, peternakan ayam potong, dan UMKM olahan herbal.\n3. Mengembangkan Desa Catur sebagai Desa Wisata Boyolali dengan mengoptimalkan Umbul Siraman, panorama sawah, dan heritage Masjid Wonokusumo.\n4. Meningkatkan mutu SDM melalui sarana pendidikan terpadu (TK, SD/MI, MTsN, hingga SMKN 1 Sambi) serta pemberdayaan ekonomi warga.",
                'luas_wilayah_ha' => 244.5154,
                'ketinggian_mdpl' => 269,
                'koordinat_lat'   => -7.4814148,
                'koordinat_lng'   => 110.6615885,
                'batas_utara'     => 'Desa Ngaglik',
                'batas_selatan'   => 'Desa Glintang',
                'batas_timur'     => 'Desa Tawengan',
                'batas_barat'     => 'Desa Papringan, Kaliwungu, Semarang',
                'kecamatan'       => 'Sambi',
                'kabupaten'       => 'Boyolali',
                'provinsi'        => 'Jawa Tengah',
                'jumlah_dukuh'    => 13,
                'jumlah_kadus'    => 3,
                'curah_hujan_mm'  => 2368,
                'suhu_max'        => 34.0,
                'suhu_min'        => 20.0,
                'jenis_tanah'     => 'Aluvial',
                'sumber_air'      => 'Sungai Pepe, Umbul Siraman, Waduk Wonotoro',
            ]
        );
    }
}
