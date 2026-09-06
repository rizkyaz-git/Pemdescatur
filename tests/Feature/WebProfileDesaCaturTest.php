<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Tests\TestCase;

class WebProfileDesaCaturTest extends TestCase
{
    public function test_public_pages_can_be_accessed(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Desa Catur');
        $response->assertSee('Perpustakaan Daerah');

        $this->get('/profil')->assertStatus(200)->assertSee('Profil Desa Catur');
        $this->get('/struktur')->assertStatus(200)->assertSee('Struktur Organisasi');
        $this->get('/berita')->assertStatus(200)->assertSee('Berita & Pengumuman');
        $this->get('/statistik')->assertStatus(200)->assertSee('Statistik Desa');
        $this->get('/galeri')->assertStatus(200)->assertSee('Galeri Foto');
        $this->get('/layanan')->assertStatus(200)->assertSee('Pusat Layanan');
        $this->get('/kontak')->assertStatus(200)->assertSee('Kontak');
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_admin_can_access_dashboard(): void
    {
        $admin = User::first();
        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Ringkasan Admin');
    }

    public function test_admin_can_create_news(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->post('/admin/news', [
            'title' => 'Berita Pertanian Uji Coba',
            'excerpt' => 'Ringkasan berita uji coba',
            'content' => 'Isi berita lengkap untuk pengujian sistem desa.',
            'category' => 'Pertanian',
            'status' => 'published',
        ]);

        $response->assertRedirect('/admin/news');
        $this->assertDatabaseHas('news', [
            'title' => 'Berita Pertanian Uji Coba',
            'category' => 'Pertanian',
        ]);
    }

    public function test_search_feature_works_for_news(): void
    {
        News::create([
            'title' => 'Pengumuman Kopi Kintamani Spesial',
            'slug' => 'pengumuman-kopi-kintamani-spesial',
            'content' => 'Pengujian pencarian kata kunci kopi.',
            'category' => 'Pengumuman',
            'status' => 'published',
        ]);

        $response = $this->get('/berita?q=Spesial');
        $response->assertStatus(200);
        $response->assertSee('Pengumuman Kopi Kintamani Spesial');
    }
}
