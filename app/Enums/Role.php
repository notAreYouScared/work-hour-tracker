<?php

namespace App\Enums;

enum Role: string
{
    case Employee = 'employee';
    case Manager = 'manager';
    case AreaManager = 'area_manager';
    case Coordinator = 'coordinator';
    case RootAdmin = 'root_admin';

    public static function labels(): array
    {
        return [
            self::Employee->value => 'Employee',
            self::Manager->value => 'Manager',
            self::AreaManager->value => 'Area Manager',
            self::Coordinator->value => 'Coordinator',
            self::RootAdmin->value => 'Root Admin',
        ];
    }
}
