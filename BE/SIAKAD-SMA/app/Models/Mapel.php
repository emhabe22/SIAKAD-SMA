<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $fillable = ['nama_mapel', 'kelas_id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function gurus()
    {
        return $this->hasMany(Guru::class);
    }

    public function absens()
    {
        return $this->hasMany(Absen::class);
    }
}
