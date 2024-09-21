<?php

namespace App\Filament\Resources\StructureResource\Pages;

use App\Filament\Resources\StructureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStructure extends EditRecord
{
    protected static string $resource = StructureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
