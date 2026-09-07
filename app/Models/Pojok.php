<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pojok extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi_singkat',
        'gambar',
    ];

    /**
     * Get all activities associated with this Pojok.
     */
    public function kegiatans(): HasMany
    {
        return $this->hasMany(Kegiatan::class);
    }

    /**
     * Get all curriculum documents associated with this Pojok.
     */
    public function kurikulums(): HasMany
    {
        return $this->hasMany(Kurikulum::class);
    }
}
