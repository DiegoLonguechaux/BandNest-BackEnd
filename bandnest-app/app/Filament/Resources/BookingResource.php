<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('start'),
                Forms\Components\DateTimePicker::make('end'),
                Forms\Components\TextInput::make('total_price')
                    ->disabled(),
                Forms\Components\TextInput::make('state'),
                Forms\Components\Select::make('band_id')
                    ->relationship('band', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Band'),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'firstname', function ($query) {
                        return $query->select(['id', 'firstname', 'lastname']);
                    })
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->firstname . ' ' . $record->lastname)
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('User'),
                Forms\Components\Select::make('room_id')
                    ->relationship('room', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Room'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('start')->sortable(),
                Tables\Columns\TextColumn::make('end')->sortable(),
                Tables\Columns\TextColumn::make('total_price')->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User'),
                Tables\Columns\TextColumn::make('band.name')
                    ->label('Band'),
                Tables\Columns\TextColumn::make('room.name')
                    ->label('Room'),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
