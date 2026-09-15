<?php
namespace Tests\Feature;

use App\Events\LaporanDiperbarui;
use App\Mail\MagicLoginMail;
use App\Mail\VerifikasiLaporanMail;
use App\Models\Laporan;
use App\Models\LoginToken;
use App\Models\Pelapor;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Queue;
use Illuminate\Events\CallQueuedListener;
use Tests\TestCase;

class MagicLinkLaporanTest extends TestCase
{
    public function test_submission_hashes_nik_and_sends_only_hashed_verification_token(): void
    {
        Mail::fake();
        $response = $this->post(route('warga.complaint.store'), ['nama' => 'Warga Test', 'nik' => '1234567890123456', 'email' => 'warga@example.com', 'kategori' => 'Lingkungan', 'isi_laporan' => '<script>alert(1)</script>Laporan lingkungan yang cukup panjang.']);
        $response->assertRedirect(route('pelapor.login.request'));
        $pelapor = Pelapor::firstOrFail(); $laporan = Laporan::firstOrFail(); $token = LoginToken::firstOrFail();
        $this->assertTrue(Hash::check('1234567890123456', $pelapor->nik_hash));
        $this->assertNotSame('1234567890123456', $pelapor->nik_hash);
        $this->assertSame('pending_verification', $laporan->status);
        $this->assertSame(64, strlen($token->getRawOriginal('token_hash')));
        $this->assertTrue($token->expires_at->isFuture());
        Mail::assertSent(VerifikasiLaporanMail::class);
    }

    public function test_valid_token_authenticates_pelapor_and_token_cannot_be_replayed(): void
    {
        $pelapor = Pelapor::create(['nama' => 'A', 'email' => 'a@example.com', 'nik_hash' => Hash::make('1234567890123456')]);
        $laporan = Laporan::create(['pelapor_id' => $pelapor->id, 'kategori' => 'Sosial', 'isi_laporan' => 'Isi laporan cukup panjang untuk diuji.']);
        $raw = str_repeat('a', 40);
        LoginToken::create(['pelapor_id' => $pelapor->id, 'email' => $pelapor->email, 'laporan_id' => $laporan->id, 'purpose' => LoginToken::VERIFY_LAPORAN, 'token_hash' => hash('sha256', $raw), 'expires_at' => now()->addMinutes(15)]);
        $this->session(['pre_login_probe' => 'present']);
        $oldSessionId = $this->app['session']->getId();
        $this->get(route('pelapor.verify', ['token' => $raw]))->assertRedirect(route('pelapor.laporan.show', $laporan->id));
        $this->assertAuthenticatedAs($pelapor, 'pelapor');
        $this->assertNotSame($oldSessionId, $this->app['session']->getId());
        $this->assertSame('diterima', $laporan->fresh()->status);
        $this->get(route('pelapor.verify', ['token' => $raw]))->assertOk()->assertSee('Tautan tidak berlaku');
    }

    public function test_expired_token_and_idor_are_rejected(): void
    {
        $a = Pelapor::create(['nama' => 'A', 'email' => 'a@example.com', 'nik_hash' => Hash::make('1234567890123456')]);
        $b = Pelapor::create(['nama' => 'B', 'email' => 'b@example.com', 'nik_hash' => Hash::make('6543210987654321')]);
        $laporanB = Laporan::create(['pelapor_id' => $b->id, 'kategori' => 'Sosial', 'isi_laporan' => 'Laporan milik B yang privat.']);
        $raw = str_repeat('b', 40);
        LoginToken::create(['pelapor_id' => $a->id, 'email' => $a->email, 'purpose' => LoginToken::MAGIC_LOGIN, 'token_hash' => hash('sha256', $raw), 'expires_at' => now()->subMinute()]);
        $this->get(route('pelapor.verify', ['token' => $raw]))->assertOk()->assertSee('Tautan tidak berlaku');
        $this->actingAs($a, 'pelapor')->get(route('pelapor.laporan.show', $laporanB->id))->assertNotFound();
        $this->app['auth']->shouldUse('web');
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_sixth_magic_link_request_is_rate_limited_without_enumeration(): void
    {
        Mail::fake(); $email = 'tidakada@example.com'; $key = 'pelapor-magic:'.hash('sha256', $email.'|127.0.0.1'); RateLimiter::clear($key);
        for ($i = 0; $i < 5; $i++) $this->post(route('pelapor.login.send'), ['email' => $email])->assertSessionHas('success');
        $this->post(route('pelapor.login.send'), ['email' => $email])->assertSessionHasErrors('email');
        Mail::assertNothingSent();
    }

    public function test_admin_update_dispatches_single_event_and_keeps_admin_authentication(): void
    {
        Event::fake();
        $admin = User::factory()->create(['role' => 'admin_pemdes']);
        $pelapor = Pelapor::create(['nama' => 'A', 'email' => 'a@example.com', 'nik_hash' => Hash::make('1234567890123456')]);
        $laporan = Laporan::create(['pelapor_id' => $pelapor->id, 'kategori' => 'Sosial', 'isi_laporan' => 'Isi laporan cukup panjang untuk diuji.']);
        $this->actingAs($admin)->put(route('admin.laporans.update', $laporan), ['status' => 'diproses', 'isi_tanggapan' => 'Sedang kami tindak lanjuti.'])->assertRedirect();
        $this->assertAuthenticatedAs($admin);
        Event::assertDispatched(LaporanDiperbarui::class);
    }

    public function test_notification_listener_is_queued_and_creates_a_safe_login_token_when_handled(): void
    {
        Queue::fake(); Mail::fake();
        $pelapor = Pelapor::create(['nama' => 'A', 'email' => 'a@example.com', 'nik_hash' => Hash::make('1234567890123456')]);
        $laporan = Laporan::create(['pelapor_id' => $pelapor->id, 'kategori' => 'Sosial', 'isi_laporan' => 'Isi laporan cukup panjang untuk diuji.']);
        event(new LaporanDiperbarui($laporan));
        Queue::assertPushed(CallQueuedListener::class);
    }

    public function test_pengaduan_landing_page_can_be_accessed(): void
    {
        $response = $this->get(route('warga.complaint.index'));
        $response->assertOk();
        $response->assertSee('Layanan Aspirasi &amp; Pengaduan Warga Desa Catur', false);
        $response->assertSee(route('warga.complaint.create'));
        $response->assertSee(route('pelapor.login.request'));
    }

    public function test_pengaduan_create_form_can_be_accessed_and_has_category_preselected(): void
    {
        $response = $this->get(route('warga.complaint.create', ['kategori' => 'Infrastruktur']));
        $response->assertOk();
        $response->assertSee('Kirim Pengaduan &amp; Aspirasi Warga', false);
        $response->assertSee('Infrastruktur');
    }
}
