<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_desa',
        'asal_usul_nama',
        'history',
        'vision',
        'mission',
        'image',
        'luas_wilayah_ha',
        'ketinggian_mdpl',
        'koordinat_lat',
        'koordinat_lng',
        'batas_utara',
        'batas_selatan',
        'batas_timur',
        'batas_barat',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'jumlah_dukuh',
        'jumlah_kadus',
        'curah_hujan_mm',
        'suhu_max',
        'suhu_min',
        'jenis_tanah',
        'sumber_air',
    ];
}

