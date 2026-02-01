<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $fillable = ['tanggal', 'pertemuan', 'mapel_id', 'guru_id'];

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
}
