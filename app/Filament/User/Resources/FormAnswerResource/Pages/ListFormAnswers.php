<?php

namespace App\Filament\User\Resources\FormAnswerResource\Pages;

use App\Filament\User\Resources\FormAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFormAnswers extends ListRecords
{
    protected static string $resource = FormAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
