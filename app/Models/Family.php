<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'kk_number',
        'head_of_family',
        'address',
        'total_members',
    ];

    /**
     * Get all residents in this family
     */
    public function residents(): HasMany
    {
        return $this->hasMany(Resident::class);
    }

    /**
     * Get active residents (hidup)
     */
    public function activeResidents(): HasMany
    {
        return $this->hasMany(Resident::class)->where('status', 'hidup');
    }

    /**
     * Boot method untuk handle cascading delete dan update total_members
     */
    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function ($family) {
            $family->residents()->delete();
        });
    }
}
