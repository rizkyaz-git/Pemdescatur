<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LetterRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'template_id',
        'ticket_number',
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
     * Boot method untuk generate ticket number otomatis
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            // Generate ticket number: TKT-202609-00001
            $year = date('Y');
            $month = date('m');
            $countThisMonth = self::whereYear('submitted_at', $year)
                ->whereMonth('submitted_at', $month)
                ->count();
            
            $model->ticket_number = 'TKT-' . $year . $month . '-' . str_pad($countThisMonth + 1, 5, '0', STR_PAD_LEFT);
            $model->submitted_at = now();
        });
    }

    /**
     * Get status label dalam bahasa Indonesia
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Verifikasi',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Unknown'
        };
    }
}
