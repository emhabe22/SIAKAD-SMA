<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalSlot extends Model
{
    protected $fillable = [
        'jam_ke',
        'jam_mulai',
        'jam_selesai',
        'label',
        'tipe',
        'hari',
    ];

    public function jadwalPelajarans()
    {
        return $this->hasMany(JadwalPelajaran::class, 'slot_id');
    }
}
