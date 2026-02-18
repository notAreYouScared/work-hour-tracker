<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'manager_id',
        'area_manager_id',
        'skill_trade_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'role' => Role::class,
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(self::class, 'manager_id');
    }

    public function areaManager(): BelongsTo
    {
        return $this->belongsTo(self::class, 'area_manager_id');
    }

    public function skillTrade(): BelongsTo
    {
        return $this->belongsTo(SkillTrade::class);
    }

    public function weeklySheets(): HasMany
    {
        return $this->hasMany(WeeklySheet::class);
    }

    public function managedEmployees(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'manager_employee', 'manager_id', 'employee_id');
    }
}
