<?php

namespace App\Models;

use App\Enums\SheetStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeeklySheet extends Model
{
    protected $fillable = [
        'user_id',
        'week_ending',
        'week_number',
        'status',
        'submitted_at',
        'reviewed_at',
        'reviewed_by',
        'denial_reason',
    ];

    protected $casts = [
        'week_ending' => 'date',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'status' => SheetStatus::class,
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function entries(): HasMany
    {
        return $this->hasMany(WeeklySheetEntry::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
