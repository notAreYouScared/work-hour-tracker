<?php

namespace App\Observers;

use App\Models\EmployeeProfile;
use LogicException;

class EmployeeProfileObserver
{
    public function updating(EmployeeProfile $employeeProfile): void
    {
        if ($employeeProfile->isDirty('trade_id')) {
            throw new LogicException('Employee skill trade is immutable once assigned.');
        }
    }
}
