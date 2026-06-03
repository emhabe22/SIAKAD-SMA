<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'nama',
        'nisn',
        'tingkat',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'email',
        'alamat',
        'no_telp',
        'user_id',
        'tahun_masuk',
        'nama_wali',
        'nama_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'telp_ortu',
        'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
