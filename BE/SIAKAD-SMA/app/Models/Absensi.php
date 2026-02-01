<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = ['siswa_id', 'absen_id', 'status'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function absen()
    {
        return $this->belongsTo(Absen::class);
    }
}
