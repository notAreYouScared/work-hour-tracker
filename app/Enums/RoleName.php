<?php

namespace App\Enums;

enum RoleName: string
{
    case Employee = 'employee';
    case Manager = 'manager';
    case AreaManager = 'area_manager';
    case Coordinator = 'coordinator';
    case RootAdmin = 'root_admin';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
