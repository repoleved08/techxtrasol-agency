<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class BookResource extends Resource
{
  protected static ?string $model = Book::class;

  protected static ?string $navigationIcon = 'heroicon-o-book-open';
  protected static ?string $navigationLabel = 'Books';
  protected static ?string $navigationGroup = 'Technical Content';
  protected static ?int $navigationSort = 3;
  protected static ?string $slug = 'books';
  protected static ?string $modelLabel = 'Book';
  protected static ?string $pluralModelLabel = 'Books';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('title')
          ->required()
           ->live(debounce: 1000)
          ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state)))
          ->maxLength(255),
        Forms\Components\TextInput::make('slug')
          ->required()
          ->maxLength(255)
          ->unique(ignoreRecord: true)
          ->disabled() // Make it read-only
          ->dehydrated(),
        Forms\Components\TextInput::make('author')
          ->required()
          ->maxLength(255),
        Forms\Components\TextInput::make('isbn')
          ->maxLength(255),
        Forms\Components\FileUpload::make('cover_image')
          ->image()
          ->directory('books/covers'),
        Forms\Components\FileUpload::make('file_path')
          ->required()
          ->acceptedFileTypes(['application/pdf', 'application/epub+zip'])
          ->directory('books/files'),
        Forms\Components\DatePicker::make('published_date'),
        Forms\Components\Toggle::make('featured'),
        Forms\Components\Textarea::make('description')
          ->required()
          ->columnSpanFull(),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\ImageColumn::make('cover_image'),
        Tables\Columns\TextColumn::make('title')
          ->searchable(),
        Tables\Columns\TextColumn::make('author')
          ->searchable(),
        Tables\Columns\IconColumn::make('featured')
          ->boolean(),
        Tables\Columns\TextColumn::make('download_count'),
        Tables\Columns\TextColumn::make('published_date')
          ->date()
          ->sortable(),
      ])
      ->filters([
        Tables\Filters\Filter::make('featured')
          ->query(fn(Builder $query): Builder => $query->where('featured', true)),
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
      'index' => Pages\ListBooks::route('/'),
      'create' => Pages\CreateBook::route('/create'),
      'edit' => Pages\EditBook::route('/{record}/edit'),
    ];
  }
}
