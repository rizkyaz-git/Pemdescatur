<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

class MapAndLocationTest extends TestCase
{
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::first();
    }

    public function test_admin_can_create_and_manage_location_points(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/locations', [
            'name' => 'Poskesdes Desa Catur',
            'latitude' => '-8.24510000',
            'longitude' => '115.34520000',
            'description' => 'Pos Kesehatan Desa Catur Kintamani',
            'is_primary' => false,
        ]);

        $response->assertRedirect('/admin/locations');
        $this->assertDatabaseHas('locations', [
            'name' => 'Poskesdes Desa Catur',
            'latitude' => '-8.24510000',
            'longitude' => '115.34520000',
        ]);
    }

    public function test_public_contact_page_contains_location_map_data(): void
    {
        Location::create([
            'name' => 'Balai Desa Utama',
            'latitude' => '-8.24351200',
            'longitude' => '115.34214500',
            'description' => 'Kantor Pusat Pemerintahan Desa Catur',
            'is_primary' => true,
        ]);

        $response = $this->get('/kontak');
        $response->assertStatus(200);
        $response->assertSee('Balai Desa Utama');
        $response->assertSee('-8.243512');
        $response->assertSee('115.342145');
    }
}
