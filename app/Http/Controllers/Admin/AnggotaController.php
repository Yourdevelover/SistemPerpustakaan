<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $anggota = Anggota::with('user')
            ->when(
                $request->search,
                fn($q) =>
                $q->whereHas(
                    'user',
                    fn($u) =>
                    $u->where('nama_lengkap', 'like', "%{$request->search}%")
                )->orWhere('nomor_anggota', 'like', "%{$request->search}%")
            )
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()->paginate(10)->withQueryString();

        return view('admin.anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('admin.anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'username'      => 'required|string|unique:users,username',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:8',
            'jenis_anggota' => 'required|string',
            'kelas'         => 'nullable|string|max:50',
            'telepon'       => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
        ]);

        $roleId = Role::where('nama_role', 'siswa')->value('id');

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role_id'      => $roleId,
            'status'       => 'aktif',
        ]);

        Anggota::create([
            'user_id'        => $user->id,
            'nomor_anggota'  => 'AGT-' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
            'jenis_anggota'  => $request->jenis_anggota,
            'kelas'          => $request->kelas,
            'telepon'        => $request->telepon,
            'alamat'         => $request->alamat,
            'tanggal_daftar' => now()->toDateString(),
            'status'         => 'aktif',
        ]);

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(Anggota $anggota)
    {
        // FIX: Eager load relasi user agar tidak null di view
        $anggota->load('user');
        return view('admin.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $request->validate([
            'jenis_anggota' => 'required|string',
            'kelas'         => 'nullable|string|max:50',
            'telepon'       => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'status'        => 'required|in:aktif,nonaktif',
        ]);
        $anggota->update($request->only('jenis_anggota', 'kelas', 'telepon', 'alamat', 'status'));
        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Anggota $anggota)
    {
        $user = $anggota->user; // simpan referensi user dulu
        $anggota->delete();     // hapus anggota dulu (child)
        $user?->delete();       // baru hapus user (parent)
        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }
}