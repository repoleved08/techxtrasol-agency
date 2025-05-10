<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CaseStudyResource\Pages;
use App\Filament\Resources\CaseStudyResource\RelationManagers;
use App\Models\CaseStudy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CaseStudyResource extends Resource
{
    protected static ?string $model = CaseStudy::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Case Studies';
    protected static ?string $navigationGroup = 'Portfolio Management';
    // navigation group icon
    protected static ?string $navigationGroupIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('industry')
                ->label('Industry')
                ->required(),

                TextInput::make('title')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(function ($set, $state) {
                    $set('slug', Str::slug($state));
                }),

            Textarea::make('description')
                ->label('Description')
                ->rows(5)
                ->required(),

            // Repeater for highlights
            Repeater::make('highlights')
                ->label('Highlights')
                ->schema([
                    TextInput::make('value')
                        ->label('Value')
                        ->required(),
                    TextInput::make('label')
                        ->label('Label')
                        ->required(),
                ])
                ->columns(2)
                ->createItemButtonLabel('Add Highlight'),

            // Repeater for key results
            Repeater::make('key_results')
                ->label('Key Results')
                ->schema([
                    TextInput::make('result')
                        ->label('Result')
                        ->required(),
                ])
                ->createItemButtonLabel('Add Key Result'),

            // Repeater for technologies
            Repeater::make('technologies')
                ->label('Technologies')
                ->schema([
                    TextInput::make('technology')
                        ->label('Technology')
                        ->required(),
                ])
                ->createItemButtonLabel('Add Technology'),

            TextInput::make('testimonial_name')
                ->label('Testimonial Name'),

            TextInput::make('testimonial_title')
                ->label('Testimonial Title'),

            Textarea::make('testimonial_quote')
                ->label('Testimonial Quote')
                ->rows(3),

                TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true)
                ->disabled(fn ($get) => !empty($get('title')))
                ->dehydrated()
                ->rules(['alpha_dash']),
                // New fields section
            Forms\Components\Section::make('Display Settings')
            ->schema([
                Forms\Components\Select::make('project_type')
                    ->options([
                        'web' => 'Web Application',
                        'mobile' => 'Mobile App',
                        'ai' => 'AI Solution',
                        'ecommerce' => 'E-commerce',
                        'finance' => 'Financial'
                    ])
                    ->required(),

                Forms\Components\Textarea::make('short_description')
                    ->maxLength(160)
                    ->required(),
                    // approach
                Forms\Components\Repeater::make('approach')
                    ->label('Approach')
                    ->schema([
                        Forms\Components\TextInput::make('step')
                            ->label('Step')
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->required(),
                    ])
                    ->columns(2)
                    ->createItemButtonLabel('Add Approach'),

                Forms\Components\TextInput::make('client_name'),

                Forms\Components\DatePicker::make('project_date'),

                Forms\Components\Repeater::make('key_metrics')
                    ->schema([
                        Forms\Components\TextInput::make('value')
                            ->placeholder('75% Faster Reporting')
                            ->required(),
                        Forms\Components\TextInput::make('label')
                            ->placeholder('Performance Improvement')
                            ->required()
                    ])
                    ->columns(2),

                Forms\Components\FileUpload::make('featured_image')
                    ->directory('case-studies/featured')
                    ->image()
                    ->imageEditor(),

                Forms\Components\FileUpload::make('gallery_images')
                    ->directory('case-studies/gallery')
                    ->image()
                    ->multiple()
                    ->maxFiles(10)
            ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Title'),
                TextColumn::make('industry')->label('Industry'),
                TextColumn::make('slug')->label('Slug'),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCaseStudies::route('/'),
            'create' => Pages\CreateCaseStudy::route('/create'),
            'edit' => Pages\EditCaseStudy::route('/{record}/edit'),
        ];
    }
}
