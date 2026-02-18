<?php

namespace App\Filament\Resources\WeeklySheetResource\Pages;

use App\Filament\Resources\WeeklySheetResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWeeklySheet extends CreateRecord
{
    protected static string $resource = WeeklySheetResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['employee_id'] = auth()->id();
        $data['status'] = 'draft';

        return $data;
    }
}
