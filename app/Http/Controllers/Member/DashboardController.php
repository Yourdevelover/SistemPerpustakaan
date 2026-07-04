<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user && $user->role && $user->role->nama_role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $anggota = $user?->anggota;

        if (!$anggota) {
            $anggota = new \stdClass();
            $anggota->nomor_anggota = 'DEMO-001';
            $anggota->jenis_anggota = 'siswa';
            $anggota->kelas = 'XII';
            $anggota->status = 'aktif';
            $anggota->tanggal_daftar = now()->toDateString();
        }

        $totalPinjam = 0;
        $sedangDipinjam = 0;
        $terlambat = 0;
        $dendaBelumLunas = 0;
        $peminjamanAktif = collect();
        $riwayat = collect();
        $dendas = collect();

        if ($user && $anggota && method_exists($anggota, 'peminjamans')) {
            $totalPinjam = $anggota->peminjamans()->count();
            $sedangDipinjam = $anggota->peminjamans()->whereIn('status', ['dipinjam', 'terlambat'])->count();
            $terlambat = $anggota->peminjamans()->where('status', 'terlambat')->count();
            $dendaBelumLunas = $anggota->peminjamans()
                ->whereHas('denda', fn($q) => $q->where('status_bayar', 'belum_bayar'))
                ->with('denda')
                ->get()
                ->sum(fn($p) => optional($p->denda)->jumlah_denda ?? 0);

            $peminjamanAktif = $anggota->peminjamans()
                ->with(['detailPeminjamans.buku.kategori', 'denda'])
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->latest()
                ->get();

            $riwayat = $anggota->peminjamans()
                ->with(['detailPeminjamans.buku', 'denda'])
                ->where('status', 'dikembalikan')
                ->latest()
                ->paginate(5, ['*'], 'riwayat_page');

            $dendas = $anggota->peminjamans()
                ->whereHas('denda', fn($q) => $q->where('status_bayar', 'belum_bayar'))
                ->with(['detailPeminjamans.buku', 'denda'])
                ->latest()
                ->get();
        }

        $bukuTersedia = Buku::with('kategori')
            ->where('jumlah_tersedia', '>', 0)
            ->when($request->cari, fn($q) =>
                $q->where('judul', 'like', "%{$request->cari}%")
                  ->orWhere('penulis', 'like', "%{$request->cari}%")
            )
            ->latest()
            ->paginate(6, ['*'], 'buku_page');

        return view('member.dashboard', compact(
            'anggota',
            'totalPinjam',
            'sedangDipinjam',
            'terlambat',
            'dendaBelumLunas',
            'peminjamanAktif',
            'riwayat',
            'dendas',
            'bukuTersedia'
        ));
    }
}