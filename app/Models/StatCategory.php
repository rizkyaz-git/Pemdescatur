<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatCategory extends Model
{
    use HasFactory;

    protected $table = 'village_stat_categories';

    protected $fillable = [
        'key',
        'label',
        'chart_type',
        'unit',
        'section',
        'order',
    ];

    public function stats(): HasMany
    {
        return $this->hasMany(VillageStat::class, 'category_id')->orderBy('order')->orderBy('year');
    }
}
