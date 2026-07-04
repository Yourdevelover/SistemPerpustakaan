<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $fillable = [
        'nomor_anggota', 'jenis_anggota', 'kelas',
        'alamat', 'telepon', 'tanggal_daftar', 
        'status', 'user_id'
    ];

    // Relasi ke User (Many-to-One)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Peminjaman (One-to-Many)
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}