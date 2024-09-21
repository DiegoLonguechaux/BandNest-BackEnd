<?php

namespace App\Filament\Resources\BandResource\Pages;

use App\Filament\Resources\BandResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBand extends EditRecord
{
    protected static string $resource = BandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
