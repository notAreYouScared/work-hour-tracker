<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HourSection extends Model
{
    protected $fillable = [
        'skill_trade',
        'name',
        'display_order',
        'target_hours',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    public function categories(): HasMany
    {
        return $this->hasMany(HourCategory::class)->orderBy('display_order');
    }
}
