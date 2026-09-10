<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RoleAccessAndProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_and_update_profile(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'admin_pemdes',
            'password' => Hash::make('oldpassword'),
        ]);

        $response = $this->actingAs($user)->get(route('admin.profile.edit'));
        $response->assertStatus(200);

        $file = UploadedFile::fake()->image('my-avatar.jpg');

        $updateResponse = $this->actingAs($user)->put(route('admin.profile.update'), [
            'name' => 'Nama Baru Admin',
            'email' => $user->email,
            'current_password' => 'oldpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
            'avatar' => $file,
        ]);

        $updateResponse->assertRedirect(route('admin.profile.edit'));
        $user->refresh();

        $this->assertEquals('Nama Baru Admin', $user->name);
        $this->assertTrue(Hash::check('newpassword123', $user->password));
        $this->assertNotNull($user->avatar);
        Storage::disk('public')->assertExists($user->avatar);
    }

    public function test_super_admin_has_full_access(): void
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);

        $this->actingAs($superAdmin)->get(route('admin.settings.edit'))->assertStatus(200);
        $this->actingAs($superAdmin)->get(route('admin.users.index'))->assertStatus(200);
        $this->actingAs($superAdmin)->get(route('admin.village-profile.edit'))->assertStatus(200);
        $this->actingAs($superAdmin)->get(route('admin.ppko.index'))->assertStatus(200);
        $this->actingAs($superAdmin)->get(route('admin.news.index'))->assertStatus(200);
    }

    public function test_admin_pemdes_access_rules(): void
    {
        $adminPemdes = User::factory()->create(['role' => 'admin_pemdes']);

        // Allowed
        $this->actingAs($adminPemdes)->get(route('admin.village-profile.edit'))->assertStatus(200);
        $this->actingAs($adminPemdes)->get(route('admin.news.index'))->assertStatus(200);

        // Forbidden
        $this->actingAs($adminPemdes)->get(route('admin.settings.edit'))->assertStatus(403);
        $this->actingAs($adminPemdes)->get(route('admin.users.index'))->assertStatus(403);
        $this->actingAs($adminPemdes)->get(route('admin.ppko.index'))->assertStatus(403);
    }

    public function test_ppk_ormawa_access_rules(): void
    {
        $ppko = User::factory()->create(['role' => 'ppk_ormawa']);

        // Allowed
        $this->actingAs($ppko)->get(route('admin.ppko.index'))->assertStatus(200);
        $this->actingAs($ppko)->get(route('admin.news.index'))->assertStatus(200);

        // Forbidden
        $this->actingAs($ppko)->get(route('admin.village-profile.edit'))->assertStatus(403);
        $this->actingAs($ppko)->get(route('admin.settings.edit'))->assertStatus(403);
        $this->actingAs($ppko)->get(route('admin.users.index'))->assertStatus(403);
    }

    public function test_super_admin_can_manage_ppko_detail_program(): void
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);

        // Can view the editing section on admin.ppko.index
        $response = $this->actingAs($superAdmin)->get(route('admin.ppko.index'));
        $response->assertStatus(200);
        $response->assertSee('kelola-detail-program');
        $response->assertSee('Tambah Baris Detail');

        // Can create a detail program
        $storeResponse = $this->actingAs($superAdmin)->post(route('admin.ppko.detail-program.store'), [
            'aspek' => 'Aspek Pengujian',
            'keterangan' => 'Keterangan detail pengujian oleh super admin',
            'urutan' => 1,
        ]);
        $storeResponse->assertRedirect();
        $this->assertDatabaseHas('ppko_program_details', [
            'aspek' => 'Aspek Pengujian',
        ]);
    }

    public function test_non_super_admin_cannot_manage_ppko_detail_program(): void
    {
        $ppko = User::factory()->create(['role' => 'ppk_ormawa']);
        $adminPemdes = User::factory()->create(['role' => 'admin_pemdes']);

        // PPK Ormawa can visit admin.ppko.index, but does NOT see the detail program editing section
        $response = $this->actingAs($ppko)->get(route('admin.ppko.index'));
        $response->assertStatus(200);
        $response->assertDontSee('kelola-detail-program');
        $response->assertDontSee('Tambah Baris Detail');

        // PPK Ormawa is forbidden from submitting to detail-program.store
        $this->actingAs($ppko)->post(route('admin.ppko.detail-program.store'), [
            'aspek' => 'Aspek Ilegal Ormawa',
            'keterangan' => 'Harus ditolak',
            'urutan' => 1,
        ])->assertStatus(403);

        // Admin Pemdes is also forbidden
        $this->actingAs($adminPemdes)->post(route('admin.ppko.detail-program.store'), [
            'aspek' => 'Aspek Ilegal Pemdes',
            'keterangan' => 'Harus ditolak',
            'urutan' => 1,
        ])->assertStatus(403);

        $this->assertDatabaseMissing('ppko_program_details', [
            'aspek' => 'Aspek Ilegal Ormawa',
        ]);
    }
}
