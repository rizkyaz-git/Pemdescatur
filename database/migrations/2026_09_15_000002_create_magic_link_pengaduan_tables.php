<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pelapors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('nik_hash');
            $table->string('email')->unique();
            $table->timestamps();
        });
        Schema::create('laporans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pelapor_id')->constrained('pelapors')->cascadeOnDelete();
            $table->string('kategori');
            $table->text('isi_laporan');
            $table->string('lampiran')->nullable();
            $table->enum('status', ['pending_verification', 'diterima', 'diproses', 'selesai', 'ditolak'])->default('pending_verification');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
            $table->index(['pelapor_id', 'created_at']);
            $table->index('status');
        });
        Schema::create('login_tokens', function (Blueprint $table) {
            $table->id();
            $table->uuid('pelapor_id')->nullable();
            $table->string('email');
            $table->string('token_hash', 64)->unique();
            $table->uuid('laporan_id')->nullable();
            $table->string('purpose', 32);
            $table->timestamp('expires_at');
            $table->boolean('is_used')->default(false);
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
            $table->foreign('pelapor_id')->references('id')->on('pelapors')->nullOnDelete();
            $table->foreign('laporan_id')->references('id')->on('laporans')->nullOnDelete();
            $table->index(['email', 'purpose']);
            $table->index('expires_at');
        });
        Schema::create('login_attempts', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('ip_address', 45);
            $table->timestamp('attempted_at');
            $table->index(['email', 'attempted_at']);
            $table->index(['ip_address', 'attempted_at']);
        });
        Schema::create('laporan_tanggapans', function (Blueprint $table) {
            $table->id();
            $table->uuid('laporan_id');
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
            $table->text('isi_tanggapan');
            $table->string('status_baru')->nullable();
            $table->timestamps();
            $table->foreign('laporan_id')->references('id')->on('laporans')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('laporan_tanggapans');
        Schema::dropIfExists('login_attempts');
        Schema::dropIfExists('login_tokens');
        Schema::dropIfExists('laporans');
        Schema::dropIfExists('pelapors');
    }
};
