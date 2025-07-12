<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RescheduleHistory extends Model
{
    protected $table = 'reschedule_history';
    
    protected $fillable = [
        'konseling_id',
        'old_tanggal',
        'old_sesi_id',
        'new_tanggal',
        'new_sesi_id',
        'status'
    ];

    public function konseling()
    {
        return $this->belongsTo(KonselingSession::class, 'konseling_id');
    }

    public function oldSesi()
    {
        return $this->belongsTo(Session::class, 'old_sesi_id');
    }

    public function newSesi()
    {
        return $this->belongsTo(Session::class, 'new_sesi_id');
    }
}