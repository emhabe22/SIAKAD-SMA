<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = ['nama', 'nip', 'alamat', 'no_telp', 'user_id', 'mapel_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function absens()
    {
        return $this->hasMany(Absen::class);
    }
}
