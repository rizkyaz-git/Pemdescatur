<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LetterRequest extends Model
{
    use HasFactory;

    /**
     * The public services schema uses this explicit table name so a future
     * naming-convention change cannot silently point the model elsewhere.
     */
    protected $table = 'letter_requests';

    protected $fillable = [
        'user_id',
        'template_id',
        'form_data',
        'status',
        'result_file_path',
        'admin_notes',
        'submitted_at',
        'processed_at',
    ];

    protected $casts = [
        'form_data' => 'array',
        'submitted_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    /**
     * Get the user who submitted this request
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the letter template used
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(LetterTemplate::class, 'template_id');
    }

    /**
     * Ensure every request records when it was submitted.
     *
     * The legacy identifier column is intentionally not populated by the
     * application. The database migration keeps that column for historical
     * records.
     */
    protected static function booted(): void
    {
        static::creating(function (self $letterRequest): void {
            $letterRequest->submitted_at ??= now();
        });
    }

    /**
     * Get status label dalam bahasa Indonesia
     */
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Menunggu Verifikasi',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Unknown'
        };
    }
}
