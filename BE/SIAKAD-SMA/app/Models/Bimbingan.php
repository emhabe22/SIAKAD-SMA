<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    protected $fillable = ['catatan', 'ringkasan', 'penjadwalan_id', 'point_id'];

    public function penjadwalan()
    {
        return $this->belongsTo(Penjadwalan::class);
    }

    public function point()
    {
        return $this->belongsTo(Point::class);
    }
}
