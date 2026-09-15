<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Refactor fitur pengaduan ke desain baru (tanpa akun pelapor).
 *
 * Kolom baru: id, nama, no_whatsapp, kategori, isi_laporan, lampiran,
 *             status (enum baru/diproses/selesai/ditolak), catatan_admin, timestamps
 *
 * Kompatibel dengan MySQL (production) dan SQLite (test/CI).
 */
return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            // === PATH MYSQL ===
            // Drop Foreign Keys and Indexes (with try-catch to ignore if they don't exist)
            try {
                Schema::table('complaints', function (Blueprint $table) {
                    $table->dropForeign('complaints_category_id_foreign');
                });
            } catch (\Exception $e) {}

            try {
                Schema::table('complaints', function (Blueprint $table) {
                    $table->dropForeign('complaints_user_id_foreign');
                });
            } catch (\Exception $e) {}

            try {
                Schema::table('complaints', function (Blueprint $table) {
                    $table->dropIndex('complaints_category_id_foreign');
                });
            } catch (\Exception $e) {}

            try {
                Schema::table('complaints', function (Blueprint $table) {
                    $table->dropIndex('complaints_user_id_index');
                });
            } catch (\Exception $e) {}

            // Drop kolom-kolom lama (secara individual dan cek eksistensi agar aman dari partial migration)
            $oldColumns = [
                'user_id', 'category_id', 'title', 'description',
                'admin_response', 'responded_at', 'attachment_path',
            ];
            foreach ($oldColumns as $col) {
                if (Schema::hasColumn('complaints', $col)) {
                    Schema::table('complaints', function (Blueprint $table) use ($col) {
                        $table->dropColumn($col);
                    });
                }
            }

            // Drop tabel complaint_categories
            Schema::dropIfExists('complaint_categories');

            // Tambah kolom baru (cek eksistensi untuk menghindari error duplicate column)
            Schema::table('complaints', function (Blueprint $table) {
                if (!Schema::hasColumn('complaints', 'nama')) {
                    $table->string('nama');
                }
                if (!Schema::hasColumn('complaints', 'no_whatsapp')) {
                    $table->string('no_whatsapp');
                }
                if (!Schema::hasColumn('complaints', 'kategori')) {
                    $table->string('kategori');
                }
                if (!Schema::hasColumn('complaints', 'isi_laporan')) {
                    $table->text('isi_laporan');
                }
                if (!Schema::hasColumn('complaints', 'lampiran')) {
                    $table->string('lampiran')->nullable();
                }
                if (!Schema::hasColumn('complaints', 'catatan_admin')) {
                    $table->text('catatan_admin')->nullable();
                }
            });

            // Ubah enum status
            DB::statement(
                "ALTER TABLE complaints MODIFY COLUMN `status` ENUM('baru','diproses','selesai','ditolak') NOT NULL DEFAULT 'baru'"
            );

            // Rename tabel (drop terlebih dahulu jika ada sisa dari kegagalan migrasi sebelumnya)
            Schema::dropIfExists('laporans');
            Schema::rename('complaints', 'laporans');

        } else {
            // === PATH SQLite / TEST ENV ===
            // SQLite: drop tabel lama dan buat ulang sebagai laporans
            Schema::dropIfExists('complaint_categories');
            Schema::dropIfExists('complaints');
            Schema::dropIfExists('laporans');

            Schema::create('laporans', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('no_whatsapp');
                $table->string('kategori');
                $table->text('isi_laporan');
                $table->string('lampiran')->nullable();
                $table->string('status')->default('baru');
                $table->text('catatan_admin')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
        // Restore lengkap memerlukan fresh migration; down() ini hanya untuk clean drop
    }
};
