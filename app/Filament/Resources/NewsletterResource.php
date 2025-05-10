<?php

namespace App\Filament\Resources;

use App\Models\NewsletterSubscriber;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\NewsletterResource\Pages;
use Illuminate\Database\Eloquent\Model;

class NewsletterResource extends Resource
{
    protected static ?string $model = NewsletterSubscriber::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Subscribers';
    protected static ?string $modelLabel = 'Newsletter Subscriber';
    protected static ?string $pluralModelLabel = 'Newsletter Subscribers';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Subscriber Information')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('user_id')
                            ->label('User Account')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),

                        Forms\Components\ToggleButtons::make('is_active')
                            ->label('Subscription Status')
                            ->boolean()
                            ->inline()
                            ->default(true),

                        Forms\Components\DateTimePicker::make('verified_at')
                            ->label('Verification Date'),

                        Forms\Components\KeyValue::make('preferences')
                            ->label('Preferences')
                            ->keyLabel('Preference')
                            ->valueLabel('Value')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Meta Information')
                    ->schema([
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Subscribed On')
                            ->disabled()
                            ->displayFormat('M j, Y g:i A'),

                        Forms\Components\DateTimePicker::make('updated_at')
                            ->label('Last Updated')
                            ->disabled()
                            ->displayFormat('M j, Y g:i A'),
                    ])
                    ->columns(2)
                    ->visibleOn('edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->label('Email Address')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Model $record) => $record->user?->name),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('verified_at')
                    ->label('Verified')
                    ->boolean()
                    ->getStateUsing(fn ($record) => !is_null($record->verified_at))
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Subscribed')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Has User Account')
                    ->options([
                        true => 'With Account',
                        false => 'Without Account',
                    ])
                    ->query(function (Builder $query, $data) {
                        return match ($data['value']) {
                            true => $query->whereNotNull('user_id'),
                            false => $query->whereNull('user_id'),
                            default => $query,
                        };
                    }),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),

                Tables\Filters\TernaryFilter::make('verified_at')
                    ->label('Verification Status')
                    ->placeholder('All')
                    ->trueLabel('Verified')
                    ->falseLabel('Unverified'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('verify')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->action(function (Model $record) {
                            $record->update(['verified_at' => now()]);
                        })
                        ->hidden(fn (Model $record) => !is_null($record->verified_at)),

                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('verify')
                        ->icon('heroicon-o-check-badge')
                        ->action(function ($records) {
                            $records->each->update(['verified_at' => now()]);
                        }),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->persistFiltersInSession();
    }

    public static function getRelations(): array
    {
        return [
            // Add relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNewsletters::route('/'),
            'create' => Pages\CreateNewsletter::route('/create'),
            'edit' => Pages\EditNewsletter::route('/{record}/edit'),
        ];
    }
}
