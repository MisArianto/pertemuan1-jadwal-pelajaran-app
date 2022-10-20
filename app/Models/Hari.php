<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hari extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jadwals()
    {
        return $this->hasMany(JadwalPelajaran::class, 'hari_id');
    }

}
