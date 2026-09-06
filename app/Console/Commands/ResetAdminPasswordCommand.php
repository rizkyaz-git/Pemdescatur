<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminPasswordCommand extends Command
{
    protected $signature = 'admin:reset-password {--email= : Admin email address} {--password= : New password}';

    protected $description = 'Reset or recover single admin user password via CLI console';

    public function handle(): int
    {
        $email = $this->option('email') ?? $this->ask('Masukkan email admin', 'admin@desacatur.id');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->warn("Pengguna admin dengan email {$email} tidak ditemukan.");
            if ($this->confirm("Buat akun admin baru dengan email ini?", true)) {
                $password = $this->option('password') ?? $this->secret('Masukkan password baru');
                User::create([
                    'name' => 'Admin Pemdes Catur',
                    'email' => $email,
                    'password' => Hash::make($password),
                    'email_verified_at' => now(),
                ]);
                $this->info("✅ Akun admin baru berhasil dibuat!");
                return Command::SUCCESS;
            }
            return Command::FAILURE;
        }

        $password = $this->option('password') ?? $this->secret('Masukkan password baru');

        if (empty($password)) {
            $this->error("Password tidak boleh kosong.");
            return Command::FAILURE;
        }

        $user->update([
            'password' => Hash::make($password),
        ]);

        $this->info("✅ Password admin ({$email}) berhasil diperbarui!");
        return Command::SUCCESS;
    }
}
