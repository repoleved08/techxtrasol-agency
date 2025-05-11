<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\Resource;
use Filament\Forms\Components\RichEditor;
use App\Models\NewsletterSubscriber;
use App\Notifications\NewBlogPostNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-m-document-minus';
    protected static ?string $navigationLabel = 'Posts';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Post Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->label('Title')
                                    ->required()
                                    ->live(debounce: 1000)
                                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state)))
                                    ->maxLength(255),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                            ]),

                        RichEditor::make('excerpt')
                            ->label('Excerpt')
                            ->maxLength(500),

                        RichEditor::make('body')
                            ->label('Body')
                            ->required(),

                        Grid::make(2)
                            ->schema([
                                Select::make('category_id')
                                    ->label('Category')
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->searchable(),

                                FileUpload::make('featured_image')
                                    ->label('Featured Image')
                                    ->image()
                                    ->directory('posts')
                                    ->preserveFilenames(),
                            ]),

                        Grid::make(2)
                            ->schema([
                                DateTimePicker::make('published_at')
                                    ->label('Publish Date'),

                                    Toggle::make('is_published')
                                    ->label('Published')
                                    ->default(false)
                                    ->afterStateUpdated(function ($state, $record) {
                                        if ($state && $record) {
                                            // Remove the wasRecentlyCreated check to allow notifications
                                            // when publishing existing drafts
                                            self::notifySubscribers($record);
                                        }
                                    }),
                            ]),
                    ])
                    ->columns(1),
                Section::make('Author Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->label('Author')
                                    ->relationship('user', 'name')
                                    ->required(),
                            ]),
                    ]),

                Section::make('SEO Metadata')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('Meta Title')
                                    ->maxLength(255),

                                TextInput::make('meta_keywords')
                                    ->label('Meta Keywords')
                                    ->maxLength(255),
                            ]),

                        TextInput::make('meta_description')
                            ->label('Meta Description')
                            ->maxLength(255),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    protected static function notifySubscribers(Post $post)
    {
        // Add verification check
        $subscribers = NewsletterSubscriber::where('is_active', true)
            ->whereNotNull('verified_at')
            ->get();

        if ($subscribers->isEmpty()) {
            Log::info('No active, verified subscribers found');
            return;
        }

        $recentPosts = Post::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        try {
            Notification::send($subscribers, new NewBlogPostNotification($post, $recentPosts));
            Log::info('Notifications sent successfully for post: ' . $post->id);
        } catch (\Exception $e) {
            Log::error('Failed to send notifications: ' . $e->getMessage());
        }
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\ImageColumn::make('featured_image')
                ->label('Image')
                ->size(60)
                ->disk('public') // Explicitly set the disk
                ->visibility('public'), // Set visibility if needed

            Tables\Columns\TextColumn::make('title')
                ->label('Title')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('user.name')
                ->label('Author')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('category.name')
                ->label('Category')
                ->sortable()
                ->searchable(),

            Tables\Columns\IconColumn::make('is_published')
                ->label('Published')
                ->boolean(),

            Tables\Columns\TextColumn::make('published_at')
                ->label('Published At')
                ->dateTime()
                ->sortable(),
                // delete an image

        ])
        ->filters([
            // Your filters here
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            // delete an image
            Tables\Actions\Action::make('delete_image')
                ->label('Delete Image')
                ->action(function (Post $record) {
                    Storage::disk('public')->delete($record->featured_image);
                    $record->update(['featured_image' => null]);

                    \Filament\Notifications\Notification::make()
                        ->title('Image deleted successfully')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->visible(fn(Post $record): bool => !is_null($record->featured_image)),
            Tables\Actions\Action::make('notify')
                ->icon('heroicon-o-bell-alert')
                ->action(function (Post $record) {
                    $recentPosts = Post::where('is_published', true)
                        ->where('id', '!=', $record->id)
                        ->orderBy('published_at', 'desc')
                        ->limit(3)
                        ->get();

                    $subscribers = NewsletterSubscriber::where('is_active', true)->get();

                    Notification::send($subscribers, new NewBlogPostNotification($record, $recentPosts));

                    \Filament\Notifications\Notification::make()
                        ->title('Notification sent to subscribers')
                        ->success()
                        ->send();
                })
                ->visible(fn(Post $record): bool => $record->is_published)
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
