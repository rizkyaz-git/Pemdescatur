<?php

namespace Database\Seeders;

use App\Models\LetterTemplate;
use Illuminate\Database\Seeder;

class LetterTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Surat Keterangan Usaha',
                'code' => 'SKU',
                'description' => 'Surat keterangan resmi dari Pemerintah Desa Catur untuk keperluan legalitas usaha, pengajuan pinjaman bank/KUR, perizinan dagang, dan kemitraan bisnis warga.',
                'file_path' => 'letter_templates/template_sku.doc',
                'requirements' => "- Surat Pengantar dari Ketua RT dan RW setempat\n- Fotokopi Kartu Tanda Penduduk (KTP) Pemohon\n- Fotokopi Kartu Keluarga (KK) Desa Catur\n- Foto tempat usaha / kegiatan operasional usaha\n- Bukti lunas PBB tahun berjalan (opsional)",
                'template_text' => null,
            ],
            [
                'name' => 'Surat Keterangan Domisili',
                'code' => 'SKD',
                'description' => 'Surat keterangan bukti tempat tinggal sah warga atau pendatang di wilayah Desa Catur untuk keperluan perbankan, lamaran kerja, atau pendaftaran sekolah.',
                'file_path' => 'letter_templates/template_skd.doc',
                'requirements' => "- Surat Pengantar dari Ketua RT/RW setempat\n- Fotokopi KTP Pemohon yang bersangkutan\n- Fotokopi Kartu Keluarga (KK)\n- Pas foto ukuran 3x4 (1 lembar jika diminta instansi tujuan)",
                'template_text' => null,
            ],
            [
                'name' => 'Surat Keterangan Kelahiran',
                'code' => 'SKK',
                'description' => 'Surat keterangan pengantar untuk pelaporan peristiwa kelahiran bayi warga Desa Catur dan penerbitan Akta Kelahiran resmi dari Disdukcapil.',
                'file_path' => 'letter_templates/template_skk.doc',
                'requirements' => "- Surat Keterangan Lahir asli dari Bidan/Rumah Sakit/Klinik penolong\n- Fotokopi KTP Ayah dan Ibu bayi\n- Fotokopi Kartu Keluarga (KK)\n- Fotokopi Buku Nikah / Akta Perkawinan orang tua\n- Fotokopi KTP 2 (dua) orang saksi peristiwa kelahiran",
                'template_text' => null,
            ],
            [
                'name' => 'Surat Keterangan Tidak Mampu',
                'code' => 'SKTM',
                'description' => 'Surat keterangan kondisi ekonomi keluarga untuk pengajuan beasiswa pendidikan (KIP/PIP), keringanan biaya pengobatan Rumah Sakit/BPJS PBI, dan bantuan sosial.',
                'file_path' => 'letter_templates/template_sktm.doc',
                'requirements' => "- Surat Pengantar RT/RW menyatakan kondisi keluarga tidak mampu/pra-sejahtera\n- Fotokopi KTP Kepala Keluarga & Pemohon\n- Fotokopi Kartu Keluarga (KK)\n- Foto kondisi rumah tinggal tampak depan\n- Kartu KIP/KIS/PKH (apabila telah memiliki)",
                'template_text' => null,
            ],
            [
                'name' => 'Surat Pengantar Nikah',
                'code' => 'SPN',
                'description' => 'Surat pengantar permohonan kehendak nikah (Model N1-N4) dari Pemerintah Desa Catur menuju Kantor Urusan Agama (KUA) atau Catatan Sipil.',
                'file_path' => 'letter_templates/template_spn.doc',
                'requirements' => "- Surat Pengantar RT/RW calon mempelai\n- Fotokopi KTP dan KK calon mempelai & kedua orang tua\n- Fotokopi Akta Kelahiran & Ijazah terakhir\n- Pas foto berlatar belakang biru ukuran 2x3 (4 lembar) dan 4x6 (2 lembar)\n- Fotokopi KTP 2 orang saksi akad nikah",
                'template_text' => null,
            ],
            [
                'name' => 'Surat Keterangan Kematian',
                'code' => 'SKKM',
                'description' => 'Surat keterangan pencatatan peristiwa wafatnya warga Desa Catur untuk pengurusan Akta Kematian, klaim santunan/asuransi, dan pembaruan Kartu Keluarga.',
                'file_path' => 'letter_templates/template_skkm.doc',
                'requirements' => "- Surat Keterangan Kematian dari Dokter/Puskesmas/RS (bila meninggal di faskes)\n- KTP dan KK asli almarhum/almarhumah\n- Fotokopi KTP & KK Pelapor (ahli waris/keluarga terdekat)\n- Surat Pengantar dari Ketua RT/RW setempat",
                'template_text' => null,
            ],
        ];

        foreach ($templates as $template) {
            LetterTemplate::updateOrCreate(
                ['code' => $template['code']],
                $template
            );
        }
    }

    private function getSKUTemplate(): string
    {
        return <<<'TEMPLATE'
PEMERINTAH DESA CATUR
KECAMATAN SAMBI, KABUPATEN BOYOLALI
SURAT KETERANGAN USAHA

Nomor: {{nomor_surat}}
Tanggal: {{tanggal_surat}}

Yang bertanda tangan di bawah ini, Kepala Desa Catur, menerangkan bahwa:

Nama: {{nama_pemohon}}
Nomor Induk Kependudukan (NIK): {{nik}}
Alamat: {{alamat}}
Jenis Usaha: {{jenis_usaha}}
Lokasi Usaha: {{lokasi_usaha}}
Sejak Tahun: {{tahun_berdiri}}

Adalah benar penduduk/warga Desa Catur yang memiliki dan menjalankan usaha {{jenis_usaha}} 
di lokasi {{lokasi_usaha}} sejak tahun {{tahun_berdiri}}.

Surat Keterangan ini diberikan untuk keperluan {{keperluan}}.

Demikian surat keterangan ini diberikan dengan sebenar-benarnya untuk dapat digunakan sebagaimana diperlukan.

Desa Catur, {{tempat_tanggal}}

Kepala Desa Catur,

{{nama_kepala_desa}}
NIP. {{nip_kepala_desa}}

Tembusan:
1. Arsip Pemerintah Desa
2. Yang Bersangkutan
TEMPLATE;
    }

    private function getSKDTemplate(): string
    {
        return <<<'TEMPLATE'
PEMERINTAH DESA CATUR
KECAMATAN SAMBI, KABUPATEN BOYOLALI
SURAT KETERANGAN DOMISILI

Nomor: {{nomor_surat}}
Tanggal: {{tanggal_surat}}

Yang bertanda tangan di bawah ini, Kepala Desa Catur, menerangkan bahwa:

Nama: {{nama_pemohon}}
Nomor Induk Kependudukan (NIK): {{nik}}
Tempat Lahir: {{tempat_lahir}}
Tanggal Lahir: {{tanggal_lahir}}
Jenis Kelamin: {{jenis_kelamin}}
Pekerjaan: {{pekerjaan}}
Alamat: {{alamat}}

Adalah benar penduduk/warga Desa Catur yang bertempat tinggal di {{alamat}}.

Surat keterangan domisili ini diberikan untuk keperluan {{keperluan}}.

Demikian surat keterangan ini diberikan dengan sebenar-benarnya untuk dapat digunakan sebagaimana diperlukan.

Desa Catur, {{tempat_tanggal}}

Kepala Desa Catur,

{{nama_kepala_desa}}
NIP. {{nip_kepala_desa}}

Tembusan:
1. Arsip Pemerintah Desa
2. Yang Bersangkutan
TEMPLATE;
    }

    private function getSKKTemplate(): string
    {
        return <<<'TEMPLATE'
PEMERINTAH DESA CATUR
KECAMATAN SAMBI, KABUPATEN BOYOLALI
SURAT KETERANGAN KELAHIRAN

Nomor: {{nomor_surat}}
Tanggal: {{tanggal_surat}}

Yang bertanda tangan di bawah ini, Kepala Desa Catur, menerangkan bahwa:

Nama Anak: {{nama_anak}}
Tempat Lahir: {{tempat_lahir}}
Tanggal Lahir: {{tanggal_lahir}}
Jenis Kelamin: {{jenis_kelamin}}

Nama Ayah: {{nama_ayah}}
NIK: {{nik_ayah}}

Nama Ibu: {{nama_ibu}}
NIK: {{nik_ibu}}

Alamat: {{alamat}}

Adalah benar telah lahir seorang anak yang bernama {{nama_anak}} pada tanggal {{tanggal_lahir}} 
di {{tempat_lahir}}, kemudian anak tersebut adalah anak yang sah dari pasangan {{nama_ayah}} dan {{nama_ibu}}.

Surat keterangan kelahiran ini diberikan untuk keperluan {{keperluan}}.

Demikian surat keterangan ini diberikan dengan sebenar-benarnya untuk dapat digunakan sebagaimana diperlukan.

Desa Catur, {{tempat_tanggal}}

Kepala Desa Catur,

{{nama_kepala_desa}}
NIP. {{nip_kepala_desa}}

Tembusan:
1. Arsip Pemerintah Desa
2. Yang Bersangkutan
TEMPLATE;
    }
}
