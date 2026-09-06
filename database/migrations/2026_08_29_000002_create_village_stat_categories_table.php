<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('village_stat_categories', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // e.g. 'mata_pencaharian', 'apbdes'
            $table->string('label');         // e.g. 'Mata Pencaharian Penduduk'
            $table->string('chart_type')->default('bar'); // bar|pie|line|stat|stacked_bar
            $table->string('unit')->nullable(); // e.g. 'orang', 'Rp', 'km'
            $table->string('section')->nullable(); // e.g. 'demografi', 'ekonomi', 'infrastruktur'
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('village_stat_categories');
    }
};
