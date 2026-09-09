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
        Schema::dropIfExists('residents');
        Schema::dropIfExists('families');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('kk_number')->unique();
            $table->string('head_of_family');
            $table->text('address');
            $table->integer('total_members')->default(1);
            $table->timestamps();
        });

        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained('families')->onDelete('cascade');
            $table->string('nik')->unique();
            $table->string('name');
            $table->enum('gender', ['L', 'P']);
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('relationship_to_head')->nullable();
            $table->enum('status', ['hidup', 'meninggal', 'pindah'])->default('hidup');
            $table->timestamps();
        });
    }
};
