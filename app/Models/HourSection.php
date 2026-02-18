<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HourSection extends Model
{
    protected $fillable = ['skill_trade_id', 'title', 'target_hours', 'sort_order'];

    public function skillTrade(): BelongsTo
    {
        return $this->belongsTo(SkillTrade::class);
    }

    public function hourLines(): HasMany
    {
        return $this->hasMany(HourLine::class)->orderBy('sort_order');
    }
}
