<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BK extends Model
{
    protected $table = 'b_k_s';
    protected $fillable = ['nama', 'nip', 'alamat', 'no_telp', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penjadwalans()
    {
        return $this->hasMany(Penjadwalan::class, 'bk_id');
    }

    public function pelanggaranSiswas()
    {
        return $this->hasMany(PelanggaranSiswa::class);
    }
}
