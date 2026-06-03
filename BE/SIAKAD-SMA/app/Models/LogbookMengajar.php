<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogbookMengajar extends Model
{
    protected $table = 'logbook_mengajars';

    protected $fillable = [
        'absen_id',
        'guru_id',
        'materi_pembelajaran',
        'metode_pembelajaran',
        'tugas_evaluasi',
        'status',
        'diserahkan_at',
    ];

    protected $casts = [
        'diserahkan_at' => 'datetime',
    ];

    public function absen()
    {
        return $this->belongsTo(Absen::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Cek apakah logbook sudah lengkap (semua field terisi)
     */
    public function isLengkap(): bool
    {
        return !empty($this->materi_pembelajaran)
            && !empty($this->metode_pembelajaran)
            && !empty($this->tugas_evaluasi);
    }

    /**
     * Cek apakah logbook sudah diserahkan (final)
     */
    public function isDiserahkan(): bool
    {
        return $this->status === 'diserahkan';
    }
}
