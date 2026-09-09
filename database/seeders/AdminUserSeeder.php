<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Role: Super Admin (Akses seluruh pengaturan & kelola pengguna)
        User::updateOrCreate(
            ['email' => 'superadmin@desacatur.id'],
            [
                'name' => 'Super Admin Desa Catur',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]
        );

        // 2. Role: Admin Pemdes (Dashboard, Profil Desa, Berita, Perangkat Desa, Layanan Publik)
        User::updateOrCreate(
            ['email' => 'pemdes@desacatur.id'],
            [
                'name' => 'Admin Pemdes Catur',
                'password' => Hash::make('password123'),
                'role' => 'admin_pemdes',
                'email_verified_at' => now(),
            ]
        );

        // 3. Role: PPK Ormawa (Dashboard, Berita dan Pengumuman, PPK Ormawa)
        User::updateOrCreate(
            ['email' => 'ppko@desacatur.id'],
            [
                'name' => 'Tim PPK Ormawa Catur',
                'password' => Hash::make('password123'),
                'role' => 'ppk_ormawa',
                'email_verified_at' => now(),
            ]
        );

        // Hapus akun lama yang sudah tidak digunakan agar bersih sesuai permintaan
        User::whereIn('email', ['admin@desacatur.id', 'panitia.ppko@desacatur.id'])->delete();
    }
}
