<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeeklySheetEntry extends Model
{
    protected $fillable = [
        'weekly_sheet_id',
        'hour_template_id',
        'monday_hours',
        'tuesday_hours',
        'wednesday_hours',
        'thursday_hours',
        'friday_hours',
        'saturday_hours',
        'sunday_hours',
        'week_total',
        'lifetime_total_snapshot',
    ];

    protected $casts = [
        'monday_hours' => 'decimal:2',
        'tuesday_hours' => 'decimal:2',
        'wednesday_hours' => 'decimal:2',
        'thursday_hours' => 'decimal:2',
        'friday_hours' => 'decimal:2',
        'saturday_hours' => 'decimal:2',
        'sunday_hours' => 'decimal:2',
        'week_total' => 'decimal:2',
        'lifetime_total_snapshot' => 'decimal:2',
    ];

    public function sheet(): BelongsTo
    {
        return $this->belongsTo(WeeklySheet::class, 'weekly_sheet_id');
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(HourTemplate::class, 'hour_template_id');
    }
}
