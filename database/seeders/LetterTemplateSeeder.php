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
                'description' => 'Surat keterangan untuk usaha/bisnis warga',
                'template_text' => $this->getSKUTemplate(),
            ],
            [
                'name' => 'Surat Keterangan Domisili',
                'code' => 'SKD',
                'description' => 'Surat keterangan tempat tinggal warga',
                'template_text' => $this->getSKDTemplate(),
            ],
            [
                'name' => 'Surat Keterangan Kelahiran',
                'code' => 'SKK',
                'description' => 'Surat keterangan untuk pengurusan akta kelahiran',
                'template_text' => $this->getSKKTemplate(),
            ],
        ];

        foreach ($templates as $template) {
            LetterTemplate::firstOrCreate(
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
