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
        'week_number',
        'week_ending_date',
        'status',
        'manager_comment',
        'approved_at',
        'approved_by',
    ];

    protected function casts(): array
    {
        return [
            'week_ending_date' => 'date',
            'approved_at' => 'datetime',
        ];
    }

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
}
