<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
     * Permohonan yang belum ditandai selesai.
     *
     * The existing enum has no "selesai" value. A non-null processed_at is
     * therefore the canonical completion marker for the new admin workflow;
     * the legacy status values are retained only for backward compatibility.
     */
    public function scopeUnfinished(Builder $query): Builder
    {
        return $query
            ->where('status', 'pending')
            ->whereNull('processed_at');
    }

    /**
     * Permohonan yang sudah selesai, termasuk record legacy yang belum punya
     * processed_at tetapi pernah diproses memakai status lama.
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where(function (Builder $query): void {
            $query->whereNotNull('processed_at')
                ->orWhereIn('status', ['approved', 'rejected']);
        });
    }

    public function isCompleted(): bool
    {
        return $this->processed_at !== null
            || in_array($this->status, ['approved', 'rejected'], true);
    }

    public function markCompleted(): void
    {
        $this->forceFill([
            // Keep the existing enum compatible with older consumers while
            // processed_at remains the source of truth for this workflow.
            'status' => 'approved',
            'processed_at' => now(),
        ])->save();
    }
}
