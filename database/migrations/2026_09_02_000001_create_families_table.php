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
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('kk_number')->unique(); // Nomor Kartu Keluarga
            $table->string('head_of_family'); // Kepala Keluarga
            $table->text('address'); // Alamat
            $table->integer('total_members')->default(0); // Jumlah anggota
            $table->timestamps();
            
            $table->index('kk_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
