<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pojok_id',
        'judul',
        'deskripsi',
        'tanggal_kegiatan',
        'thumbnail',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kegiatan' => 'date',
        ];
    }

    /**
     * Get the pojok that owns the activity.
     */
    public function pojok(): BelongsTo
    {
        return $this->belongsTo(Pojok::class);
    }

    /**
     * Get all gallery photos for the activity.
     */
    public function galeriFotos(): HasMany
    {
        return $this->hasMany(GaleriFoto::class);
    }

    /**
     * Get the user who created the activity.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get public URL for thumbnail.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if (!$this->thumbnail) {
            return null;
        }

        return Storage::disk('public')->url($this->thumbnail);
    }
}
