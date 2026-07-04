<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Anggota;
use App\Models\User;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        $siswa = User::where('username', 'siswa1')->first();
        $guru = User::where('username', 'guru1')->first();
        $kepsek = User::where('username', 'kepsek1')->first();

        if ($siswa) {
            Anggota::create([
                'nomor_anggota' => 'AGT-001',
                'jenis_anggota' => 'siswa',
                'kelas' => 'XII IPA 1',
                'alamat' => 'Jl. Merdeka No. 1',
                'telepon' => '081234567890',
                'tanggal_daftar' => '2024-01-15',
                'status' => 'aktif',
                'user_id' => $siswa->id,
            ]);
        }

        if ($guru) {
            Anggota::create([
                'nomor_anggota' => 'AGT-002',
                'jenis_anggota' => 'guru',
                'kelas' => null,
                'alamat' => 'Jl. Pahlawan No. 5',
                'telepon' => '087765432101',
                'tanggal_daftar' => '2024-01-15',
                'status' => 'aktif',
                'user_id' => $guru->id,
            ]);
        }

        if ($kepsek) {
            Anggota::create([
                'nomor_anggota' => 'AGT-003',
                'jenis_anggota' => 'guru',
                'kelas' => null,
                'alamat' => 'Jl. Sudirman No. 10',
                'telepon' => '089912345678',
                'tanggal_daftar' => '2024-01-15',
                'status' => 'aktif',
                'user_id' => $kepsek->id,
            ]);
        }
    }
}