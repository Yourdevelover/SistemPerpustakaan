<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username'     => 'admin',
            'email'        => 'admin@perpustakaan.com',
            'nama_lengkap' => 'Administrator',
            'password'     => Hash::make('password123'),
            'role_id'      => 1,
            'status'       => 'aktif',
        ]);

        User::create([
            'username'     => 'siswa1',
            'email'        => 'siswa1@perpustakaan.com',
            'nama_lengkap' => 'Budi Santoso',
            'password'     => Hash::make('password123'),
            'role_id'      => 2,
            'status'       => 'aktif',
        ]);

        User::create([
            'username'     => 'guru1',
            'email'        => 'guru1@perpustakaan.com',
            'nama_lengkap' => 'Ibu Siti Rahmawati',
            'password'     => Hash::make('password123'),
            'role_id'      => 3,
            'status'       => 'aktif',
        ]);

        User::create([
            'username'     => 'kepsek1',
            'email'        => 'kepsek1@perpustakaan.com',
            'nama_lengkap' => 'Drs. H. Ahmad Fauzi',
            'password'     => Hash::make('password123'),
            'role_id'      => 4,
            'status'       => 'aktif',
        ]);
    }
}