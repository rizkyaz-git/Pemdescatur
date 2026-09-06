<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_id',
        'nik',
        'name',
        'gender',
        'birth_place',
        'birth_date',
        'relationship_to_head',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Get the family this resident belongs to
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * Boot method untuk auto-update total_members di family
     */
    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($resident) {
            if ($resident->family) {
                $resident->family->update([
                    'total_members' => $resident->family->residents()->count()
                ]);
            }
        });

        static::deleted(function ($resident) {
            if ($resident->family) {
                $resident->family->update([
                    'total_members' => $resident->family->residents()->count()
                ]);
            }
        });

        static::updated(function ($resident) {
            if ($resident->status === 'meninggal' || $resident->status === 'pindah') {
                if ($resident->family) {
                    $resident->family->update([
                        'total_members' => $resident->family->residents()->where('status', 'hidup')->count()
                    ]);
                }
            }
        });
    }
}
