<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $fillable = [
        'tanggal', 'jam_mulai', 'jam_selesai', 'tingkat',
        'pertemuan', 'materi', 'catatan_guru', 'dibuka_pada',
        'mapel_id', 'guru_id'
    ];

    protected $casts = [
        'dibuka_pada' => 'datetime',
    ];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    public function logBooks()
    {
        return $this->hasMany(AbsenLogBook::class)->orderBy('created_at', 'desc');
    }

    public function logbookMengajar()
    {
        return $this->hasOne(LogbookMengajar::class);
    }
}
