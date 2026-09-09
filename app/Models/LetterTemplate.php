<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class LetterTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'file_path',
        'description',
        'requirements',
        'template_text',
    ];

    /**
     * Get all requests for this template
     */
    public function requests(): HasMany
    {
        return $this->hasMany(LetterRequest::class, 'template_id');
    }

    /**
     * Check if ready-to-print template file exists
     */
    public function getHasFileAttribute(): bool
    {
        return !empty($this->file_path) && Storage::disk('public')->exists($this->file_path);
    }

    /**
     * Get URL of ready-to-print template file
     */
    public function getFileUrlAttribute(): ?string
    {
        if ($this->has_file) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }

    /**
     * Get file extension uppercase
     */
    public function getFileExtensionAttribute(): string
    {
        if (!empty($this->file_path)) {
            return strtoupper(pathinfo($this->file_path, PATHINFO_EXTENSION));
        }
        return 'DOCX';
    }

    /**
     * Get formatted human readable file size
     */
    public function getFileSizeFormattedAttribute(): string
    {
        if ($this->has_file) {
            $bytes = Storage::disk('public')->size($this->file_path);
            if ($bytes >= 1048576) {
                return number_format($bytes / 1048576, 1) . ' MB';
            } elseif ($bytes >= 1024) {
                return number_format($bytes / 1024, 0) . ' KB';
            }
            return $bytes . ' B';
        }
        return '-';
    }
}
