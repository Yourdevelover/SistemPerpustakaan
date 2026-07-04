<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username', 'password', 'email', 
        'nama_lengkap', 'role_id', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Relasi ke Role (Many-to-One)
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relasi ke Anggota (One-to-One)
    public function anggota()
    {
        return $this->hasOne(Anggota::class);
    }

    // Relasi ke Notifikasi (One-to-Many)
    public function notifikasis()
    {
        return $this->hasMany(Notifikasi::class);
    }

    // Relasi ke Laporan (One-to-Many)
    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'generated_by');
    }

    // Helper: cek role
    public function hasRole($role)
    {
        return $this->role->nama_role === $role;
    }
}