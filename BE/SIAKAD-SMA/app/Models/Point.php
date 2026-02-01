<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $fillable = ['nama', 'nilai'];

    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class);
    }
}
