<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Denda;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['anggota.user', 'detailPeminjamans.buku'])
            ->whereIn('status', ['dipinjam', 'terlambat'])->latest()->paginate(10);
        return view('admin.pengembalian.index', compact('peminjaman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id'    => 'required|exists:peminjamen,id',
            'tanggal_kembali'  => 'required|date',
            'kondisi_kembali'  => 'required|string',
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);
        $tglKembali = \Carbon\Carbon::parse($request->tanggal_kembali)->startOfDay();
        $jatuhTempo = \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo)->startOfDay();

        $terlambat = $tglKembali->gt($jatuhTempo);
        $selisihHari = $terlambat ? $jatuhTempo->diffInDays($tglKembali) : 0;
        $dendaPerHari = 1000;

        $peminjaman->update([
            'tanggal_kembali' => $request->tanggal_kembali,
            'status'          => 'dikembalikan',
        ]);

        foreach ($peminjaman->detailPeminjamans as $detail) {
            $detail->update(['kondisi_kembali' => $request->kondisi_kembali]);
            $detail->buku->increment('jumlah_tersedia');
        }

        if ($terlambat) {
            Denda::create([
                'peminjaman_id' => $peminjaman->id,
                'jumlah_denda'  => $selisihHari * $dendaPerHari,
                'status_bayar'  => 'belum_bayar',
            ]);
        }

        return redirect()->route('admin.pengembalian.index')->with('success', 'Pengembalian berhasil dicatat.' . ($terlambat ? " Denda Rp " . number_format($selisihHari * $dendaPerHari, 0, ',', '.') . " telah dibuat." : ''));
    }
}