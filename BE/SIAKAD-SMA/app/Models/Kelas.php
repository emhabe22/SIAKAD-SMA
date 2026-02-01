<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [];

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }

    public function mapels()
    {
        return $this->hasMany(Mapel::class);
    }
}
