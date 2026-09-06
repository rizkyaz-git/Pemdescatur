<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BackupAndConsoleTest extends TestCase
{
    public function test_artisan_db_backup_command_creates_backup_file(): void
    {
        $backupDir = storage_path('app/test_backups');
        if (File::exists($backupDir)) {
            File::deleteDirectory($backupDir);
        }

        $this->artisan('db:backup', [
            '--destination' => $backupDir,
        ])->assertExitCode(0);

        $this->assertTrue(File::exists($backupDir));
        $files = File::files($backupDir);
        $this->assertNotEmpty($files);
        $this->assertStringContainsString('sqlite-backup-', $files[0]->getFilename());

        File::deleteDirectory($backupDir);
    }

    public function test_artisan_admin_reset_password_command_updates_password(): void
    {
        $admin = User::first();

        $this->artisan('admin:reset-password', [
            '--email' => $admin->email,
            '--password' => 'new-secure-pass123',
        ])->assertExitCode(0);

        $admin->refresh();
        $this->assertTrue(Hash::check('new-secure-pass123', $admin->password));
    }
}
