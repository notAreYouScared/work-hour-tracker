<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function employeeProfile(): HasOne
    {
        return $this->hasOne(EmployeeProfile::class);
    }

    public function managedEmployees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'manager_employee', 'manager_id', 'employee_id');
    }

    public function weeklySheets(): HasMany
    {
        return $this->hasMany(WeeklySheet::class, 'employee_id');
    }
}
