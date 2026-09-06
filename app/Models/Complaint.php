<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'attachment_path',
        'status',
        'admin_response',
        'responded_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    /**
     * Get the user who submitted this complaint
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of this complaint
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ComplaintCategory::class, 'category_id');
    }

    /**
     * Get ticket number accessor
     */
    public function getTicketNumberAttribute(): string
    {
        $date = $this->created_at ? $this->created_at->format('Ym') : date('Ym');
        return 'PGD-' . $date . '-' . str_pad($this->id ?? 0, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Get status label dalam bahasa Indonesia
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'new' => 'Baru',
            'processing' => 'Sedang Diproses',
            'resolved' => 'Selesai',
            default => 'Unknown'
        };
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'new' => 'danger',
            'processing' => 'warning',
            'resolved' => 'success',
            default => 'secondary'
        };
    }
}
