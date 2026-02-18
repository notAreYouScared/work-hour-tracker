<?php

namespace App\Filament\Resources;

use App\Enums\SkillTrade;
use App\Filament\Resources\HourSectionResource\Pages;
use App\Models\HourSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HourSectionResource extends Resource
{
    protected static ?string $model = HourSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('skill_trade')->options(SkillTrade::labels())->required(),
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\TextInput::make('target_hours')->numeric()->required()->default(0),
            Forms\Components\TextInput::make('display_order')->numeric()->required()->default(1),
            Forms\Components\Toggle::make('active')->default(true)->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('skill_trade')->badge(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('target_hours')->numeric(),
                Tables\Columns\TextColumn::make('display_order'),
                Tables\Columns\IconColumn::make('active')->boolean(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHourSections::route('/'),
            'create' => Pages\CreateHourSection::route('/create'),
            'edit' => Pages\EditHourSection::route('/{record}/edit'),
        ];
    }
}
