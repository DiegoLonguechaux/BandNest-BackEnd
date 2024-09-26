<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BandResource\Pages;
use App\Filament\Resources\BandResource\RelationManagers;
use App\Models\Band;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BandResource extends Resource
{
    protected static ?string $model = Band::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name'),
                Forms\Components\RichEditor::make('description'),
                Forms\Components\FileUpload::make('logo'),
                Forms\Components\Select::make('genres')
                    ->multiple()
                    ->relationship('genres', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Genres'),
                Forms\Components\Select::make('users')
                    ->multiple()
                    ->relationship('users', 'firstname', function ($query) {
                        return $query->select(['users.id', 'firstname', 'lastname']);
                    })
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->firstname . ' ' . $record->lastname)                    
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Members')
                    ->saveRelationshipsUsing(function ($component, $state, $record) {
                        $record->users()->sync($state); // Synchroniser les utilisateurs sélectionnés
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\TagsColumn::make('genres.name') // Display genre names as tags
                    ->label('Genres'),
                Tables\Columns\TagsColumn::make('users.firstname')
                    ->label('Members'),
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
            'index' => Pages\ListBands::route('/'),
            'create' => Pages\CreateBand::route('/create'),
            'edit' => Pages\EditBand::route('/{record}/edit'),
        ];
    }
}
