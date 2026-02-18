<?php

namespace App\Filament\Resources;

use App\Enums\Role;
use App\Enums\SkillTrade;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
            Forms\Components\Select::make('role')
                ->options(Role::labels())
                ->required()
                ->dehydrated(false)
                ->afterStateHydrated(function ($component, $record) {
                    if ($record) {
                        $component->state($record->roles->first()?->name);
                    }
                }),
            Forms\Components\Select::make('skill_trade')
                ->options(SkillTrade::labels())
                ->visible(fn (Forms\Get $get) => $get('role') === Role::Employee->value)
                ->required(fn (Forms\Get $get) => $get('role') === Role::Employee->value)
                ->disabled(fn (?User $record) => filled($record?->skill_trade))
                ->helperText('Skill trade is permanently locked after creation.'),
            Forms\Components\Toggle::make('active')->default(true)->required(),
            Forms\Components\TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                ->required(fn (string $context) => $context === 'create')
                ->dehydrated(fn (?string $state) => filled($state)),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('roles.name')->label('Role')->badge(),
                Tables\Columns\TextColumn::make('skill_trade')->label('Skill Trade'),
                Tables\Columns\IconColumn::make('active')->boolean(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
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
