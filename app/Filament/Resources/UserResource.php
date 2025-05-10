<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Users';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 1;
    // make this group the first one in the navigation
    protected static ?string $navigationGroupSort = '1';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->label('Email')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                // bio
                Forms\Components\Textarea::make('bio')
                    ->label('Bio')
                    ->maxLength(65535)
                    ->rows(3),
                Forms\Components\Select::make('role')
                    ->required()
                    ->label('Role')
                    ->options(User::ROLES)

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
                    ->label('Name'),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->label('Email'),
                // role
                Tables\Columns\TextColumn::make('role')
                    ->sortable()
                    ->searchable()
                    ->label('Role')
                    ->formatStateUsing(fn ($state) => $state ? $state : 'No Role Assigned'),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->dateTime()
                    ->label('Created At'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->sortable()
                    ->dateTime()
                    ->label('Updated At'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->sortable()
                    ->dateTime()
                    ->label('Deleted At')
                    ->hidden(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->sortable()
                    ->searchable()
                    ->label('Role')
                    ->formatStateUsing(fn ($state) => $state ? $state : 'No Role Assigned'),
            ])
            ->filters([
                //
                Tables\Filters\Filter::make('deleted')
                    ->query(fn (Builder $query): Builder => $query->onlyTrashed())
                    ->label('Deleted Users'),
                Tables\Filters\Filter::make('active')
                    ->query(fn (Builder $query): Builder => $query->whereNull('deleted_at'))
                    ->label('Active Users'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->action(function (User $record) {
                        $record->delete();
                        return redirect()->to('/admin/users');
                    })
                    ->label('Delete User')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->modalHeading('Delete User')
                    ->modalSubheading('Are you sure you want to delete this user? This action cannot be undone.')
                    ->modalButton('Delete'),

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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
