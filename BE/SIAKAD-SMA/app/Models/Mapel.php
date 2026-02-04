<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $fillable = ['nama_mapel'];

    /**
     * Relasi Many-to-Many dengan Guru melalui tabel guru_mapel
     */
    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'guru_mapel');
    }

    public function absens()
    {
        return $this->hasMany(Absen::class);
    }

    public function jadwalPelajarans()
    {
        return $this->hasMany(JadwalPelajaran::class);
    }
}
