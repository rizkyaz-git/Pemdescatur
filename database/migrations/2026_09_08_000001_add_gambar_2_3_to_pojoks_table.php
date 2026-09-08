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
            $table->string('gambar_2')->nullable()->after('gambar');
            $table->string('gambar_3')->nullable()->after('gambar_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pojoks', function (Blueprint $table) {
            $table->dropColumn(['gambar_2', 'gambar_3']);
        });
    }
};
