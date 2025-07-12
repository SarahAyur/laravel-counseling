<?php

namespace App\Filament\User\Resources\KonselingSessionResource\Pages;

use App\Filament\User\Resources\KonselingSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKonselingSession extends EditRecord
{
    protected static string $resource = KonselingSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
