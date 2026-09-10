<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\News;
use App\Models\Official;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::first();
    }

    public function test_admin_can_update_village_profile(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/profil', [
            'history' => 'Sejarah terbarui Desa Catur Kintamani',
            'vision' => 'Visi terbaru Desa Catur',
            'mission' => '1. Misi kesatu',
        ]);

        $response->assertRedirect('/admin/profil');
        $this->assertDatabaseHas('village_profiles', [
            'vision' => 'Visi terbaru Desa Catur',
        ]);
    }

    public function test_admin_can_crud_officials(): void
    {
        // Store without order field (auto-increments order)
        $response = $this->actingAs($this->admin)->post('/admin/officials', [
            'name' => 'I Made Testing, S.T.',
            'position' => 'Kaur Keuangan Baru',
        ]);
        $response->assertRedirect('/admin/officials');
        $official = Official::where('name', 'I Made Testing, S.T.')->first();
        $this->assertNotNull($official);
        $this->assertGreaterThan(0, $official->order);

        // Update
        $updateResponse = $this->actingAs($this->admin)->put("/admin/officials/{$official->id}", [
            'name' => 'I Made Testing, S.T.',
            'position' => 'Kaur Keuangan Diperbarui',
        ]);
        $updateResponse->assertRedirect('/admin/officials');
        $this->assertDatabaseHas('officials', ['position' => 'Kaur Keuangan Diperbarui']);

        // Test Reorder via Drag and Drop Endpoint
        $official2 = Official::create([
            'name' => 'I Wayan Dua',
            'position' => 'Kasi Pelayanan',
            'order' => 10,
        ]);

        $reorderResponse = $this->actingAs($this->admin)->postJson('/admin/officials/reorder', [
            'order' => [$official2->id, $official->id],
        ]);
        $reorderResponse->assertOk();
        $reorderResponse->assertJson(['success' => true]);

        $this->assertEquals(1, $official2->fresh()->order);
        $this->assertEquals(2, $official->fresh()->order);

        // Destroy
        $deleteResponse = $this->actingAs($this->admin)->delete("/admin/officials/{$official->id}");
        $deleteResponse->assertRedirect('/admin/officials');
        $this->assertDatabaseMissing('officials', ['id' => $official->id]);
        $official2->delete();
    }



    public function test_admin_can_crud_galleries(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('gallery.jpg');

        $response = $this->actingAs($this->admin)->post('/admin/galleries', [
            'title' => 'Dokumentasi Panen Kopi Kintamani',
            'image' => $file,
            'description' => 'Deskripsi foto galeri panen',
        ]);
        $response->assertRedirect('/admin/galleries');
        $gallery = Gallery::where('title', 'Dokumentasi Panen Kopi Kintamani')->first();
        $this->assertNotNull($gallery);
        Storage::disk('public')->assertExists($gallery->image_path);
    }

    public function test_admin_can_update_settings_and_library_url(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/settings', [
            'village_name' => 'Pemerintah Desa Catur Kintamani',
            'library_url' => 'https://perpustakaan.banglikab.go.id',
            'village_phone' => '081234567899',
        ]);

        $response->assertRedirect('/admin/settings');
        $this->assertEquals('https://perpustakaan.banglikab.go.id', Setting::get('library_url'));
        $this->assertEquals('Pemerintah Desa Catur Kintamani', Setting::get('village_name'));
    }
}
