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
     * Get all downloadable curriculum/module documents associated with this Pojok.
     */
    public function kurikulums(): HasMany
    {
        return $this->hasMany(Kurikulum::class);
    }
}
