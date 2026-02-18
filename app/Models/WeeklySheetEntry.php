<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeeklySheetEntry extends Model
{
    protected $fillable = [
        'weekly_sheet_id',
        'hour_line_id',
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

    protected $casts = [
        'monday' => 'decimal:2',
        'tuesday' => 'decimal:2',
        'wednesday' => 'decimal:2',
        'thursday' => 'decimal:2',
        'friday' => 'decimal:2',
        'saturday' => 'decimal:2',
        'sunday' => 'decimal:2',
        'week_total' => 'decimal:2',
        'lifetime_total' => 'decimal:2',
    ];

    public function weeklySheet(): BelongsTo
    {
        return $this->belongsTo(WeeklySheet::class);
    }

    public function hourLine(): BelongsTo
    {
        return $this->belongsTo(HourLine::class);
    }

    public function recalculateTotals(): void
    {
        $this->week_total = collect([
            $this->monday,
            $this->tuesday,
            $this->wednesday,
            $this->thursday,
            $this->friday,
            $this->saturday,
            $this->sunday,
        ])->sum();
    }
}
