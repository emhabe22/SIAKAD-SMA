<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPemanggilan extends Model
{
    protected $fillable = [
        'siswa_id',
        'bk_id',
        'nomor_surat',
        'perihal',
        'keterangan',
        'tanggal_surat',
        'tanggal_panggilan',
        'waktu_panggilan',
        'status',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function bk()
    {
        return $this->belongsTo(BK::class, 'bk_id');
    }
}
