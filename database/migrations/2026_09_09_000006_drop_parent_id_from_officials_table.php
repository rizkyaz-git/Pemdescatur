<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('officials', 'parent_id')) {
            Schema::table('officials', function (Blueprint $table) {
                // Drop foreign key first if exists
                try {
                    $table->dropForeign(['parent_id']);
                } catch (\Throwable $e) {
                    // Foreign key might already be dropped or named differently
                }
                $table->dropColumn('parent_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('officials', 'parent_id')) {
            Schema::table('officials', function (Blueprint $table) {
                $table->foreignId('parent_id')->nullable()->constrained('officials')->nullOnDelete();
            });
        }
    }
};
