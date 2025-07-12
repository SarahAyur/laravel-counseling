<?php

namespace App\Filament\Resources\FormQuestionResource\Pages;

use App\Filament\Resources\FormQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFormQuestion extends EditRecord
{
    protected static string $resource = FormQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
