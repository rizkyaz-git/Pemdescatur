<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@desacatur.id');
        $password = env('ADMIN_PASSWORD', 'password123');

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin Pemdes Catur',
                'password' => Hash::make($password),
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'panitia.ppko@desacatur.id'],
            [
                'name' => 'Panitia PPKO Catur Cerdas',
                'password' => Hash::make('password123'),
                'role' => 'admin_ppp_ormawa',
                'email_verified_at' => now(),
            ]
        );
    }
}
