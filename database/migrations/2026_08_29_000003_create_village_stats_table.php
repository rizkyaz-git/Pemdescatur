<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('village_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('village_stat_categories')->cascadeOnDelete();
            $table->string('label');          // e.g. 'Petani', 'Pendapatan'
            $table->decimal('value', 15, 2);  // numeric value
            $table->integer('year')->nullable(); // null = berlaku umum/tidak terikat tahun
            $table->string('sub_group')->nullable(); // e.g. 'laki-laki', 'perempuan', 'Belanja'
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('village_stats');
    }
};
