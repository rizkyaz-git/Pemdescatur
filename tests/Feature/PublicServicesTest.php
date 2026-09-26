<?php

namespace Tests\Feature;

use App\Http\Controllers\Public\ComplaintController;
use App\Http\Controllers\Public\LetterRequestController;
use App\Models\Laporan;
use App\Models\LetterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
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

    public function test_public_service_post_routes_are_not_shadowed_by_legacy_redirects(): void
    {
        $letterRoute = app('router')->getRoutes()->match(Request::create('/layanan/surat', 'POST'));
        $complaintRoute = app('router')->getRoutes()->match(Request::create('/pengaduan', 'POST'));

        $this->assertSame(
            LetterRequestController::class.'@store',
            $letterRoute->getActionName()
        );
        $this->assertSame(
            ComplaintController::class.'@store',
            $complaintRoute->getActionName()
        );
        $this->assertNotNull(app('router')->getRoutes()->getByName('warga.complaint.create'));
        $this->assertNotNull(app('router')->getRoutes()->getByName('warga.complaint.index'));
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
            'nama' => 'Budi Santoso',
            'no_whatsapp' => '081234567890',
            'kategori' => 'infrastruktur',
            'isi_laporan' => 'Jalan di depan balai desa berlubang dan sangat berbahaya bagi pengendara.',
        ]);

        $laporan = Laporan::where('nama', 'Budi Santoso')->latest()->first();
        $this->assertNotNull($laporan);
        $this->assertEquals('baru', $laporan->status);
        $this->assertEquals('6281234567890', $laporan->no_whatsapp); // normalisasi 08 → 62
        $complaintResponse->assertRedirect(route('warga.complaint.create'));
        $complaintResponse->assertSessionHas('success');
    }

    public function test_submissions_are_visible_in_admin_with_whatsapp_and_attachment(): void
    {
        Storage::fake('public');

        $letterResponse = $this->post(route('warga.letter.store'), [
            'template_id' => 'lainnya',
            'form_data' => [
                'nama' => 'Audit Admin Surat',
                'nik' => '3309123456789012',
                'telepon' => '081234567890',
                'jenis_surat_lainnya' => 'Surat Audit Admin',
                'keperluan' => 'Memastikan pengajuan tampil di panel admin.',
            ],
        ]);

        $complaintResponse = $this->post(route('warga.complaint.store'), [
            'nama' => 'Audit Admin Pengaduan',
            'no_whatsapp' => '081298765432',
            'kategori' => 'lainnya',
            'isi_laporan' => 'Memastikan pengaduan dan lampiran tampil di panel admin.',
            'lampiran' => UploadedFile::fake()->create('bukti-audit.pdf', 10, 'application/pdf'),
        ]);

        $letterResponse->assertRedirect();
        $complaintResponse->assertRedirect(route('warga.complaint.create'));

        $letter = LetterRequest::whereJsonContains('form_data->nama', 'Audit Admin Surat')->firstOrFail();
        $laporan = Laporan::where('nama', 'Audit Admin Pengaduan')->firstOrFail();

        $admin = User::where('role', 'super_admin')->firstOrFail();
        $this->actingAs($admin)
            ->get(route('admin.letter-requests.index'))
            ->assertOk()
            ->assertSee('Audit Admin Surat')
            ->assertSee('6281234567890');
        $this->actingAs($admin)
            ->get(route('admin.complaints.index'))
            ->assertOk()
            ->assertSee('Audit Admin Pengaduan')
            ->assertSee('6281298765432');
        $this->actingAs($admin)
            ->get(route('admin.letter-requests.show', $letter->id))
            ->assertOk()
            ->assertSee('Audit Admin Surat')
            ->assertSee('6281234567890');
        $this->actingAs($admin)
            ->get(route('admin.complaints.show', $laporan->id))
            ->assertOk()
            ->assertSee('Audit Admin Pengaduan')
            ->assertSee('storage/'.$laporan->lampiran);

        Storage::disk('public')->assertExists($laporan->lampiran);
        $this->assertSame('6281234567890', data_get($letter->form_data, 'telepon'));
        $this->assertSame('6281298765432', $laporan->no_whatsapp);
    }

    public function test_pengaduan_form_validation(): void
    {
        // Submit dengan data kosong harus gagal
        $response = $this->post('/pengaduan', []);
        $response->assertSessionHasErrors(['nama', 'no_whatsapp', 'kategori', 'isi_laporan']);

        // Nomor WA tidak valid
        $response2 = $this->post('/pengaduan', [
            'nama' => 'Test',
            'no_whatsapp' => '12345',
            'kategori' => 'infrastruktur',
            'isi_laporan' => 'Test laporan yang cukup panjang.',
        ]);
        $response2->assertSessionHasErrors(['no_whatsapp']);

        // Kategori tidak valid
        $response3 = $this->post('/pengaduan', [
            'nama' => 'Test',
            'no_whatsapp' => '081234567890',
            'kategori' => 'invalid_kategori',
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
            ],
        ]);

        $response->assertSessionHasNoErrors();

        $req = LetterRequest::latest('id')->first();
        $this->assertNotNull($req);
        $this->assertEquals('Siti Aminah', data_get($req->form_data, 'nama'));
        $this->assertEquals('Surat Rekomendasi Beasiswa', data_get($req->form_data, 'jenis_surat_lainnya'));
        $response->assertRedirect(route('warga.letter.show', $req->id));
    }

    public function test_letter_status_page_uses_minimal_layout_without_retired_ticket_ui(): void
    {
        $response = $this->post(route('warga.letter.store'), [
            'template_id' => 'lainnya',
            'form_data' => [
                'nama' => 'Pengguna Status Surat',
                'nik' => '3309123456789012',
                'telepon' => '081234567890',
                'jenis_surat_lainnya' => 'Surat Keterangan Domisili',
                'keperluan' => 'Memastikan halaman status hanya menampilkan informasi pengajuan yang relevan.',
            ],
        ]);

        $letterRequest = LetterRequest::whereJsonContains('form_data->nama', 'Pengguna Status Surat')->firstOrFail();

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');
        $response->assertRedirect(route('warga.letter.show', $letterRequest->id));
        $this->assertNull($letterRequest->ticket_number);
        $this->assertNotNull($letterRequest->submitted_at);

        $ticketColumn = collect(Schema::getColumns('letter_requests'))
            ->firstWhere('name', 'ticket_number');
        $this->assertTrue((bool) ($ticketColumn['nullable'] ?? false));

        $statusResponse = $this->get(route('warga.letter.show', $letterRequest->id));

        $statusResponse
            ->assertOk()
            ->assertSee('Permohonan surat berhasil dikirim!')
            ->assertSee('Status Permohonan Surat')
            ->assertSee('Informasi Pengajuan')
            ->assertSee('Kembali')
            ->assertSee('Ajukan Surat Baru')
            ->assertSee('href="'.route('warga.letter.index').'"', false)
            ->assertDontSee('Nomor Tiket')
            ->assertDontSee('No. Tiket')
            ->assertDontSee('Status Tiket')
            ->assertDontSee('Progres Verifikasi Surat')
            ->assertDontSee('Template Cetak Mandiri')
            ->assertDontSee('Kembali ke Beranda')
            ->assertDontSee('border-emerald-200 bg-emerald-50 p-4 flex items-start gap-3', false);

        $this->assertSame(1, substr_count($statusResponse->getContent(), 'id="app-toast-notification"'));
    }

    public function test_letter_submission_falls_back_to_guest_when_authenticated_user_no_longer_exists(): void
    {
        $deletedUser = User::factory()->create();
        $this->actingAs($deletedUser);
        $deletedUser->delete();

        $response = $this->post(route('warga.letter.store'), [
            'template_id' => 'lainnya',
            'form_data' => [
                'nama' => 'Pengguna dengan Sesi Lama',
                'nik' => '3309123456789012',
                'telepon' => '081234567890',
                'jenis_surat_lainnya' => 'Surat Keterangan Domisili',
                'keperluan' => 'Memastikan sesi lama tidak menyebabkan kegagalan foreign key.',
            ],
        ]);

        $letterRequest = LetterRequest::whereJsonContains('form_data->nama', 'Pengguna dengan Sesi Lama')->firstOrFail();

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');
        $response->assertRedirect(route('warga.letter.show', $letterRequest->id));
        $this->assertNull($letterRequest->user_id);
        $this->assertGuest();
    }

    public function test_letter_submission_keeps_an_existing_authenticated_user(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('warga.letter.store'), [
            'template_id' => 'lainnya',
            'form_data' => [
                'nama' => 'Pengguna Terautentikasi',
                'nik' => '3309123456789012',
                'telepon' => '081234567890',
                'jenis_surat_lainnya' => 'Surat Keterangan Domisili',
                'keperluan' => 'Memastikan user_id tetap disimpan untuk akun yang masih valid.',
            ],
        ]);

        $letterRequest = LetterRequest::whereJsonContains('form_data->nama', 'Pengguna Terautentikasi')->firstOrFail();

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('warga.letter.show', $letterRequest->id));
        $this->assertSame($user->id, $letterRequest->user_id);
    }

    public function test_hardening_migration_copies_each_legacy_complaint_when_target_empty(): void
    {
        // The seeder normally populates canonical rows. Clear only the test
        // database so the migration's empty-target safety rule is exercised.
        Laporan::query()->delete();

        $legacyCreatedAt = now()->startOfSecond();
        $legacy = [
            'title' => 'Legacy report with identical content',
            'description' => 'Two distinct legacy reports must both survive the repair.',
            'status' => 'new',
            'created_at' => $legacyCreatedAt,
            'updated_at' => $legacyCreatedAt,
        ];

        if (Schema::hasColumn('complaints', 'user_id')) {
            $legacy['user_id'] = User::query()->value('id');
        }
        if (Schema::hasColumn('complaints', 'category_id')) {
            if (! Schema::hasTable('complaint_categories')) {
                Schema::create('complaint_categories', function ($table): void {
                    $table->id();
                    $table->string('name');
                    $table->text('description')->nullable();
                    $table->timestamps();
                });
            }
            if (! DB::table('complaint_categories')->exists()) {
                DB::table('complaint_categories')->insert([
                    'name' => 'Test Legacy Category',
                    'description' => 'Migration regression fixture',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $legacy['category_id'] = DB::table('complaint_categories')->value('id');
        }
        foreach (['attachment_path', 'admin_response', 'responded_at'] as $column) {
            if (Schema::hasColumn('complaints', $column)) {
                $legacy[$column] = null;
            }
        }

        DB::table('complaints')->insert([$legacy, $legacy]);

        $migration = require database_path('migrations/2026_09_25_000002_harden_public_service_tables.php');
        $migration->up();

        $this->assertSame(2, Laporan::query()->count());
        $this->assertSame(2, Laporan::query()->where('isi_laporan', $legacy['description'])->count());
        $this->assertSame('baru', Laporan::query()->where('isi_laporan', $legacy['description'])->value('status'));
        $this->assertNotNull(Laporan::query()->where('isi_laporan', $legacy['description'])->value('created_at'));
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

    public function test_complaint_list_uses_baru_and_riwayat_tabs_without_status_ui(): void
    {
        $admin = User::where('role', 'super_admin')->firstOrFail();
        $complaint = $this->storeComplaint('Pelapor Tab Baru', '081298765432', 'Jalan berlubang di depan rumah warga.');

        $list = $this->actingAs($admin)->get(route('admin.complaints.index'));

        $list->assertOk()
            ->assertSee('Pelapor Tab Baru')
            // Nomor WhatsApp dinormalisasi ke format internasional pada tautan wa.me
            ->assertSee('https://wa.me/6281298765432', false)
            ->assertDontSee('Semua Status')
            ->assertDontSee('Tanggapi')
            ->assertDontSee('>Status<', false);

        // Tab Baru & Riwayat ada, dan tab aktif memakai state active yang jelas
        $this->assertMatchesRegularExpression(
            '/href="'.preg_quote(route('admin.complaints.index', ['tab' => 'baru']), '/').'" role="tab" aria-current="page"/',
            $list->getContent()
        );
        $this->assertStringContainsString(
            'href="'.route('admin.complaints.index', ['tab' => 'riwayat']).'" role="tab" aria-current="false"',
            $list->getContent()
        );

        // Pengaduan yang sudah selesai tidak boleh muncul di tab Baru
        $complaint->markCompleted();

        $this->actingAs($admin)->get(route('admin.complaints.index'))
            ->assertOk()
            ->assertDontSee('Pelapor Tab Baru');

        $this->actingAs($admin)->get(route('admin.complaints.index', ['tab' => 'riwayat']))
            ->assertOk()
            ->assertSee('Pelapor Tab Baru');
    }

    public function test_admin_can_complete_complaint_from_list_and_from_detail(): void
    {
        $admin = User::where('role', 'super_admin')->firstOrFail();
        $fromList = $this->storeComplaint('Pelapor Aksi List', '081211112222', 'Lampu jalan mati selama tiga malam.');
        $fromDetail = $this->storeComplaint('Pelapor Aksi Detail', '081233334444', 'Sampah menumpuk di dekat balai desa.');

        // Aksi "Selesai" pada list
        $this->actingAs($admin)
            ->patch(route('admin.complaints.complete', $fromList->id))
            ->assertRedirect(route('admin.complaints.index', ['tab' => 'riwayat']))
            ->assertSessionHas('success');

        $this->assertSame('selesai', $fromList->fresh()->status);
        $this->assertTrue($fromList->fresh()->isCompleted());

        // Aksi "Tandai sebagai Selesai" pada halaman detail
        $this->actingAs($admin)->get(route('admin.complaints.show', $fromDetail->id))
            ->assertOk()
            ->assertSee('Tandai sebagai Selesai')
            ->assertSee('https://wa.me/6281233334444', false);

        $this->actingAs($admin)
            ->patch(route('admin.complaints.complete', $fromDetail->id))
            ->assertRedirect(route('admin.complaints.index', ['tab' => 'riwayat']));

        $this->assertSame('selesai', $fromDetail->fresh()->status);

        // Setelah selesai, tombol workflow lama tidak muncul lagi di detail
        $this->actingAs($admin)->get(route('admin.complaints.show', $fromDetail->id))
            ->assertOk()
            ->assertDontSee('Tandai sebagai Selesai')
            ->assertSee('Pengaduan ini sudah selesai');
    }

    public function test_only_completed_complaints_can_be_deleted_from_riwayat(): void
    {
        $admin = User::where('role', 'super_admin')->firstOrFail();
        $pending = $this->storeComplaint('Pelapor Belum Selesai', '081255556666', 'Jalan penghubung rusak parah.');
        $done = $this->storeComplaint('Pelapor Sudah Selesai', '081277778888', 'Lampu jalan sudah diperbaiki.');
        $done->markCompleted();

        // Pengaduan yang belum selesai dilindungi dari hapus
        $this->actingAs($admin)
            ->delete(route('admin.complaints.destroy', $pending->id))
            ->assertRedirect(route('admin.complaints.index', ['tab' => 'baru']))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('laporans', ['id' => $pending->id]);

        // Pengaduan selesai dapat dihapus dari tab Riwayat
        $this->actingAs($admin)
            ->delete(route('admin.complaints.destroy', $done->id))
            ->assertRedirect(route('admin.complaints.index', ['tab' => 'riwayat']))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('laporans', ['id' => $done->id]);
    }

    public function test_retired_complaint_status_routes_are_gone(): void
    {
        $complaint = $this->storeComplaint('Pelapor Alur Lama', '081299998888', 'Laporan lama tanpa tindak lanjut.');
        $admin = User::where('role', 'super_admin')->firstOrFail();

        // Alur "Tanggapi / Ubah Status" tidak lagi terdaftar sama sekali
        $this->actingAs($admin)->get('/kelola/complaints/'.$complaint->id.'/edit')->assertNotFound();
        $this->actingAs($admin)
            ->put('/kelola/complaints/'.$complaint->id, ['status' => 'selesai'])
            ->assertStatus(405);
        $this->assertSame('baru', $complaint->fresh()->status);
    }

    public function test_letter_request_detail_and_list_link_whatsapp(): void
    {
        $admin = User::where('role', 'super_admin')->firstOrFail();

        $this->post(route('warga.letter.store'), [
            'template_id' => 'lainnya',
            'form_data' => [
                'nama' => 'Pemohon Tautan WhatsApp',
                'nik' => '3309123456789012',
                'telepon' => '0812-3456-7890',
                'jenis_surat_lainnya' => 'Surat Keterangan Domisili',
                'keperluan' => 'Memastikan tautan WhatsApp memakai normalisasi yang sama.',
            ],
        ])->assertSessionHasNoErrors();

        $letterRequest = LetterRequest::whereJsonContains('form_data->nama', 'Pemohon Tautan WhatsApp')->firstOrFail();

        $this->actingAs($admin)->get(route('admin.letter-requests.index'))
            ->assertOk()
            ->assertSee('https://wa.me/6281234567890', false);

        $this->actingAs($admin)->get(route('admin.letter-requests.show', $letterRequest->id))
            ->assertOk()
            ->assertSee('Nomor WhatsApp Aktif')
            ->assertSee('https://wa.me/6281234567890', false)
            ->assertSee('Tandai sebagai Selesai')
            ->assertDontSee('Status Pengerjaan');
    }

    private function storeComplaint(string $nama, string $noWhatsapp, string $isiLaporan): Laporan
    {
        $this->post(route('warga.complaint.store'), [
            'nama' => $nama,
            'no_whatsapp' => $noWhatsapp,
            'kategori' => 'infrastruktur',
            'isi_laporan' => $isiLaporan,
        ])->assertSessionHasNoErrors();

        return Laporan::where('nama', $nama)->latest('id')->firstOrFail();
    }
}
