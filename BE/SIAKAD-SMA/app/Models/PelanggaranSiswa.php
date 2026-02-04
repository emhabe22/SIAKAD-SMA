<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelanggaranSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'point_id',
        'bk_id',
        'tanggal',
        'keterangan',
    ];

    /**
     * Relasi ke Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Relasi ke Point
     */
    public function point()
    {
        return $this->belongsTo(Point::class);
    }

    /**
     * Relasi ke BK
     */
    public function bk()
    {
        return $this->belongsTo(BK::class);
    }
}
