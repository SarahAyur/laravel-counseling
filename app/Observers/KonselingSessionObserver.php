<?php

namespace App\Observers;

use App\Models\KonselingSession;
use Carbon\Carbon;

class KonselingSessionObserver
{
    public function retrieved(KonselingSession $konselingSession)
    {
        $now = Carbon::now();
        $today = $now->format('Y-m-d');
        
        // Untuk session pending/reschedule yang sudah lewat
        if (in_array($konselingSession->status, ['pending', 'reschedule'])) {
            if ($konselingSession->tanggal < $today || 
                ($konselingSession->tanggal == $today && 
                 $konselingSession->sesi->start_time < $now->format('H:i:s'))) {
                $konselingSession->update(['status' => 'canceled']);
            }
        }
        
        // Untuk session approved yang sudah selesai
        if ($konselingSession->status === 'approved') {
            if ($konselingSession->tanggal < $today || 
                ($konselingSession->tanggal == $today && 
                 $konselingSession->sesi->end_time < $now->format('H:i:s'))) {
                $konselingSession->update(['status' => 'finished']);
            }
        }
    }
}