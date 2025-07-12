<?php

namespace App\Filament\User\Resources\KonselingSessionResource\Pages;

use App\Filament\User\Resources\KonselingSessionResource;
use App\Models\KonselingSession;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Carbon\Carbon;

class CreateKonselingSession extends CreateRecord
{
    protected static string $resource = KonselingSessionResource::class;

    /**
     * Hook yang dijalankan sebelum menyimpan data
     */
    protected function mutateFormDataBeforeCreate(array $data): array 
    {
        $exists = \App\Models\KonselingSession::where('konselor_id', $data['konselor_id'])
            ->where('tanggal', $data['tanggal'])
            ->where('sesi_id', $data['sesi_id'])
            ->exists();
    
        if ($exists) {
            Notification::make()
                ->title('Jadwal Bentrok')
                ->body('Konselor sudah memiliki sesi di tanggal dan sesi yang sama.')
                ->danger()
                ->persistent()
                ->send();
    
            $this->halt(); // stop proses penyimpanan
        }
    
        return $data;
    }
    
}
