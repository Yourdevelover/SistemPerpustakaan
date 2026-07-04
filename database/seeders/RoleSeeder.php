<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            ['nama_role' => 'admin', 'deskripsi' => 'Administrator / Pustakawan'],
            ['nama_role' => 'siswa', 'deskripsi' => 'Siswa'],
            ['nama_role' => 'guru', 'deskripsi' => 'Guru'],
            ['nama_role' => 'kepala_sekolah', 'deskripsi' => 'Kepala Sekolah'],
        ]);
    }
}