<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Follow-up repair for installations where an earlier public-service
 * migration was marked as applied before its schema/data work completed.
 *
 * This migration is deliberately additive and non-destructive. It normalizes
 * values that the application already understands, backfills nullable legacy
 * timestamps, and only copies the old complaint table when the canonical table
 * is verified empty.
 */
return new class extends Migration
{
    private const COMPLAINT_STATUSES = ['baru', 'diproses', 'selesai', 'ditolak'];

    public function up(): void
    {
        $this->ensureLaporansTable();
        $this->ensureLetterRequestTable();
        $this->normalizeComplaintStatus();
        $this->backfillComplaintRows();
        $this->backfillLetterRequestRows();
        $this->copyLegacyRowsIfTargetIsEmpty();
        $this->assertCanonicalSchema();
    }

    public function down(): void
    {
        // Intentionally non-destructive; see up().
    }

    private function ensureLaporansTable(): void
    {
        if (! Schema::hasTable('laporans')) {
            Schema::create('laporans', function (Blueprint $table): void {
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

            return;
        }

        $this->ensureColumns('laporans');
    }

    private function ensureLetterRequestTable(): void
    {
        if (! Schema::hasTable('letter_requests')) {
            Schema::create('letter_requests', function (Blueprint $table): void {
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

    private function normalizeComplaintStatus(): void
    {
        if (! Schema::hasTable('laporans') || ! Schema::hasColumn('laporans', 'status')) {
            return;
        }

        // A nullable/legacy column must be populated before a NOT NULL enum
        // alteration is attempted.
        DB::table('laporans')->whereNull('status')->update(['status' => 'baru']);

        $column = collect(Schema::getColumns('laporans'))->firstWhere('name', 'status');
        $driver = DB::getDriverName();
        $isEnum = str_contains(strtolower((string) ($column['type'] ?? $column['type_name'] ?? '')), 'enum');

        if ($isEnum && in_array($driver, ['mysql', 'mariadb'], true)) {
            try {
                DB::statement(
                    'ALTER TABLE `laporans` MODIFY COLUMN `status` '.
                    "ENUM('baru','diproses','selesai','ditolak','new','processing','resolved','rejected') ".
                    "NOT NULL DEFAULT 'baru'"
                );
            } catch (Throwable $e) {
                // A non-standard enum can be converted to a bounded string
                // before its values are normalized. This preserves rows while
                // avoiding a failed migration caused by old enum labels.
                try {
                    DB::statement(
                        "ALTER TABLE `laporans` MODIFY COLUMN `status` VARCHAR(20) NOT NULL DEFAULT 'baru'"
                    );
                } catch (Throwable $fallback) {
                    throw $fallback;
                }

                report($e);
            }
        }

        $statusMap = [
            'new' => 'baru',
            'processing' => 'diproses',
            'resolved' => 'selesai',
            'rejected' => 'ditolak',
        ];

        foreach ($statusMap as $old => $new) {
            DB::table('laporans')->where('status', $old)->update(['status' => $new]);
        }

        // Any unknown legacy value is not allowed to make admin rendering or
        // the enum constraint fail. Preserve the row and mark it as needing
        // review instead of deleting it.
        DB::table('laporans')
            ->whereNotIn('status', self::COMPLAINT_STATUSES)
            ->update(['status' => 'baru']);

        if ($isEnum && in_array($driver, ['mysql', 'mariadb'], true)) {
            try {
                DB::statement(
                    'ALTER TABLE `laporans` MODIFY COLUMN `status` '.
                    "ENUM('baru','diproses','selesai','ditolak') NOT NULL DEFAULT 'baru'"
                );
            } catch (Throwable $e) {
                // The values are already normalized; retaining an expanded
                // enum/varchar is safer than failing after data was repaired.
                report($e);
            }
        }
    }

    private function backfillComplaintRows(): void
    {
        $defaults = [
            'nama' => 'Warga',
            'no_whatsapp' => '',
            'kategori' => 'lainnya',
            'isi_laporan' => 'Data laporan lama tidak tersedia.',
        ];

        foreach ($defaults as $column => $value) {
            if (Schema::hasColumn('laporans', $column)) {
                DB::table('laporans')->whereNull($column)->update([$column => $value]);
            }
        }

        $now = now();
        DB::table('laporans')->whereNull('created_at')->update(['created_at' => $now]);
        DB::table('laporans')->whereNull('updated_at')->update(['updated_at' => $now]);
    }

    private function backfillLetterRequestRows(): void
    {
        if (! Schema::hasTable('letter_requests')) {
            return;
        }

        $now = now();
        foreach (['created_at', 'updated_at', 'submitted_at'] as $column) {
            if (Schema::hasColumn('letter_requests', $column)) {
                DB::table('letter_requests')->whereNull($column)->update([$column => $now]);
            }
        }

        if (Schema::hasColumn('letter_requests', 'status')) {
            DB::table('letter_requests')
                ->where(function ($query): void {
                    $query->whereNull('status')
                        ->orWhereNotIn('status', ['pending', 'approved', 'rejected']);
                })
                ->update(['status' => 'pending']);
        }
    }

    private function copyLegacyRowsIfTargetIsEmpty(): void
    {
        if (! Schema::hasTable('complaints') || ! Schema::hasTable('laporans')) {
            return;
        }

        // A populated canonical table is an explicit reconciliation case. Do
        // not guess which same-looking rows correspond to one another.
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

        DB::transaction(function () use ($query): void {
            foreach ($query->cursor() as $row) {
                $createdAt = $this->value($row, ['created_at']);
                DB::table('laporans')->insert([
                    'nama' => (string) ($this->value($row, ['nama', 'legacy_user_name', 'title']) ?? 'Warga'),
                    'no_whatsapp' => $this->phone($this->value($row, ['no_whatsapp', 'whatsapp', 'phone'])),
                    'kategori' => $this->category($this->value($row, ['kategori', 'legacy_category_name', 'category'])),
                    'isi_laporan' => (string) ($this->value($row, ['isi_laporan', 'description', 'title']) ?? ''),
                    'lampiran' => $this->value($row, ['lampiran', 'attachment_path']),
                    'status' => $this->status($this->value($row, ['status'])),
                    'catatan_admin' => $this->value($row, ['catatan_admin', 'admin_response']),
                    'created_at' => $createdAt ?? now(),
                    'updated_at' => $this->value($row, ['updated_at']) ?? now(),
                ]);
            }
        });
    }

    private function phone(mixed $value): string
    {
        $phone = preg_replace('/\D+/', '', (string) $value);
        if ($phone === '') {
            return '';
        }
        if (str_starts_with($phone, '0')) {
            return '62'.substr($phone, 1);
        }
        if (str_starts_with($phone, '62')) {
            return $phone;
        }

        return $phone;
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

    private function assertCanonicalSchema(): void
    {
        $requirements = [
            'laporans' => ['nama', 'no_whatsapp', 'kategori', 'isi_laporan', 'lampiran', 'status', 'catatan_admin', 'created_at', 'updated_at'],
            'letter_requests' => ['user_id', 'template_id', 'ticket_number', 'form_data', 'status', 'created_at', 'updated_at'],
        ];

        foreach ($requirements as $table => $columns) {
            $missing = array_values(array_filter(
                $columns,
                fn (string $column): bool => ! Schema::hasColumn($table, $column)
            ));

            if ($missing !== []) {
                throw new RuntimeException("Canonical table {$table} is missing columns: ".implode(', ', $missing));
            }
        }
    }
};
