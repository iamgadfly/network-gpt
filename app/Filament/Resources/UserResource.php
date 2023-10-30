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
use Filament\Tables\Filters\Filter;

class UserResource extends Resource
{

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('surname'),
                Forms\Components\TextInput::make('phone_number'),
                Forms\Components\TextInput::make('balance'),
                Forms\Components\Select::make('role')
                    ->options([
                        'admin'      => 'Admin',
                        'customer'   => 'Customer',
                        'copywriter' => 'Copywriter',
                    ]),
                Forms\Components\TextInput::make('email')->email()->required(),
                Forms\Components\Checkbox::make('is_paid'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('surname'),
                Tables\Columns\TextColumn::make('phone_number'),
                Tables\Columns\TextColumn::make('balance'),
                Tables\Columns\TextColumn::make('role'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\CheckboxColumn::make('is_paid'),
            ])
            ->filters([
                Filter::make('is_paid')
                    ->query(
                        fn(Builder $query): Builder => $query->where(
                            'is_paid',
                            true
                        )
                    ),
            ])
            ->groups([
                Tables\Grouping\Group::make('id')
                    ->groupQueryUsing(
                        fn(Builder $query) => $query->orderByDesc('id')
                    ),
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
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }

}
