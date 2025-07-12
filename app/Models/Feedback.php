<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    
    protected $fillable = [
        'sesi_id',
        'mahasiswa_id',
        'rating',
        'komentar'
    ];

    public function session()
    {
        return $this->belongsTo(KonselingSession::class, 'sesi_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}