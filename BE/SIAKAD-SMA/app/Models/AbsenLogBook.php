<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenLogBook extends Model
{
    public $timestamps = false; // Hanya punya created_at, immutable

    protected $fillable = [
        'absen_id', 'user_id', 'aksi',
        'deskripsi', 'data_sebelum', 'data_sesudah', 'ip_address'
    ];

    protected $casts = [
        'data_sebelum' => 'array',
        'data_sesudah' => 'array',
        'created_at'   => 'datetime',
    ];

    public function absen()
    {
        return $this->belongsTo(Absen::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
