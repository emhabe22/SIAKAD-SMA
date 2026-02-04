<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = ['nama_kelas', 'tingkat', 'jurusan'];

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
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
