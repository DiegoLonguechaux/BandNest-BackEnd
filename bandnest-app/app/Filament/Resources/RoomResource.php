<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name'),
                Forms\Components\TextInput::make('size'),
                Forms\Components\TextInput::make('description'),
                Forms\Components\TextInput::make('price_per_hour'),
                Forms\Components\Select::make('structure_id')
                    ->relationship('structure', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Structure'),
                Forms\Components\Select::make('materials')
                    ->multiple()
                    ->relationship('materials', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Materials'),
                Forms\Components\Repeater::make('operating_hours')
                    ->relationship('operatingHours')
                    ->schema([
                        Forms\Components\Select::make('day')
                            ->options([
                                'monday' => 'Monday',
                                'tuesday' => 'Tuesday',
                                'wednesday' => 'Wednesday',
                                'thursday' => 'Thursday',
                                'friday' => 'Friday',
                                'saturday' => 'Saturday',
                                'sunday' => 'Sunday',
                            ])
                            ->required()
                            ->label('Day'),

                        Forms\Components\TimePicker::make('start')
                            ->required()
                            ->withoutSeconds()
                            ->label('Start At'),

                        Forms\Components\TimePicker::make('end')
                            ->required()
                            ->withoutSeconds()
                            ->label('End At'),
                    ])
                    ->columns(3)
                    ->columnSpan('full')
                    ->label('Opening Hours')
                    ->createItemButtonLabel('Add Day')
                    ->collapsed(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\TextColumn::make('size')->sortable(),
                Tables\Columns\TextColumn::make('price_per_hour')->sortable(),
                Tables\Columns\TextColumn::make('address')->sortable(),
                Tables\Columns\TextColumn::make('city')->sortable(),
                Tables\Columns\TextColumn::make('zip_code')->sortable(),
                Tables\Columns\TextColumn::make('country.name')
                    ->label('Country'),
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
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
