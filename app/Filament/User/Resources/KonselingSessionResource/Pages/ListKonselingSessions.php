<?php

namespace App\Filament\User\Resources\KonselingSessionResource\Pages;

use App\Filament\User\Resources\KonselingSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKonselingSessions extends ListRecords
{
    protected static string $resource = KonselingSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
