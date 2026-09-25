<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Repair guard for installations where the historical complaint refactor was
 * already marked as applied but left a partial schema behind.
 *
 * This migration only creates missing tables/columns or copies rows into an
 * empty canonical table. It never drops, renames, truncates, or replaces an
 * existing table.
 */
return new class extends Migration
{
    public function up(): void
    {
        $this->ensureLaporansTable();
        $this->ensureLetterRequestColumns();
    }

    public function down(): void
    {
        // Deliberately non-destructive; see the class docblock.
    }

    private function ensureLaporansTable(): void
    {
        if (! Schema::hasTable('laporans')) {
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
        } else {
            $this->ensureColumns('laporans');
        }

        if (Schema::hasTable('complaints')) {
            $this->copyLegacyRows();
        }
    }

    private function ensureLetterRequestColumns(): void
    {
        if (! Schema::hasTable('letter_requests')) {
            Schema::create('letter_requests', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('template_id');
                $table->string('ticket_number')->unique();
                $table->json('form_data');
                $table->string('status', 20)->default('pending');
                $table->string('result_file_path')->nullable();
                $table->text('admin_notes')->nullable();
                $table->timestamp('submitted_at')->nullable();
                $table->timestamp('processed_at')->nullable();
                $table->timestamps();
            });

            return;
        }

        $this->ensureColumns('letter_requests', [
            'user_id' => function (Blueprint $table): void {
                $table->unsignedBigInteger('user_id')->nullable();
            },
            'template_id' => function (Blueprint $table): void {
                $table->unsignedBigInteger('template_id')->nullable();
            },
            'ticket_number' => function (Blueprint $table): void {
                $table->string('ticket_number')->nullable();
            },
            'form_data' => function (Blueprint $table): void {
                $table->json('form_data')->nullable();
            },
            'status' => function (Blueprint $table): void {
                $table->string('status', 20)->default('pending');
            },
            'result_file_path' => function (Blueprint $table): void {
                $table->string('result_file_path')->nullable();
            },
            'admin_notes' => function (Blueprint $table): void {
                $table->text('admin_notes')->nullable();
            },
            'submitted_at' => function (Blueprint $table): void {
                $table->timestamp('submitted_at')->nullable();
            },
            'processed_at' => function (Blueprint $table): void {
                $table->timestamp('processed_at')->nullable();
            },
            'created_at' => function (Blueprint $table): void {
                $table->timestamp('created_at')->nullable();
            },
            'updated_at' => function (Blueprint $table): void {
                $table->timestamp('updated_at')->nullable();
            },
        ]);

        $this->ensureLetterRequestUserIsNullable();
    }

    private function ensureLetterRequestUserIsNullable(): void
    {
        $userColumn = collect(Schema::getColumns('letter_requests'))
            ->firstWhere('name', 'user_id');

        if ($userColumn && ! ($userColumn['nullable'] ?? false)) {
            Schema::table('letter_requests', function (Blueprint $table): void {
                $table->unsignedBigInteger('user_id')->nullable()->change();
            });
        }
    }

    /**
     * @param  array<string, callable>  $definitions
     */
    private function ensureColumns(string $tableName, ?array $definitions = null): void
    {
        $definitions ??= [
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

    private function copyLegacyRows(): void
    {
        if (! Schema::hasTable('complaints') || ! Schema::hasTable('laporans')) {
            return;
        }

        // Do not merge populated schemas using name/content heuristics. A
        // canonical row may legitimately have the same text as a legacy row,
        // so copying into a non-empty target could silently lose or duplicate
        // reports. Reconciliation of that state must be explicit.
        if (DB::table('laporans')->exists()) {
            return;
        }

        if (! Schema::hasColumn('complaints', 'id')) {
            report(new RuntimeException('Legacy table complaints has no id column; complaint copy was skipped.'));

            return;
        }

        $query = DB::table('complaints as source');
        $columns = ['source.*'];

        if (Schema::hasColumn('complaints', 'user_id') && Schema::hasTable('users')) {
            $query->leftJoin('users as legacy_user', 'legacy_user.id', '=', 'source.user_id');
            $columns[] = 'legacy_user.name as legacy_user_name';
        }

        if (Schema::hasColumn('complaints', 'category_id') && Schema::hasTable('complaint_categories')) {
            $query->leftJoin('complaint_categories as legacy_category', 'legacy_category.id', '=', 'source.category_id');
            $columns[] = 'legacy_category.name as legacy_category_name';
        }

        $query->select($columns)->orderBy('source.id');

        // Stream the source inside one transaction. The target was verified
        // empty, so every source row is copied exactly once; a failure rolls
        // the copy back and leaves it safe to retry.
        DB::transaction(function () use ($query): void {
            foreach ($query->cursor() as $row) {
                $sourceCreatedAt = $this->value($row, ['created_at']);
                DB::table('laporans')->insert([
                    'nama' => (string) ($this->value($row, ['nama', 'legacy_user_name', 'title']) ?? 'Warga'),
                    'no_whatsapp' => (string) ($this->value($row, ['no_whatsapp', 'whatsapp', 'phone']) ?? ''),
                    'kategori' => $this->category($this->value($row, ['kategori', 'legacy_category_name', 'category'])),
                    'isi_laporan' => (string) ($this->value($row, ['isi_laporan', 'description', 'title']) ?? ''),
                    'lampiran' => $this->value($row, ['lampiran', 'attachment_path']),
                    'status' => $this->status($this->value($row, ['status'])),
                    'catatan_admin' => $this->value($row, ['catatan_admin', 'admin_response']),
                    'created_at' => $sourceCreatedAt ?? now(),
                    'updated_at' => $this->value($row, ['updated_at']) ?? now(),
                ]);
            }
        });
    }

    private function category(mixed $value): string
    {
        $category = strtolower(trim((string) $value));
        $category = match ($category) {
            'layanan', 'layanan publik' => 'layanan_publik',
            'keamanan & ketertiban' => 'keamanan',
            'lingkungan hidup' => 'lingkungan',
            'administrasi' => 'kependudukan',
            default => $category,
        };

        return in_array($category, [
            'infrastruktur',
            'kependudukan',
            'keamanan',
            'lingkungan',
            'layanan_publik',
            'lainnya',
        ], true) ? $category : 'lainnya';
    }

    private function value(object $row, array $keys): mixed
    {
        foreach ($keys as $key) {
            if (isset($row->{$key}) && $row->{$key} !== '') {
                return $row->{$key};
            }
        }

        return null;
    }

    private function status(mixed $value): string
    {
        return match ((string) $value) {
            'processing' => 'diproses',
            'resolved' => 'selesai',
            'rejected' => 'ditolak',
            'baru', 'diproses', 'selesai', 'ditolak' => (string) $value,
            default => 'baru',
        };
    }
};
