<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LearningCategoryResource\Pages;
use App\Filament\Resources\LearningCategoryResource\RelationManagers;
use App\Models\LearningCategory;
use App\Models\ResourceCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;




class LearningCategoryResource extends Resource
{
    protected static ?string $model = ResourceCategory::class;

    protected static ?string $navigationIcon = 'heroicon-m-tag';
    protected static ?string $navigationLabel = 'Tech Categories';
    protected static ?string $navigationGroup = 'Technical Content';
    protected static ?int $navigationSort = 1;
    protected static ?string $slug = 'learning-categories';
    protected static ?string $modelLabel = 'Tech Category';
    protected static ?string $pluralModelLabel = 'Tech Categories';

    // Optional: Change breadcrumb
    protected static ?string $breadcrumb = 'Tech Categories';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($set, $state) => $set('slug', Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('icon')
                    ->default('heroicon-o-code')
                    ->maxLength(50),

                Forms\Components\Select::make('color')
                    ->default('gray')
                    ->options([
                        'gray' => 'Gray',
                        'blue' => 'Blue',
                        'green' => 'Green',
                        'red' => 'Red',
                        'yellow' => 'Yellow',
                        'purple' => 'Purple',
                    ]),

                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('resources_count')
                    ->counts('resources')
                    ->label('Resources'),

                Tables\Columns\ColorColumn::make('color')
                    ->searchable(),

                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        if ($record->resources()->count() > 0) {
                            throw new \Exception('Cannot delete category with resources');
                        }
                    }),
            ])
            ->defaultSort('order', 'asc')
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
            'index' => Pages\ListLearningCategories::route('/'),
            'create' => Pages\CreateLearningCategory::route('/create'),
            'edit' => Pages\EditLearningCategory::route('/{record}/edit'),
        ];
    }
}
