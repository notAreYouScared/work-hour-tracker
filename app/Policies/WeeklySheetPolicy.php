<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;
use App\Models\WeeklySheet;

class WeeklySheetPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            Role::Employee->value,
            Role::Manager->value,
            Role::AreaManager->value,
            Role::Coordinator->value,
            Role::RootAdmin->value,
        ]);
    }

    public function view(User $user, WeeklySheet $weeklySheet): bool
    {
        if ($user->hasRole(Role::RootAdmin->value) || $user->hasRole(Role::AreaManager->value)) {
            return true;
        }

        if ($user->hasRole(Role::Employee->value)) {
            return $weeklySheet->employee_id === $user->id;
        }

        if ($user->hasRole(Role::Manager->value)) {
            return $weeklySheet->manager_id === $user->id;
        }

        if ($user->hasRole(Role::Coordinator->value)) {
            return $weeklySheet->status === 'approved';
        }

        return false;
    }
}
