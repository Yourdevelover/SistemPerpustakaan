<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $table = 'dendas';

    protected $fillable = [
        'peminjaman_id', 'jumlah_denda', 
        'status_bayar', 'tanggal_bayar'
    ];

    // Relasi ke Peminjaman (Many-to-One)
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }
}