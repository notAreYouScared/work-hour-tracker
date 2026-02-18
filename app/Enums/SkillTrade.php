<?php

namespace App\Enums;

enum SkillTrade: string
{
    case DieMaker = 'die_maker';
    case MetalModelMaker = 'metal_model_maker';
    case WoodModelMaker = 'wood_model_maker';
    case ExperimentalAuto = 'experimental_auto';
    case AutoInspector = 'auto_inspector';
    case ToolAndDieWelder = 'tool_and_die_welder';
    case Electrician = 'electrician';
    case MachineRepair = 'machine_repair';
    case Millwright = 'millwright';
    case Pipefitter = 'pipefitter';

    public static function labels(): array
    {
        return [
            self::DieMaker->value => 'Die Maker',
            self::MetalModelMaker->value => 'Metal Model Maker',
            self::WoodModelMaker->value => 'Wood Model Maker',
            self::ExperimentalAuto->value => 'Experimental Auto',
            self::AutoInspector->value => 'Auto Inspector',
            self::ToolAndDieWelder->value => 'Tool & Die Welder',
            self::Electrician->value => 'Electrician',
            self::MachineRepair->value => 'Machine Repair',
            self::Millwright->value => 'Millwright',
            self::Pipefitter->value => 'Pipefitter',
        ];
    }
}
