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
        Schema::table('pojoks', function (Blueprint $table) {
            $table->string('gambar')->nullable()->after('deskripsi_singkat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pojoks', function (Blueprint $table) {
            $table->dropColumn('gambar');
        });
    }
};
