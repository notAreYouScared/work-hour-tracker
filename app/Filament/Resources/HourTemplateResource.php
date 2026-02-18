<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HourTemplateResource\Pages;
use App\Models\HourTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HourTemplateResource extends Resource
{
    protected static ?string $model = HourTemplate::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('trade_id')->relationship('trade', 'name')->required(),
            Forms\Components\TextInput::make('section_number')->numeric()->required(),
            Forms\Components\TextInput::make('section_title')->required(),
            Forms\Components\TextInput::make('row_label')->required(),
            Forms\Components\TextInput::make('area_affected'),
            Forms\Components\TextInput::make('required_program_hours')->numeric()->required(),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(1),
            Forms\Components\Toggle::make('is_active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('trade_id')
            ->columns([
                Tables\Columns\TextColumn::make('trade.name')->sortable(),
                Tables\Columns\TextColumn::make('section_number')->sortable(),
                Tables\Columns\TextColumn::make('section_title')->wrap(),
                Tables\Columns\TextColumn::make('row_label')->wrap(),
                Tables\Columns\TextColumn::make('required_program_hours'),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHourTemplates::route('/'),
            'create' => Pages\CreateHourTemplate::route('/create'),
            'edit' => Pages\EditHourTemplate::route('/{record}/edit'),
        ];
    }
}
