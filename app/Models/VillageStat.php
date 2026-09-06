<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VillageStat extends Model
{
    use HasFactory;

    protected $table = 'village_stats';

    protected $fillable = [
        'category_id',
        'label',
        'value',
        'year',
        'sub_group',
        'order',
    ];

    protected $casts = [
        'value' => 'float',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(StatCategory::class, 'category_id');
    }
}
