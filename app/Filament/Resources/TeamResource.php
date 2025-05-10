<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages;
use App\Filament\Resources\TeamResource\RelationManagers;
use App\Models\Team;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Team Members';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('position')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('department')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->directory('team')
                    ->image()
                    ->required(),
                Forms\Components\Textarea::make('bio')
                    ->nullable(),
                Forms\Components\Repeater::make('skills')
                    ->schema([
                        Forms\Components\TextInput::make('skill')->required(),
                    ])
                    ->columns(2)
                    ->createItemButtonLabel('Add Skill'),
                Forms\Components\Repeater::make('socials')
                    ->schema([
                        Forms\Components\TextInput::make('platform')->required(),
                        Forms\Components\TextInput::make('link')->url()->required(),
                    ])
                    ->columns(2)
                    ->createItemButtonLabel('Add Social Link'),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('position')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('department')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Profile Image')
                    ->circular()
                    ->size(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Created At'),
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
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
