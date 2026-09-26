<?php

namespace Tests\Feature;

use App\Models\LetterRequest;
use App\Models\LetterTemplate;
use App\Models\User;
use Tests\TestCase;

class AdminLetterRequestsTest extends TestCase
{
    public function test_admin_list_uses_server_side_new_and_history_tabs(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        $newRequest = $this->createRequest('Data Baru 912');
        $completedRequest = $this->createRequest('Data Riwayat 913', true);

        $this->assertNull($newRequest->processed_at);
        $this->assertNotNull($completedRequest->processed_at);
        $this->assertTrue($completedRequest->isCompleted());

        $this->actingAs($admin)
            ->get(route('admin.letter-requests.index', ['tab' => 'baru']))
            ->assertOk()
            ->assertSee('Baru')
            ->assertSee('Riwayat')
            ->assertSee('Data Baru 912')
            ->assertDontSee('Data Riwayat 913')
            ->assertSee(route('admin.letter-requests.complete', $newRequest->id), false)
            ->assertDontSee('name="_method" value="DELETE"', false)
            ->assertDontSee('Semua Status')
            ->assertDontSee('Status Verifikasi');

        $this->actingAs($admin)
            ->get(route('admin.letter-requests.index', ['tab' => 'riwayat']))
            ->assertOk()
            ->assertSee('Data Riwayat 913')
            ->assertDontSee('Data Baru 912')
            ->assertSee(route('admin.letter-requests.destroy', $completedRequest->id), false)
            ->assertSee("onsubmit=\"return confirm('Hapus permohonan yang sudah selesai?')\"", false)
            ->assertDontSee(route('admin.letter-requests.complete', $completedRequest->id), false);

        $this->assertNull(app('router')->getRoutes()->getByName('admin.letter-requests.edit'));
        $this->assertNull(app('router')->getRoutes()->getByName('admin.letter-requests.update'));
    }

    public function test_legacy_terminal_records_are_kept_in_history(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        $legacyRequest = $this->createRequest('Data Legacy 914');
        $legacyRequest->forceFill([
            'status' => 'approved',
            'processed_at' => null,
        ])->save();

        $this->actingAs($admin)
            ->get(route('admin.letter-requests.index', ['tab' => 'baru']))
            ->assertDontSee('Data Legacy 914');

        $this->actingAs($admin)
            ->get(route('admin.letter-requests.index', ['tab' => 'riwayat']))
            ->assertSee('Data Legacy 914');
    }

    public function test_admin_detail_only_renders_submission_fields_and_completion_action(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        $request = $this->createRequest('Detail Pemohon');

        $this->actingAs($admin)
            ->get(route('admin.letter-requests.show', $request->id))
            ->assertOk()
            ->assertSee('Nama Lengkap')
            ->assertSee('Detail Pemohon')
            ->assertSee('NIK')
            ->assertSee('Nomor WhatsApp Aktif')
            ->assertSee('Jenis Surat')
            ->assertSee('Keperluan / Keterangan Permohonan')
            ->assertSee('Tandai sebagai Selesai')
            ->assertSee(route('admin.letter-requests.complete', $request->id), false)
            ->assertDontSee('Status Pengerjaan')
            ->assertDontSee('Email Pemohon')
            ->assertDontSee('Tanggal Pengajuan')
            ->assertDontSee('Data Form Yang Diisi Pemohon')
            ->assertDontSee('Status Verifikasi')
            ->assertDontSee('name="status"', false)
            ->assertDontSee('type="file"', false);
    }

    public function test_completed_detail_does_not_offer_a_reopen_action(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        $request = $this->createRequest('Detail Selesai', true);

        $this->actingAs($admin)
            ->get(route('admin.letter-requests.show', $request->id))
            ->assertOk()
            ->assertSee('Permohonan ini sudah selesai')
            ->assertDontSee('Status Pengerjaan')
            ->assertDontSee('Tandai sebagai Selesai')
            ->assertDontSee(route('admin.letter-requests.complete', $request->id), false);
    }

    public function test_complete_action_moves_request_from_new_to_history(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        $request = $this->createRequest('Request Untuk Selesai');

        $this->actingAs($admin)
            ->patch(route('admin.letter-requests.complete', $request->id))
            ->assertRedirect(route('admin.letter-requests.index', ['tab' => 'riwayat']))
            ->assertSessionHas('success');

        $request->refresh();

        $this->assertTrue($request->isCompleted());
        $this->assertNotNull($request->processed_at);

        $this->actingAs($admin)
            ->get(route('admin.letter-requests.index', ['tab' => 'baru']))
            ->assertDontSee('Request Untuk Selesai');

        $this->actingAs($admin)
            ->get(route('admin.letter-requests.index', ['tab' => 'riwayat']))
            ->assertSee('Request Untuk Selesai');
    }

    public function test_only_completed_requests_can_be_deleted(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        $completedRequest = $this->createRequest('Request Untuk Dihapus', true);
        $newRequest = $this->createRequest('Request Belum Selesai');

        $this->actingAs($admin)
            ->delete(route('admin.letter-requests.destroy', $completedRequest->id))
            ->assertRedirect(route('admin.letter-requests.index', ['tab' => 'riwayat']))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('letter_requests', ['id' => $completedRequest->id]);

        $this->actingAs($admin)
            ->delete(route('admin.letter-requests.destroy', $newRequest->id))
            ->assertRedirect(route('admin.letter-requests.index', ['tab' => 'baru']))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('letter_requests', ['id' => $newRequest->id]);
    }

    private function createRequest(string $name, bool $completed = false): LetterRequest
    {
        $template = LetterTemplate::query()->firstOrFail();

        $request = LetterRequest::create([
            'user_id' => null,
            'template_id' => $template->id,
            'form_data' => [
                'nama' => $name,
                'nik' => '3309123456789012',
                'telepon' => '6281234567890',
                'keperluan' => 'Keperluan pengajuan surat untuk pengujian admin.',
            ],
            'status' => 'pending',
        ]);

        if ($completed) {
            $request->markCompleted();
        }

        return $request->fresh();
    }
}
