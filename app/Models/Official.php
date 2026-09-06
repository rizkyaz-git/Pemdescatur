<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Official extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'photo_path',
        'parent_id',
        'order',
        'phone',
        'email',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Official::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Official::class, 'parent_id')->orderBy('order', 'asc');
    }
}
