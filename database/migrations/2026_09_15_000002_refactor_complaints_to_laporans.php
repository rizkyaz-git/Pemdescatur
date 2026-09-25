<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Refactor pengaduan to the account-free public-services schema.
 *
 * This migration is intentionally non-destructive. Older versions dropped an
 * existing `laporans` table and discarded the old complaint rows before
 * renaming the table. That could silently destroy production submissions.
 * The canonical table is now created/ensured first and legacy rows are copied
 * only when the destination is empty; the old table is left in place for a
 * manual audit instead of being dropped.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('laporans')) {
            $this->createLaporansTable();
        } else {
            $this->ensureCanonicalColumns('laporans');
            $this->normalizeStatus('laporans');
        }

        // A partial migration may have left the old table behind. Copy its
        // rows into the canonical table when the destination has no rows.
        if (Schema::hasTable('complaints')) {
            $this->copyLegacyRows('complaints', 'laporans');
        }
    }

    /**
     * Do not destructively roll back a public-submission migration. Restoring
     * the old schema would require dropping populated tables or inventing a
     * lossy reverse mapping, so rollback is intentionally a no-op.
     */
    public function down(): void
    {
        // Intentionally empty — see up() for the data-preserving rationale.
    }

    private function createLaporansTable(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_whatsapp');
            $table->string('kategori');
            $table->text('isi_laporan');
            $table->string('lampiran')->nullable();
            $table->string('status', 20)->default('baru');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Add missing canonical columns without changing or dropping existing
     * data. Required columns are nullable here because a partially-created
     * production table may already contain rows that cannot be backfilled.
     */
    private function ensureCanonicalColumns(string $tableName): void
    {
        $definitions = [
            'nama' => function (Blueprint $table): void {
                $table->string('nama')->nullable();
            },
            'no_whatsapp' => function (Blueprint $table): void {
                $table->string('no_whatsapp')->nullable();
            },
            'kategori' => function (Blueprint $table): void {
                $table->string('kategori')->nullable();
            },
            'isi_laporan' => function (Blueprint $table): void {
                $table->text('isi_laporan')->nullable();
            },
            'lampiran' => function (Blueprint $table): void {
                $table->string('lampiran')->nullable();
            },
            'status' => function (Blueprint $table): void {
                $table->string('status', 20)->default('baru');
            },
            'catatan_admin' => function (Blueprint $table): void {
                $table->text('catatan_admin')->nullable();
            },
            'created_at' => function (Blueprint $table): void {
                $table->timestamp('created_at')->nullable();
            },
            'updated_at' => function (Blueprint $table): void {
                $table->timestamp('updated_at')->nullable();
            },
        ];

        foreach ($definitions as $column => $definition) {
            if (! Schema::hasColumn($tableName, $column)) {
                Schema::table($tableName, $definition);
            }
        }
    }

    private function normalizeStatus(string $tableName): void
    {
        if (! Schema::hasColumn($tableName, 'status')) {
            return;
        }

        // MariaDB/MySQL may still have the old enum values after a partial
        // migration. Expand it before mapping, then narrow it to the canonical
        // values. SQLite uses a permissive string column and needs no ALTER.
        if (DB::getDriverName() === 'mysql') {
            try {
                DB::statement(
                    "ALTER TABLE `{$tableName}` MODIFY COLUMN `status` ".
                    "ENUM('baru','diproses','selesai','ditolak','new','processing','resolved','rejected') ".
                    "NOT NULL DEFAULT 'baru'"
                );

                $statusMap = [
                    'new' => 'baru',
                    'processing' => 'diproses',
                    'resolved' => 'selesai',
                    'rejected' => 'ditolak',
                ];

                foreach ($statusMap as $old => $new) {
                    DB::table($tableName)->where('status', $old)->update(['status' => $new]);
                }

                DB::statement(
                    "ALTER TABLE `{$tableName}` MODIFY COLUMN `status` ".
                    "ENUM('baru','diproses','selesai','ditolak') NOT NULL DEFAULT 'baru'"
                );
            } catch (Throwable $e) {
                // A non-standard/partial enum must not make the migration drop
                // data. The application can still read the existing values.
                report($e);
            }
        }
    }

    private function copyLegacyRows(string $sourceTable, string $targetTable): void
    {
        if (! Schema::hasTable($sourceTable) || ! Schema::hasTable($targetTable)) {
            return;
        }

        // Never merge two schemas using fuzzy matching. If a canonical table
        // already contains rows, leave both schemas untouched and require an
        // explicit reconciliation instead of silently dropping or duplicating
        // a complaint.
        if (DB::table($targetTable)->exists()) {
            return;
        }

        if (! Schema::hasColumn($sourceTable, 'id')) {
            report(new RuntimeException("Legacy table {$sourceTable} has no id column; complaint copy was skipped."));

            return;
        }

        $query = DB::table($sourceTable.' as source');
        $columns = ['source.*'];

        // The original complaints schema stored the reporter and category as
        // foreign keys. Join them when available so the copied row keeps as
        // much identifying information as the legacy schema provided.
        if (Schema::hasColumn($sourceTable, 'user_id') && Schema::hasTable('users')) {
            $query->leftJoin('users as legacy_user', 'legacy_user.id', '=', 'source.user_id');
            $columns[] = 'legacy_user.name as legacy_user_name';
        }

        if (Schema::hasColumn($sourceTable, 'category_id') && Schema::hasTable('complaint_categories')) {
            $query->leftJoin('complaint_categories as legacy_category', 'legacy_category.id', '=', 'source.category_id');
            $columns[] = 'legacy_category.name as legacy_category_name';
        }

        $query->select($columns)->orderBy('source.id');

        // The whole copy is transactional and the cursor avoids loading an
        // unbounded legacy table into memory. Because the target was verified
        // empty, every source row is copied exactly once; a failed transaction
        // can be retried safely.
        DB::transaction(function () use ($query, $targetTable): void {
            foreach ($query->cursor() as $row) {
                $sourceCreatedAt = $this->firstValue($row, ['created_at']);
                DB::table($targetTable)->insert([
                    'nama' => (string) ($this->firstValue($row, ['nama', 'legacy_user_name', 'title']) ?? 'Warga'),
                    'no_whatsapp' => (string) ($this->firstValue($row, ['no_whatsapp', 'whatsapp', 'phone']) ?? ''),
                    'kategori' => $this->normalizeCategory(
                        $this->firstValue($row, ['kategori', 'legacy_category_name', 'category'])
                    ),
                    'isi_laporan' => (string) ($this->firstValue($row, ['isi_laporan', 'description', 'title']) ?? ''),
                    'lampiran' => $this->firstValue($row, ['lampiran', 'attachment_path']),
                    'status' => $this->mapStatus($this->firstValue($row, ['status'])),
                    'catatan_admin' => $this->firstValue($row, ['catatan_admin', 'admin_response']),
                    'created_at' => $sourceCreatedAt ?? now(),
                    'updated_at' => $this->firstValue($row, ['updated_at']) ?? now(),
                ]);
            }
        });
    }

    private function normalizeCategory(mixed $category): string
    {
        $value = strtolower(trim((string) $category));
        $aliases = [
            'layanan' => 'layanan_publik',
            'layanan publik' => 'layanan_publik',
            'keamanan & ketertiban' => 'keamanan',
            'lingkungan hidup' => 'lingkungan',
            'administrasi' => 'kependudukan',
            'kependudukan' => 'kependudukan',
            'infrastruktur' => 'infrastruktur',
        ];

        $value = $aliases[$value] ?? $value;

        return in_array($value, [
            'infrastruktur',
            'kependudukan',
            'keamanan',
            'lingkungan',
            'layanan_publik',
            'lainnya',
        ], true) ? $value : 'lainnya';
    }

    private function firstValue(object $row, array $keys): mixed
    {
        foreach ($keys as $key) {
            if (isset($row->{$key}) && $row->{$key} !== '') {
                return $row->{$key};
            }
        }

        return null;
    }

    private function mapStatus(mixed $status): string
    {
        return match ((string) $status) {
            'processing' => 'diproses',
            'resolved' => 'selesai',
            'rejected' => 'ditolak',
            'baru', 'diproses', 'selesai', 'ditolak' => (string) $status,
            default => 'baru',
        };
    }
};
