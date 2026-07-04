<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'bukus';

    protected $fillable = [
        'isbn', 'judul', 'penulis', 'penerbit',
        'tahun_terbit', 'jumlah_total', 'jumlah_tersedia',
        'lokasi_rak', 'cover_path', 'kategori_id'
    ];

    // Relasi ke KategoriBuku (Many-to-One)
    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class, 'kategori_id');
    }

    // Relasi ke DetailPeminjaman (One-to-Many)
    public function detailPeminjamans()
    {
        return $this->hasMany(DetailPeminjaman::class, 'buku_id');
    }
}