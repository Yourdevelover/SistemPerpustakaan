<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjamen';

    protected $fillable = [
        'peminjaman_id', 'buku_id', 
        'kondisi_pinjam', 'kondisi_kembali'
    ];

    // Relasi ke Peminjaman (Many-to-One)
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    // Relasi ke Buku (Many-to-One)
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}