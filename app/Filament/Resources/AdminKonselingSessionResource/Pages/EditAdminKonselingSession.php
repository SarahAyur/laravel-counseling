<?php

namespace App\Filament\Resources\AdminKonselingSessionResource\Pages;

use App\Filament\Resources\AdminKonselingSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdminKonselingSession extends EditRecord
{
    protected static string $resource = AdminKonselingSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
