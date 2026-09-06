<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageRegion extends Model
{
    use HasFactory;

    protected $table = 'village_regions';

    protected $fillable = [
        'kadus',
        'nama_dukuh',
        'luas_ha',
        'keterangan',
        'order',
    ];
}
