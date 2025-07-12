<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonselingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'konselor_id',
        'tanggal',
        'sesi_id',
        'status',
        'topik',
        'catatan_konselor',
        'chat_enabled',
    ];

    /**
     * Relasi ke model User untuk mahasiswa.
     */
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    /**
     * Relasi ke model User untuk konselor.
     */
    public function konselor()
    {
        return $this->belongsTo(User::class, 'konselor_id');
    }

        public function session()
    {
        return $this->belongsTo(Session::class, 'sesi_id');
    }

        public function sesi()
    {
        return $this->belongsTo(Session::class, 'sesi_id');
    }
    
    // Change references from session() to sesi()

    protected static function boot () {
        parent::boot();

        static::creating(function ($konselingSession) {
            if (auth()->check()) {
                $konselingSession->mahasiswa_id = auth()->id(); // Isi mahasiswa_id dengan ID pengguna yang login
            }
            $konselingSession->status = 'pending';

    });    
    }

    public function rescheduleHistory()
    {
        return $this->hasMany(RescheduleHistory::class, 'konseling_id');
    }
}