<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\RoleName;
use App\Filament\Resources\UserResource;
use App\Models\EmployeeProfile;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $role = $data['role'];
        $tradeId = $data['employee_trade_id'] ?? null;
        unset($data['role'], $data['employee_trade_id']);

        $user = static::getModel()::create($data);
        $user->assignRole($role);

        if ($role === RoleName::Employee->value && $tradeId) {
            EmployeeProfile::create([
                'user_id' => $user->id,
                'trade_id' => $tradeId,
            ]);
        }

        return $user;
    }
}
