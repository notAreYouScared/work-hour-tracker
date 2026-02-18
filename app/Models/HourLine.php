<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HourLine extends Model
{
    protected $fillable = [
        'hour_section_id',
        'description',
        'area_affected',
        'target_hours',
        'sort_order',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(HourSection::class, 'hour_section_id');
    }
}
