<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeeklySheet extends Model
{
    protected $fillable = [
        'employee_id',
        'manager_id',
        'week_start_date',
        'week_end_date',
        'week_number',
        'status',
        'submitted_at',
        'approved_at',
        'denied_at',
        'manager_notes',
    ];

    protected $casts = [
        'week_start_date' => 'date',
        'week_end_date' => 'date',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'denied_at' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function entries(): HasMany
    {
        return $this->hasMany(WeeklySheetEntry::class);
    }

    public function getWeeklyTotalAttribute(): float
    {
        return (float) $this->entries()->sum('week_total');
    }
}
