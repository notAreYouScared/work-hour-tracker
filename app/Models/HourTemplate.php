<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HourTemplate extends Model
{
    protected $fillable = [
        'trade_id',
        'section_number',
        'section_title',
        'row_label',
        'area_affected',
        'required_program_hours',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'required_program_hours' => 'decimal:2',
        'is_active' => 'bool',
    ];

    public function trade(): BelongsTo
    {
        return $this->belongsTo(Trade::class);
    }

    public function sheetEntries(): HasMany
    {
        return $this->hasMany(WeeklySheetEntry::class, 'hour_template_id');
    }
}
