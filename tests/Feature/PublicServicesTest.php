<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\LetterTemplate;
use App\Models\LetterRequest;
use App\Models\ComplaintCategory;
use App\Models\Complaint;
use Tests\TestCase;

class PublicServicesTest extends TestCase
{
    public function test_layanan_overview_page_can_be_accessed(): void
    {
        $response = $this->get('/layanan');
        $response->assertStatus(200);
        $response->assertSee('Layanan Publik');
        $response->assertSee('Akses Layanan Surat');
        $response->assertSee('Sampaikan Pengaduan');
    }

    public function test_guest_unauthenticated_user_can_access_and_submit_services(): void
    {
        // 1. Guest access index & create forms without login
        $this->get('/layanan/surat')->assertStatus(200);
        $this->get('/layanan/surat/buat')->assertStatus(200);
        $this->get('/layanan/pengaduan')->assertStatus(200);
        $this->get('/layanan/pengaduan/buat')->assertStatus(200);

        // 2. Guest submit letter request
        $template = LetterTemplate::first();
        $this->assertNotNull($template);

        $letterResponse = $this->post('/layanan/surat', [
            'template_id' => $template->id,
            'form_data' => [
                'nik' => '3309121111110009',
                'keperluan' => 'Uji coba pengajuan surat oleh tamu non-login',
                'telepon' => '081299998888',
            ],
        ]);

        $letterRequest = LetterRequest::where('form_data', 'like', '%tamu non-login%')->first();
        $this->assertNotNull($letterRequest);
        $this->assertNull($letterRequest->user_id);
        $letterResponse->assertRedirect(route('warga.letter.show', $letterRequest->id));

        // 3. Guest submit complaint
        $category = ComplaintCategory::first();
        $this->assertNotNull($category);

        $complaintResponse = $this->post('/layanan/pengaduan', [
            'category_id' => $category->id,
            'title' => 'Pengaduan Tamu Tanpa Login',
            'description' => 'Laporan uji coba akses publik tanpa memerlukan autentikasi login.',
        ]);

        $complaint = Complaint::where('title', 'Pengaduan Tamu Tanpa Login')->first();
        $this->assertNotNull($complaint);
        $this->assertNull($complaint->user_id);
        $complaintResponse->assertRedirect(route('warga.complaint.show', $complaint->id));
    }

    public function test_authenticated_warga_can_access_letter_and_complaint_forms(): void
    {
        $user = User::where('email', 'warga@desacatur.id')->first() ?? User::factory()->create();

        $this->actingAs($user)->get('/layanan/surat')->assertStatus(200);
        $this->actingAs($user)->get('/layanan/surat/buat')->assertStatus(200);

        $this->actingAs($user)->get('/layanan/pengaduan')->assertStatus(200);
        $this->actingAs($user)->get('/layanan/pengaduan/buat')->assertStatus(200);
    }

    public function test_admin_can_manage_letter_templates_requests_and_complaints(): void
    {
        $admin = User::first();

        // Admin view letter templates
        $this->actingAs($admin)->get('/admin/letter-templates')->assertStatus(200);

        // Admin view letter requests
        $this->actingAs($admin)->get('/admin/letter-requests')->assertStatus(200);

        // Admin view complaints
        $this->actingAs($admin)->get('/admin/complaints')->assertStatus(200);
    }
}
