<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Denda;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalBuku'     => Buku::count(),
            'totalAnggota'  => Anggota::where('status', 'aktif')->count(),
            'totalDipinjam' => Peminjaman::where('status', 'dipinjam')->count(),
            'totalDenda'    => Denda::where('status_bayar', 'belum_bayar')->count(),
            'peminjaman'    => Peminjaman::with(['anggota.user', 'detailPeminjamans.buku'])
                                ->latest()->take(6)->get(),
            'terlambat'     => Peminjaman::with(['anggota.user', 'detailPeminjamans.buku'])
                                ->where('status', 'terlambat')->take(5)->get(),
            'totalTerlambat'=> Peminjaman::where('status', 'terlambat')->count(),
        ]);
    }
}