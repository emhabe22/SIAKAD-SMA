<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'slot_id',
        'tipe',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'tingkat',
        'mapel_id',
        'guru_id',
        'keterangan',
    ];

    /**
     * Relasi ke Jadwal Slot
     */
    public function slot()
    {
        return $this->belongsTo(JadwalSlot::class, 'slot_id');
    }

    /**
     * Relasi ke Mapel
     */
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    /**
     * Relasi ke Guru
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
