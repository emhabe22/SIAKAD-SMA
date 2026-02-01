<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjadwalan extends Model
{
    protected $fillable = ['tanggal', 'waktu', 'siswa_id', 'bk_id', 'status'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function bk()
    {
        return $this->belongsTo(BK::class, 'bk_id');
    }

    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class);
    }
}
