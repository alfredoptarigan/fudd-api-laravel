<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FoodResource\Pages;
use App\Filament\Resources\FoodResource\RelationManagers;
use App\Models\Food;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FoodResource extends Resource
{
    protected static ?string $model = Food::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(
                    'Food Information'
                )->columns(2)->schema([
                    Forms\Components\TextInput::make('title')
                        ->autofocus()
                        ->required(),
                    Forms\Components\TextInput::make('description')
                        ->autofocus()
                        ->required(),
                    Forms\Components\TextInput::make('price')
                        ->autofocus()
                        ->required(),
                    // quantity
                    Forms\Components\TextInput::make('quantity')
                        ->autofocus()
                        ->required(),
                    // is vegan
                    Forms\Components\Checkbox::make('is_vegetarian')
                        ->autofocus()
                        ->default(false),
                    // is available
                    Forms\Components\Checkbox::make('is_available')
                        ->autofocus()
                        ->required(),
                    Forms\Components\Select::make('ingredients')
                          ->relationship('ingredients', 'title')
                            ->multiple()
                            ->searchable()
                            ->placeholder('Select ingredients')
                            ->required(),
                    // Upload form component
                    Forms\Components\FileUpload::make('picture')
                        ->image()
                        ->directory('foods')
                        ->required()
                        ->acceptedFileTypes(['image/*']),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('picture')
                    ->circular()
                    ->size(50)
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_vegetarian')
                    ->searchable()
                    ->icons([
                        'heroicon-o-x-circle' => fn (Food $food) => !$food->is_vegetarian,
                        'heroicon-o-check-circle' => fn (Food $food) => $food->is_vegetarian,
                    ])
                    ->colors([
                        'heroicon-o-x-circle' => fn (Food $food) => 'red',
                        'heroicon-o-check-circle' => fn (Food $food) => 'green',
                    ])
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_available')
                    ->searchable()
                    ->icons([
                        'heroicon-o-x-circle' => fn (Food $food) => !$food->is_available,
                        'heroicon-o-check-circle' => fn (Food $food) => $food->is_available,
                    ])
                    ->colors([
                        'heroicon-o-x-circle' => fn (Food $food) => 'red',
                        'heroicon-o-check-circle' => fn (Food $food) => 'green',
                    ])
                    ->sortable(),
                // create table ingredients that shows the ingredients of the food from table ingredients (many to many)
                Tables\Columns\TextColumn::make('ingredients.title')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\IngredientsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFood::route('/'),
            'create' => Pages\CreateFood::route('/create'),
            'edit' => Pages\EditFood::route('/{record}/edit'),
        ];
    }
}
