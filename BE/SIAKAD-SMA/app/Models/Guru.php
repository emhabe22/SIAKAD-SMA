<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = ['nama', 'nip', 'alamat', 'no_telp', 'jenis_kelamin', 'jabatan', 'user_id'];

    protected $casts = [
        'jabatan' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi Many-to-Many dengan Mapel melalui tabel guru_mapel
     */
    public function mapels()
    {
        return $this->belongsToMany(Mapel::class, 'guru_mapel');
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
