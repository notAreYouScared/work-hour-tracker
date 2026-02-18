<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HourCategory extends Model
{
    protected $fillable = [
        'hour_section_id',
        'name',
        'details',
        'area_affected',
        'target_hours',
        'display_order',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(HourSection::class, 'hour_section_id');
    }
}
