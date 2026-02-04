<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = ['nama', 'nisn', 'alamat', 'no_telp', 'user_id', 'kelas_id', 'nama_wali'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    public function penjadwalans()
    {
        return $this->hasMany(Penjadwalan::class);
    }

    public function pelanggaranSiswas()
    {
        return $this->hasMany(PelanggaranSiswa::class);
    }
}
