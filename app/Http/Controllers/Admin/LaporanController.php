<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Denda;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $data = [
            'totalPeminjaman' => Peminjaman::whereMonth('tanggal_pinjam', $bulan)
                ->whereYear('tanggal_pinjam', $tahun)->count(),
            'totalDikembalikan' => Peminjaman::where('status', 'dikembalikan')
                ->whereMonth('tanggal_pinjam', $bulan)->whereYear('tanggal_pinjam', $tahun)->count(),
            'totalTerlambat' => Peminjaman::where('status', 'terlambat')
                ->whereMonth('tanggal_pinjam', $bulan)->whereYear('tanggal_pinjam', $tahun)->count(),
            'totalDenda' => Denda::whereHas('peminjaman', fn($q) =>
                $q->whereMonth('tanggal_pinjam', $bulan)->whereYear('tanggal_pinjam', $tahun)
            )->sum('jumlah_denda'),
            'bukuTerpopuler' => Buku::withCount('detailPeminjamans')->orderByDesc('detail_peminjamans_count')->take(5)->get(),
            'peminjaman' => Peminjaman::with(['anggota.user', 'detailPeminjamans.buku'])
                ->whereMonth('tanggal_pinjam', $bulan)->whereYear('tanggal_pinjam', $tahun)
                ->latest()->get(),
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];

        return view('admin.laporan.index', $data);
    }
}