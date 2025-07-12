<?php

namespace App\Filament\Resources\FormQuestionResource\Pages;

use App\Filament\Resources\FormQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFormQuestions extends ListRecords
{
    protected static string $resource = FormQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
