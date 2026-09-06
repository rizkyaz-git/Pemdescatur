<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LetterTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'template_text',
        'description',
    ];

    /**
     * Get all requests for this template
     */
    public function requests(): HasMany
    {
        return $this->hasMany(LetterRequest::class, 'template_id');
    }

    /**
     * Get pending requests count
     */
    public function getPendingCountAttribute()
    {
        return $this->requests()->where('status', 'pending')->count();
    }
}
