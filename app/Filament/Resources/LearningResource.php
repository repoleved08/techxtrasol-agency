<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LearningResource\Pages;
use App\Filament\Resources\LearningResource\RelationManagers;
use App\Models\Learning;
use App\Models\Resource as ModelsResource;
use App\Models\ResourceCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;



class LearningResource extends Resource
{
    protected static ?string $model = ModelsResource::class;

    protected static ?string $navigationIcon = 'heroicon-m-code-bracket';
    protected static ?string $navigationLabel = 'Tech Resources';
    protected static ?string $navigationGroup = 'Technical Content';
    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Tech Resource';
    protected static ?string $pluralModelLabel = 'Tech Resources';

    // Optional slug for URLs
    protected static ?string $slug = 'tech-resources';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Content')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($set, $state) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\RichEditor::make('body')
                            ->required()
                            ->fileAttachmentsDirectory('resources/attachments')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('featured_image')
                            ->directory('resources/featured-images')
                            ->image()
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('excerpt')
                            ->maxLength(500)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->options(ResourceCategory::all()->pluck('name', 'id'))
                            ->required()
                            ->searchable(),

                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->default(\Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->id : null)
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Publishing')
                    ->schema([
                        Forms\Components\DateTimePicker::make('published_at')
                            ->default(now()),

                        Forms\Components\Toggle::make('is_published')
                            ->default(true),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('meta_description')
                            ->maxLength(160),

                        Forms\Components\TagsInput::make('meta_keywords'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Featured Image')
                    ->circular()
                    ->size(50),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->badge()
                    ->color(fn($record) => $record->category->color),

                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),

                Tables\Filters\TernaryFilter::make('is_published'),
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
            'index' => Pages\ListLearnings::route('/'),
            'create' => Pages\CreateLearning::route('/create'),
            'edit' => Pages\EditLearning::route('/{record}/edit'),
        ];
    }
}
