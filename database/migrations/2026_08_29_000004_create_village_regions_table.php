<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('village_regions', function (Blueprint $table) {
            $table->id();
            $table->integer('kadus')->default(1); // 1, 2, or 3
            $table->string('nama_dukuh');
            $table->decimal('luas_ha', 8, 4)->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('village_regions');
    }
};
