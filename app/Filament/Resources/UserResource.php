<?php

namespace App\Filament\Resources;

use App\Enums\RoleName;
use App\Filament\Resources\UserResource\Pages;
use App\Models\Trade;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('email')->email()->required(),
            Forms\Components\Select::make('role')
                ->options(array_combine(RoleName::values(), RoleName::values()))
                ->required()
                ->dehydrated(false)
                ->afterStateHydrated(function ($component, ?User $record) {
                    if ($record) {
                        $component->state($record->roles->first()?->name);
                    }
                }),
            Forms\Components\Select::make('employee_trade_id')
                ->label('Skill Trade')
                ->options(Trade::query()->pluck('name', 'id'))
                ->visible(fn (Forms\Get $get) => $get('role') === RoleName::Employee->value)
                ->disabled(fn (?User $record) => filled($record?->employeeProfile))
                ->dehydrated(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('roles.name')->badge(),
                Tables\Columns\TextColumn::make('employeeProfile.trade.name')->label('Trade'),
            ])
            ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()?->hasRole(RoleName::RootAdmin->value)) {
            return $query;
        }

        return $query->where('id', auth()->id());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
