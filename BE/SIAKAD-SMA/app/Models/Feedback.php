<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $fillable = ['penjadwalan_id', 'bk_id', 'siswa_id', 'judul', 'isi'];

    public function penjadwalan()
    {
        return $this->belongsTo(Penjadwalan::class);
    }

    public function bk()
    {
        return $this->belongsTo(BK::class, 'bk_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
