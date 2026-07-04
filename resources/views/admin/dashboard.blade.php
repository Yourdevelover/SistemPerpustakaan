<x-admin-layout title="Dashboard" subtitle="Ringkasan sistem perpustakaan hari ini">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Total Buku</p>
                <div class="w-8 h-8 bg-sky-50 rounded-lg flex items-center justify-center">
                    <i data-lucide="book" class="w-4 h-4 text-sky-600"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $totalBuku ?? '0' }}</p>
            <p class="text-xs text-slate-400 mt-1">Koleksi terdaftar</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Anggota Aktif</p>
                <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center">
                    <i data-lucide="users" class="w-4 h-4 text-emerald-600"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $totalAnggota ?? '0' }}</p>
            <p class="text-xs text-slate-400 mt-1">Terdaftar di sistem</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Dipinjam</p>
                <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center">
                    <i data-lucide="arrow-left-right" class="w-4 h-4 text-amber-600"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $totalDipinjam ?? '0' }}</p>
            <p class="text-xs text-slate-400 mt-1">Sedang berjalan</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Denda Belum Lunas</p>
                <div class="w-8 h-8 bg-rose-50 rounded-lg flex items-center justify-center">
                    <i data-lucide="receipt" class="w-4 h-4 text-rose-500"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $totalDenda ?? '0' }}</p>
            <p class="text-xs text-slate-400 mt-1">Perlu ditindaklanjuti</p>
        </div>
    </div>

    {{-- Table + Alert --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

        {{-- Peminjaman Terbaru --}}
        <div class="xl:col-span-2 bg-white rounded-xl border border-slate-200">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-900">Peminjaman Terbaru</h2>
                <a href="#" class="text-xs text-sky-600 hover:text-sky-700 font-medium flex items-center gap-1">
                    Lihat semua <i data-lucide="arrow-right" class="w-3 h-3"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50">
                            <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3">Anggota</th>
                            <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3">Buku</th>
                            <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3">Jatuh Tempo</th>
                            <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjaman ?? [] as $item)
                        <tr class="border-b border-slate-50 hover:bg-slate-50 transition-colors">
                            <td class="px-5 py-3 text-slate-900 font-medium">{{ $item->anggota->user->nama_lengkap ?? '-' }}</td>
                            <td class="px-5 py-3 text-slate-600">{{ $item->detailPeminjamans->first()->buku->judul ?? '-' }}</td>
                            <td class="px-5 py-3 text-slate-500">{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y') }}</td>
                            <td class="px-5 py-3">
                                @if($item->status === 'dipinjam')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">
                                        <i data-lucide="clock" class="w-3 h-3"></i> Dipinjam
                                    </span>
                                @elseif($item->status === 'terlambat')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-600">
                                        <i data-lucide="alert-circle" class="w-3 h-3"></i> Terlambat
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                        <i data-lucide="check-circle" class="w-3 h-3"></i> Dikembalikan
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-slate-400 text-sm">
                                <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 text-slate-300"></i>
                                <p>Belum ada data peminjaman</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Jatuh Tempo & Terlambat --}}
        <div class="bg-white rounded-xl border border-slate-200">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-900">Perlu Perhatian</h2>
                <span class="text-xs bg-rose-50 text-rose-600 font-medium px-2 py-0.5 rounded-full">
                    {{ $totalTerlambat ?? 0 }} item
                </span>
            </div>
            <div class="p-4 space-y-3">
                @forelse($terlambat ?? [] as $item)
                <div class="flex items-start gap-3 p-3 bg-rose-50 rounded-lg border border-rose-100">
                    <div class="w-7 h-7 rounded-full bg-rose-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i data-lucide="alert-circle" class="w-3.5 h-3.5 text-rose-500"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-slate-800 truncate">{{ $item->anggota->user->nama_lengkap ?? '-' }}</p>
                        <p class="text-xs text-slate-500 truncate mt-0.5">{{ $item->detailPeminjamans->first()->buku->judul ?? '-' }}</p>
                        <p class="text-xs text-rose-500 mt-1 font-medium">Jatuh tempo: {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y') }}</p>
                    </div>
                </div>
                @empty
                <div class="py-8 text-center text-slate-400">
                    <i data-lucide="check-circle" class="w-8 h-8 mx-auto mb-2 text-emerald-400"></i>
                    <p class="text-sm text-slate-500">Tidak ada yang terlambat</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>

</x-admin-layout>