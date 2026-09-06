<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->string('nama_desa')->default('Desa Catur')->after('id');
            $table->string('asal_usul_nama')->nullable()->after('nama_desa');
            $table->decimal('luas_wilayah_ha', 10, 4)->nullable()->after('asal_usul_nama');
            $table->integer('ketinggian_mdpl')->nullable()->after('luas_wilayah_ha');
            $table->decimal('koordinat_lat', 10, 7)->nullable()->after('ketinggian_mdpl');
            $table->decimal('koordinat_lng', 10, 7)->nullable()->after('koordinat_lat');
            $table->string('batas_utara')->nullable()->after('koordinat_lng');
            $table->string('batas_selatan')->nullable()->after('batas_utara');
            $table->string('batas_timur')->nullable()->after('batas_selatan');
            $table->string('batas_barat')->nullable()->after('batas_timur');
            $table->string('kecamatan')->default('Sambi')->after('batas_barat');
            $table->string('kabupaten')->default('Boyolali')->after('kecamatan');
            $table->string('provinsi')->default('Jawa Tengah')->after('kabupaten');
            $table->integer('jumlah_dukuh')->nullable()->after('provinsi');
            $table->integer('jumlah_kadus')->nullable()->after('jumlah_dukuh');
            $table->integer('curah_hujan_mm')->nullable()->after('jumlah_kadus');
            $table->decimal('suhu_max', 4, 1)->nullable()->after('curah_hujan_mm');
            $table->decimal('suhu_min', 4, 1)->nullable()->after('suhu_max');
            $table->string('jenis_tanah')->nullable()->after('suhu_min');
            $table->text('sumber_air')->nullable()->after('jenis_tanah');
        });
    }

    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'nama_desa', 'asal_usul_nama', 'luas_wilayah_ha', 'ketinggian_mdpl',
                'koordinat_lat', 'koordinat_lng', 'batas_utara', 'batas_selatan',
                'batas_timur', 'batas_barat', 'kecamatan', 'kabupaten', 'provinsi',
                'jumlah_dukuh', 'jumlah_kadus', 'curah_hujan_mm', 'suhu_max', 'suhu_min',
                'jenis_tanah', 'sumber_air',
            ]);
        });
    }
};
