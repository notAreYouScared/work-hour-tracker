<?php

namespace App\Filament\Resources;

use App\Enums\RoleName;
use App\Filament\Resources\WeeklySheetResource\Pages;
use App\Models\WeeklySheet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WeeklySheetResource extends Resource
{
    protected static ?string $model = WeeklySheet::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\DatePicker::make('week_start_date')->required(),
            Forms\Components\DatePicker::make('week_end_date')->required(),
            Forms\Components\TextInput::make('week_number')->numeric()->required(),
            Forms\Components\Textarea::make('manager_notes')->columnSpanFull(),
            Forms\Components\Repeater::make('entries')
                ->relationship()
                ->schema([
                    Forms\Components\Select::make('hour_template_id')->relationship('template', 'row_label')->required(),
                    Forms\Components\TextInput::make('monday_hours')->numeric()->default(0),
                    Forms\Components\TextInput::make('tuesday_hours')->numeric()->default(0),
                    Forms\Components\TextInput::make('wednesday_hours')->numeric()->default(0),
                    Forms\Components\TextInput::make('thursday_hours')->numeric()->default(0),
                    Forms\Components\TextInput::make('friday_hours')->numeric()->default(0),
                    Forms\Components\TextInput::make('saturday_hours')->numeric()->default(0),
                    Forms\Components\TextInput::make('sunday_hours')->numeric()->default(0),
                    Forms\Components\TextInput::make('week_total')
                        ->numeric()
                        ->disabled()
                        ->dehydrated(true)
                        ->afterStateHydrated(function (Forms\Set $set, Forms\Get $get) {
                            $set('week_total', collect([
                                $get('monday_hours'), $get('tuesday_hours'), $get('wednesday_hours'),
                                $get('thursday_hours'), $get('friday_hours'), $get('saturday_hours'), $get('sunday_hours'),
                            ])->map(fn ($val) => (float) $val)->sum());
                        }),
                ])
                ->columns(3)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.name')->label('Employee')->searchable(),
                Tables\Columns\TextColumn::make('week_end_date')->date(),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('weekly_total')->label('Week Total'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('submit')
                    ->visible(fn (WeeklySheet $record) => $record->status === 'draft' && auth()->id() === $record->employee_id)
                    ->action(fn (WeeklySheet $record) => $record->update(['status' => 'submitted', 'submitted_at' => now()])),
                Tables\Actions\Action::make('approve')
                    ->visible(fn (WeeklySheet $record) => $record->status === 'submitted' && auth()->user()?->hasRole(RoleName::Manager->value))
                    ->action(fn (WeeklySheet $record) => $record->update([
                        'status' => 'approved',
                        'approved_at' => now(),
                        'manager_id' => auth()->id(),
                    ])),
                Tables\Actions\Action::make('deny')
                    ->visible(fn (WeeklySheet $record) => $record->status === 'submitted' && auth()->user()?->hasRole(RoleName::Manager->value))
                    ->requiresConfirmation()
                    ->action(fn (WeeklySheet $record) => $record->update([
                        'status' => 'denied',
                        'denied_at' => now(),
                        'manager_id' => auth()->id(),
                    ])),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->with(['employee', 'entries']);
        $user = auth()->user();

        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        if ($user->hasRole(RoleName::RootAdmin->value) || $user->hasRole(RoleName::AreaManager->value)) {
            return $query;
        }

        if ($user->hasRole(RoleName::Coordinator->value)) {
            return $query->where('status', 'approved');
        }

        if ($user->hasRole(RoleName::Manager->value)) {
            return $query->whereIn('employee_id', $user->managedEmployees()->pluck('users.id'));
        }

        return $query->where('employee_id', $user->id);
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
