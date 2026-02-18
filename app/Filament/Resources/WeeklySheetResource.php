<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeeklySheetResource\Pages;
use App\Models\WeeklySheet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WeeklySheetResource extends Resource
{
    protected static ?string $model = WeeklySheet::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('employee_id')->relationship('employee', 'name')->required(),
            Forms\Components\Select::make('manager_id')->relationship('manager', 'name'),
            Forms\Components\TextInput::make('week_number')->numeric()->required(),
            Forms\Components\DatePicker::make('week_ending_date')->required(),
            Forms\Components\Select::make('status')
                ->options([
                    'draft' => 'Draft',
                    'submitted' => 'Submitted',
                    'approved' => 'Approved',
                    'denied' => 'Denied',
                ])->required(),
            Forms\Components\Textarea::make('manager_comment')->rows(3),
            Forms\Components\Repeater::make('entries')
                ->relationship()
                ->schema([
                    Forms\Components\Select::make('hour_category_id')
                        ->relationship('category', 'name')
                        ->required()
                        ->searchable(),
                    Forms\Components\Grid::make(7)
                        ->schema([
                            Forms\Components\TextInput::make('monday')->numeric()->default(0)->live(onBlur: true),
                            Forms\Components\TextInput::make('tuesday')->numeric()->default(0)->live(onBlur: true),
                            Forms\Components\TextInput::make('wednesday')->numeric()->default(0)->live(onBlur: true),
                            Forms\Components\TextInput::make('thursday')->numeric()->default(0)->live(onBlur: true),
                            Forms\Components\TextInput::make('friday')->numeric()->default(0)->live(onBlur: true),
                            Forms\Components\TextInput::make('saturday')->numeric()->default(0)->live(onBlur: true),
                            Forms\Components\TextInput::make('sunday')->numeric()->default(0)->live(onBlur: true),
                        ]),
                    Forms\Components\TextInput::make('week_total')
                        ->numeric()
                        ->readOnly()
                        ->dehydrated()
                        ->afterStateHydrated(function (Forms\Set $set, Forms\Get $get): void {
                            $set('week_total', collect(['monday','tuesday','wednesday','thursday','friday','saturday','sunday'])
                                ->sum(fn ($day) => (float) ($get($day) ?? 0)));
                        }),
                    Forms\Components\TextInput::make('lifetime_total')->numeric()->default(0),
                ])
                ->columns(1)
                ->defaultItems(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.name')->searchable(),
                Tables\Columns\TextColumn::make('week_ending_date')->date(),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('entries_sum_week_total')
                    ->label('Weekly Total')
                    ->sum('entries', 'week_total'),
                Tables\Columns\TextColumn::make('entries_sum_lifetime_total')
                    ->label('Lifetime Total')
                    ->sum('entries', 'lifetime_total'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve')
                    ->visible(fn (WeeklySheet $record) => $record->status === 'submitted')
                    ->action(function (WeeklySheet $record): void {
                        $record->update([
                            'status' => 'approved',
                            'approved_at' => now(),
                            'approved_by' => auth()->id(),
                        ]);
                    }),
                Tables\Actions\Action::make('deny')
                    ->visible(fn (WeeklySheet $record) => $record->status === 'submitted')
                    ->form([
                        Forms\Components\Textarea::make('manager_comment')->required(),
                    ])
                    ->action(function (WeeklySheet $record, array $data): void {
                        $record->update([
                            'status' => 'denied',
                            'manager_comment' => $data['manager_comment'],
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
