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
        $this->get('/layanan/surat/buat')->assertStatus(200);
    }

    public function test_authenticated_warga_can_access_letter_forms(): void
    {
        $user = User::where('email', 'warga@desacatur.id')->first() ?? User::factory()->create();

        $this->actingAs($user)->get('/layanan/cetak-surat-mandiri')->assertStatus(200);
        $this->actingAs($user)->get('/layanan/surat/buat')->assertStatus(200);
        $this->actingAs($user)->get('/pengaduan')->assertStatus(200);
    }

    public function test_admin_can_manage_letter_templates_requests_and_complaints(): void
    {
        $admin = User::first();

        // Admin view letter templates
        $this->actingAs($admin)->get('/admin/letter-templates')->assertStatus(200);

        // Admin view letter requests
        $this->actingAs($admin)->get('/admin/letter-requests')->assertStatus(200);

        // Admin view complaints (laporans)
        $this->actingAs($admin)->get('/admin/complaints')->assertStatus(200);
    }
}
