<?php

namespace App\Filament\User\Resources\FormAnswerResource\Pages;

use App\Filament\User\Resources\FormAnswerResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateFormAnswer extends CreateRecord
{
    protected static string $resource = FormAnswerResource::class;

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Jawaban berhasil disimpan!')
            ->success()
            ->send();
    }
}