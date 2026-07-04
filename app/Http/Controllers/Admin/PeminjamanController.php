<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $peminjaman = Peminjaman::with(['anggota.user', 'detailPeminjamans.buku'])
            ->when(
                $request->search,
                fn($q) =>
                $q->whereHas(
                    'anggota.user',
                    fn($u) =>
                    $u->where('nama_lengkap', 'like', "%{$request->search}%")
                )
            )
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->oldest()->paginate(10)->withQueryString();

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $anggota = Anggota::with('user')->where('status', 'aktif')->get();
        $bukus   = Buku::where('jumlah_tersedia', '>', 0)->orderBy('judul')->get();
        return view('admin.peminjaman.create', compact('anggota', 'bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id'     => 'required|exists:anggotas,id',
            'buku_ids'       => 'required|array|min:1',
            'buku_ids.*'     => 'exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'durasi_hari'    => 'required|integer|min:1|max:30',
        ]);

        $peminjaman = Peminjaman::create([
            'anggota_id'         => $request->anggota_id,
            'tanggal_pinjam'     => $request->tanggal_pinjam,
            'tanggal_jatuh_tempo' => now()->parse($request->tanggal_pinjam)->addDays((int) $request->durasi_hari)->toDateString(),
            'status'             => 'dipinjam',
            'admin_id'           => Auth::id(),
        ]);

        foreach ($request->buku_ids as $bukuId) {
            DetailPeminjaman::create([
                'peminjaman_id'   => $peminjaman->id,
                'buku_id'         => $bukuId,
                'kondisi_pinjam'  => 'baik',
            ]);
            Buku::find($bukuId)->decrement('jumlah_tersedia');
        }

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['anggota.user', 'detailPeminjamans.buku', 'denda']);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('admin.peminjaman.index')->with('success', 'Data peminjaman dihapus.');
    }
}