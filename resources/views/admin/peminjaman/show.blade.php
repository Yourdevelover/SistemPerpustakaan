<x-admin-layout title="Detail Peminjaman" subtitle="Informasi lengkap transaksi peminjaman">
<div class="max-w-2xl space-y-4">

    {{-- Info Peminjaman --}}
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <h2 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
            <i data-lucide="file-text" class="w-4 h-4 text-slate-400"></i> Info Peminjaman
        </h2>
        <div class="grid grid-cols-2 gap-y-3 text-sm">
            <div><p class="text-slate-400 text-xs mb-0.5">Anggota</p><p class="font-semibold text-slate-900">{{ $peminjaman->anggota->user->nama_lengkap ?? '-' }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">No. Anggota</p><p class="text-slate-700">{{ $peminjaman->anggota->nomor_anggota ?? '-' }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Tanggal Pinjam</p><p class="text-slate-700">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Jatuh Tempo</p><p class="text-slate-700">{{ \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo)->format('d M Y') }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Tgl Kembali</p><p class="text-slate-700">{{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') : '-' }}</p></div>
            <div><p class="text-slate-400 text-xs mb-0.5">Status</p>
                @if($peminjaman->status === 'dipinjam')
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700"><i data-lucide="clock" class="w-3 h-3"></i> Dipinjam</span>
                @elseif($peminjaman->status === 'terlambat')
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-600"><i data-lucide="alert-circle" class="w-3 h-3"></i> Terlambat</span>
                @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700"><i data-lucide="check-circle" class="w-3 h-3"></i> Dikembalikan</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Daftar Buku --}}
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100">
            <h2 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                <i data-lucide="book" class="w-4 h-4 text-slate-400"></i> Buku Dipinjam
            </h2>
        </div>
        <table class="w-full text-sm">
            <thead><tr class="bg-slate-50 border-b border-slate-100">
                <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Judul</th>
                <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Kondisi Pinjam</th>
                <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Kondisi Kembali</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($peminjaman->detailPeminjamans as $detail)
                <tr>
                    <td class="px-5 py-3 font-medium text-slate-900">{{ $detail->buku->judul ?? '-' }}</td>
                    <td class="px-5 py-3 text-slate-600">{{ $detail->kondisi_pinjam ?? '-' }}</td>
                    <td class="px-5 py-3 text-slate-600">{{ $detail->kondisi_kembali ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Denda --}}
    @if($peminjaman->denda)
    <div class="bg-red-50 rounded-xl border border-red-200 p-5">
        <h2 class="text-sm font-semibold text-red-800 mb-3 flex items-center gap-2">
            <i data-lucide="receipt" class="w-4 h-4"></i> Denda
        </h2>
        <div class="grid grid-cols-2 gap-3 text-sm">
            <div><p class="text-red-400 text-xs mb-0.5">Jumlah Denda</p><p class="font-bold text-red-700">Rp {{ number_format($peminjaman->denda->jumlah_denda, 0, ',', '.') }}</p></div>
            <div><p class="text-red-400 text-xs mb-0.5">Status</p>
                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $peminjaman->denda->status_bayar === 'lunas' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $peminjaman->denda->status_bayar === 'lunas' ? 'Lunas' : 'Belum Bayar' }}
                </span>
            </div>
        </div>
    </div>
    @endif

    <div class="flex justify-end">
        <a href="{{ route('admin.peminjaman.index') }}"
            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>
</div>
</x-admin-layout>