<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'sesi_id',
        'mahasiswa_id',
        'question_id',
        'jawaban',
    ];

    public function session()
    {
        return $this->belongsTo(KonselingSession::class, 'sesi_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function question()
    {
        return $this->belongsTo(FormQuestion::class, 'question_id');
    }
}