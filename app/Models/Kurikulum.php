<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Kurikulum extends Model
{
    use HasFactory;

    protected $fillable = [
        'pojok_id',
        'judul',
        'deskripsi',
        'file_path',
        'file_name',
        'file_size',
        'uploaded_by',
    ];

    /**
     * Get the pojok that owns the curriculum.
     */
    public function pojok(): BelongsTo
    {
        return $this->belongsTo(Pojok::class);
    }

    /**
     * Get the user who uploaded the curriculum.
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the file public URL.
     */
    public function getFileUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->file_path);
    }

    /**
     * Get human readable file size.
     */
    public function getFormattedFileSizeAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 0) . ' KB';
        } elseif ($bytes > 0) {
            return $bytes . ' B';
        }

        return '0 KB';
    }
}
