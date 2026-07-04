<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamen';

    protected $fillable = [
        'anggota_id', 'tanggal_pinjam', 'tanggal_jatuh_tempo',
        'tanggal_kembali', 'status', 'admin_id'
    ];

    // Relasi ke Anggota (Many-to-One)
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    // Relasi ke User/Admin (Many-to-One)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Relasi ke DetailPeminjaman (One-to-Many)
    public function detailPeminjamans()
    {
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id');
    }

    // Relasi ke Denda (One-to-One)
    public function denda()
    {
        return $this->hasOne(Denda::class, 'peminjaman_id');
    }
}