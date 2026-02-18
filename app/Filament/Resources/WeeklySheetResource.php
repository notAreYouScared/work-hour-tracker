<?php

namespace App\Filament\Resources;

use App\Enums\SheetStatus;
use App\Filament\Resources\WeeklySheetResource\Pages;
use App\Models\WeeklySheet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class WeeklySheetResource extends Resource
{
    protected static ?string $model = WeeklySheet::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->relationship('employee', 'name')
                ->required(),
            Forms\Components\DatePicker::make('week_ending')->required(),
            Forms\Components\TextInput::make('week_number')->numeric()->required(),
            Forms\Components\Select::make('status')
                ->options([
                    SheetStatus::Draft->value => 'Draft',
                    SheetStatus::Submitted->value => 'Submitted',
                    SheetStatus::Approved->value => 'Approved',
                    SheetStatus::Denied->value => 'Denied',
                ])
                ->required(),
            Forms\Components\Textarea::make('denial_reason')
                ->visible(fn (Forms\Get $get): bool => $get('status') === SheetStatus::Denied->value),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.name')->searchable(),
                Tables\Columns\TextColumn::make('week_ending')->date(),
                Tables\Columns\TextColumn::make('week_number'),
                Tables\Columns\BadgeColumn::make('status'),
                Tables\Columns\TextColumn::make('entries_sum_week_total')
                    ->sum('entries', 'week_total')
                    ->label('Week Total'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('approve')
                    ->visible(fn (WeeklySheet $record): bool => $record->status === SheetStatus::Submitted)
                    ->requiresConfirmation()
                    ->action(function (WeeklySheet $record): void {
                        $record->update([
                            'status' => SheetStatus::Approved,
                            'reviewed_at' => now(),
                            'reviewed_by' => auth()->id(),
                            'denial_reason' => null,
                        ]);
                    }),
                Action::make('deny')
                    ->visible(fn (WeeklySheet $record): bool => $record->status === SheetStatus::Submitted)
                    ->form([
                        Forms\Components\Textarea::make('denial_reason')->required(),
                    ])
                    ->action(function (WeeklySheet $record, array $data): void {
                        $record->update([
                            'status' => SheetStatus::Denied,
                            'reviewed_at' => now(),
                            'reviewed_by' => auth()->id(),
                            'denial_reason' => $data['denial_reason'],
                        ]);
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWeeklySheets::route('/'),
            'create' => Pages\CreateWeeklySheet::route('/create'),
            'edit' => Pages\EditWeeklySheet::route('/{record}/edit'),
        ];
    }
}
