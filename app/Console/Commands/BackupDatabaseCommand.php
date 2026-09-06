<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BackupDatabaseCommand extends Command
{
    protected $signature = 'db:backup {--destination= : Custom backup directory}';

    protected $description = 'Backup SQLite database file to storage/app/backups directory';

    public function handle(): int
    {
        $dbPath = database_path('database.sqlite');

        if (!File::exists($dbPath)) {
            $this->error("Database file SQLite tidak ditemukan di: {$dbPath}");
            return Command::FAILURE;
        }

        $backupDir = $this->option('destination') ?? storage_path('app/backups');

        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $timestamp = now()->format('Y-m-d_H-i-s');
        $backupFile = "{$backupDir}/sqlite-backup-{$timestamp}.sqlite";

        if (File::copy($dbPath, $backupFile)) {
            $sizeKb = round(File::size($backupFile) / 1024, 2);
            $this->info("✅ Backup database SQLite berhasil dibuat!");
            $this->line("📍 Lokasi: {$backupFile}");
            $this->line("📦 Ukuran: {$sizeKb} KB");
            return Command::SUCCESS;
        }

        $this->error("❌ Gagal menyalin file database SQLite.");
        return Command::FAILURE;
    }
}
