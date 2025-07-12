<?php

namespace App\Filament\Resources\AdminKonselingSessionResource\Pages;

use App\Filament\Resources\AdminKonselingSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdminKonselingSessions extends ListRecords
{
    protected static string $resource = AdminKonselingSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
