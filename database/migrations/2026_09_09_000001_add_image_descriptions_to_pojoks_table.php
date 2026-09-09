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
            $table->string('deskripsi_gambar', 500)->nullable()->after('gambar');
            $table->string('deskripsi_gambar_2', 500)->nullable()->after('gambar_2');
            $table->string('deskripsi_gambar_3', 500)->nullable()->after('gambar_3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pojoks', function (Blueprint $table) {
            $table->dropColumn(['deskripsi_gambar', 'deskripsi_gambar_2', 'deskripsi_gambar_3']);
        });
    }
};
