<?php

namespace App\Policies;

use App\Enums\Role;
use App\Enums\SheetStatus;
use App\Models\User;
use App\Models\WeeklySheet;

class WeeklySheetPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [
            Role::Employee,
            Role::Manager,
            Role::AreaManager,
            Role::Coordinator,
            Role::RootAdmin,
        ], true);
    }

    public function view(User $user, WeeklySheet $sheet): bool
    {
        return match ($user->role) {
            Role::Employee => $sheet->user_id === $user->id,
            Role::Manager => $sheet->employee->manager_id === $user->id,
            Role::AreaManager => $sheet->employee->area_manager_id === $user->id,
            Role::Coordinator => $sheet->status === SheetStatus::Approved,
            Role::RootAdmin => true,
        };
    }

    public function update(User $user, WeeklySheet $sheet): bool
    {
        return $user->role === Role::Employee && $sheet->user_id === $user->id && $sheet->status !== SheetStatus::Approved;
    }
}
