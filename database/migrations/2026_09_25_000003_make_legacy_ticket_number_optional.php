<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Stop requiring the retired ticket identifier for new submissions while
 * preserving the column and all values written by older application versions.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('letter_requests') || ! Schema::hasColumn('letter_requests', 'ticket_number')) {
            return;
        }

        $column = collect(Schema::getColumns('letter_requests'))
            ->firstWhere('name', 'ticket_number');

        if ($column && ! ($column['nullable'] ?? false)) {
            Schema::table('letter_requests', function (Blueprint $table): void {
                $table->string('ticket_number')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        // Do not restore NOT NULL: new rows intentionally have no legacy value.
    }
};
