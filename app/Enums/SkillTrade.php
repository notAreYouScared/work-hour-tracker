<?php

namespace App\Enums;

enum SkillTrade: string
{
    case DieMaker = 'Die Maker';
    case MetalModelMaker = 'Metal Model Maker';
    case WoodModelMaker = 'Wood Model Maker';
    case ExperimentalAuto = 'Experimental Auto';
    case AutoInspector = 'Auto Inspector';
    case ToolAndDieWelder = 'Tool & Die Welder';
    case Electrician = 'Electrician';
    case MachineRepair = 'Machine Repair';
    case Millwright = 'Millwright';
    case Pipefitter = 'Pipefitter';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
