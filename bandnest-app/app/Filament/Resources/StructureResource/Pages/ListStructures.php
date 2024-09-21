<?php

namespace App\Filament\Resources\StructureResource\Pages;

use App\Filament\Resources\StructureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStructures extends ListRecords
{
    protected static string $resource = StructureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
