<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Laporan;
use App\Models\LetterTemplate;
use App\Models\LetterRequest;
use Tests\TestCase;

class PublicServicesTest extends TestCase
{
    public function test_layanan_overview_page_can_be_accessed(): void
    {
        $response = $this->get('/layanan');
        $response->assertRedirect('/layanan/cetak-surat-mandiri');

        $responseSurat = $this->get('/layanan/cetak-surat-mandiri');
        $responseSurat->assertStatus(200);
    }

    public function test_guest_can_access_pengaduan_form(): void
    {
        // Warga tidak memiliki akun — form pengaduan harus bisa diakses tanpa login
        $response = $this->get('/pengaduan');
        $response->assertStatus(200);

        // URL lama harus redirect ke URL baru
        $this->get('/layanan/pengaduan')->assertRedirect('/pengaduan');
        $this->get('/layanan/pengaduan/buat')->assertRedirect('/pengaduan');
    }

    public function test_guest_can_submit_complaint_without_account(): void
    {
        $complaintResponse = $this->post('/pengaduan', [
            'nama'        => 'Budi Santoso',
            'no_whatsapp' => '081234567890',
            'kategori'    => 'infrastruktur',
            'isi_laporan' => 'Jalan di depan balai desa berlubang dan sangat berbahaya bagi pengendara.',
        ]);

        $laporan = Laporan::where('nama', 'Budi Santoso')->latest()->first();
        $this->assertNotNull($laporan);
        $this->assertEquals('baru', $laporan->status);
        $this->assertEquals('6281234567890', $laporan->no_whatsapp); // normalisasi 08 → 62
        $complaintResponse->assertRedirect(route('warga.complaint.create'));
        $complaintResponse->assertSessionHas('success');
    }

    public function test_pengaduan_form_validation(): void
    {
        // Submit dengan data kosong harus gagal
        $response = $this->post('/pengaduan', []);
        $response->assertSessionHasErrors(['nama', 'no_whatsapp', 'kategori', 'isi_laporan']);

        // Nomor WA tidak valid
        $response2 = $this->post('/pengaduan', [
            'nama'        => 'Test',
            'no_whatsapp' => '12345',
            'kategori'    => 'infrastruktur',
            'isi_laporan' => 'Test laporan yang cukup panjang.',
        ]);
        $response2->assertSessionHasErrors(['no_whatsapp']);

        // Kategori tidak valid
        $response3 = $this->post('/pengaduan', [
            'nama'        => 'Test',
            'no_whatsapp' => '081234567890',
            'kategori'    => 'invalid_kategori',
            'isi_laporan' => 'Test laporan yang cukup panjang.',
        ]);
        $response3->assertSessionHasErrors(['kategori']);
    }

    public function test_letter_service_accessible_for_guest(): void
    {
        $this->get('/layanan/cetak-surat-mandiri')->assertStatus(200);
        // /layanan/surat/buat sekarang redirect permanen ke /layanan/cetak-surat-mandiri
        $this->get('/layanan/surat/buat')->assertRedirect('/layanan/cetak-surat-mandiri');
    }

    public function test_authenticated_warga_can_access_letter_forms(): void
    {
        $user = User::where('email', 'warga@desacatur.id')->first() ?? User::factory()->create();

        $this->actingAs($user)->get('/layanan/cetak-surat-mandiri')->assertStatus(200);
        // /layanan/surat/buat sekarang redirect permanen ke /layanan/cetak-surat-mandiri
        $this->actingAs($user)->get('/layanan/surat/buat')->assertRedirect('/layanan/cetak-surat-mandiri');
        $this->actingAs($user)->get('/pengaduan')->assertStatus(200);
    }

    public function test_guest_can_submit_letter_with_lainnya_option(): void
    {
        $response = $this->post(route('warga.letter.store'), [
            'template_id' => 'lainnya',
            'form_data' => [
                'nama' => 'Siti Aminah',
                'nik' => '3309123456789012',
                'telepon' => '081298765432',
                'jenis_surat_lainnya' => 'Surat Rekomendasi Beasiswa',
                'keperluan' => 'Permohonan rekomendasi beasiswa pendidikan tingkat perguruan tinggi.',
            ]
        ]);

        $response->assertSessionHasNoErrors();

        $req = LetterRequest::latest('id')->first();
        $this->assertNotNull($req);
        $this->assertEquals('Siti Aminah', data_get($req->form_data, 'nama'));
        $this->assertEquals('Surat Rekomendasi Beasiswa', data_get($req->form_data, 'jenis_surat_lainnya'));
        $response->assertRedirect(route('warga.letter.show', $req->id));
    }

    public function test_admin_can_manage_letter_templates_requests_and_complaints(): void
    {
        $admin = User::first();

        // Admin view letter templates
        $this->actingAs($admin)->get(route('admin.letter-templates.index'))->assertStatus(200);

        // Admin view letter requests
        $this->actingAs($admin)->get(route('admin.letter-requests.index'))->assertStatus(200);

        // Admin can store quick letter type directly from requests page
        $res = $this->actingAs($admin)->post(route('admin.letter-requests.store-type'), [
            'name' => 'Surat Keterangan Belum Menikah',
            'code' => 'SKBM',
            'requirements' => 'KTP, KK',
        ]);
        $res->assertRedirect(route('admin.letter-requests.index'));
        $this->assertDatabaseHas('letter_templates', [
            'name' => 'Surat Keterangan Belum Menikah',
            'code' => 'SKBM',
            'file_path' => null,
        ]);

        // Admin view complaints (laporans)
        $this->actingAs($admin)->get(route('admin.complaints.index'))->assertStatus(200);
    }
}
