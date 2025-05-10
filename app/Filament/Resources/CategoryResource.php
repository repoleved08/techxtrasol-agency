<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationIcon = 'heroicon-s-tag';
    protected static ?string $navigationLabel = 'Categories';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 1;

    protected static ?string $label = 'Category';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                // I wantslug to be automatically generated from name after some seconds
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Category Name')
                    ->reactive()
                    ->debounce(1000)
                    ->afterStateUpdated(function (callable $set, $state) {
                        $set('slug', str($state)->slug());
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->label('Category Slug')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable()
                    ->label('ID'),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Category Name'),
                Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->searchable()
                    ->label('Category Slug'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Created At'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Updated At'),
            ])
            ->filters([

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
