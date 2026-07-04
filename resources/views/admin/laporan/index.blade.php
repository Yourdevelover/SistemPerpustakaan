<x-admin-layout title="Laporan & Statistik" subtitle="Ringkasan aktivitas perpustakaan per periode">

    {{-- Filter Periode --}}
    <form method="GET" class="flex items-center gap-3 mb-6 bg-white border border-slate-200 rounded-xl px-5 py-4">
        <i data-lucide="calendar" class="w-4 h-4 text-slate-400 shrink-0"></i>
        <span class="text-sm font-medium text-slate-700">Periode:</span>
        <select name="bulan" class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500">
            @foreach(range(1,12) as $b)
                <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                </option>
            @endforeach
        </select>
        <select name="tahun" class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 bg-white focus:outline-none focus:ring-2 focus:ring-sky-500">
            @foreach(range(date('Y'), date('Y')-4) as $t)
                <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-1.5 bg-sky-600 text-white text-sm font-medium rounded-lg hover:bg-sky-700 transition-colors">Tampilkan</button>
    </form>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Total Peminjaman</p>
                <div class="w-8 h-8 bg-sky-50 rounded-lg flex items-center justify-center">
                    <i data-lucide="arrow-left-right" class="w-4 h-4 text-sky-600"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $totalPeminjaman }}</p>
            <p class="text-xs text-slate-400 mt-1">Transaksi bulan ini</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Dikembalikan</p>
                <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $totalDikembalikan }}</p>
            <p class="text-xs text-slate-400 mt-1">Selesai tepat waktu</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Terlambat</p>
                <div class="w-8 h-8 bg-rose-50 rounded-lg flex items-center justify-center">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-rose-500"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $totalTerlambat }}</p>
            <p class="text-xs text-slate-400 mt-1">Melewati jatuh tempo</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Total Denda</p>
                <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center">
                    <i data-lucide="receipt" class="w-4 h-4 text-amber-600"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-900">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-400 mt-1">Akumulasi denda</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
        {{-- Tabel Peminjaman --}}
        <div class="xl:col-span-2 bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-900">Riwayat Peminjaman</h2>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50">
                        <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Anggota</th>
                        <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Buku</th>
                        <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($peminjaman as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-3 font-medium text-slate-900">{{ $item->anggota->user->nama_lengkap ?? '-' }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $item->detailPeminjamans->first()->buku->judul ?? '-' }}</td>
                        <td class="px-5 py-3">
                            @if($item->status === 'dikembalikan')
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Dikembalikan</span>
                            @elseif($item->status === 'terlambat')
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-600">Terlambat</span>
                            @else
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Dipinjam</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-5 py-10 text-center text-slate-400 text-sm">Tidak ada data periode ini</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Buku Terpopuler --}}
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-900">Buku Terpopuler</h2>
            </div>
            <div class="p-4 space-y-3">
                @forelse($bukuTerpopuler as $i => $buku)
                <div class="flex items-center gap-3">
                    <span class="w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold flex-shrink-0
                        {{ $i === 0 ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-500' }}">
                        {{ $i + 1 }}
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-800 truncate">{{ $buku->judul }}</p>
                        <p class="text-xs text-slate-400">{{ $buku->detail_peminjamans_count }}x dipinjam</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-slate-400 text-center py-6">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>

</x-admin-layout>