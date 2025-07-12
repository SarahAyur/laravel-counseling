<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $table = 'sesi';

    protected $fillable = ['name', 'start_time', 'end_time'];

    public function konselingSessions()
    {
        return $this->hasMany(KonselingSession::class);
    }
}
