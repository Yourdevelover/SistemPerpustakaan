<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    protected $table = 'kategori_bukus';

    protected $fillable = ['nama_kategori', 'deskripsi'];

    // Relasi ke Buku (One-to-Many)
    public function bukus()
    {
        return $this->hasMany(Buku::class, 'kategori_id');
    }
}