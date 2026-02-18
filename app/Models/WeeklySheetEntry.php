<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeeklySheetEntry extends Model
{
    protected $fillable = [
        'weekly_sheet_id',
        'hour_category_id',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'week_total',
        'lifetime_total',
    ];

    public function weeklySheet(): BelongsTo
    {
        return $this->belongsTo(WeeklySheet::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(HourCategory::class, 'hour_category_id');
    }
}
