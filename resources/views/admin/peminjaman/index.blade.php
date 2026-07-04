<x-admin-layout title="Peminjaman" subtitle="Kelola transaksi peminjaman buku">

    <div class="flex items-center justify-between mb-6">
        <form method="GET" class="flex items-center gap-2">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama anggota..."
                    class="input-field pl-9 pr-4 py-2 text-sm border rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 w-64"
                />
            </div>
            <select name="status" class="text-sm border border-slate-200 rounded-lg px-3 py-2 bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500">
                <option value="">Semua Status</option>
                <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
            </select>
            <button type="submit" class="px-3 py-2 text-sm bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors">Filter</button>
        </form>
        <a href="{{ route('admin.peminjaman.create') }}"
            class="flex items-center gap-2 px-4 py-2 bg-sky-600 text-white text-sm font-semibold rounded-lg hover:bg-sky-700 transition-colors">
            <i data-lucide="plus" class="w-4 h-4"></i> Catat Peminjaman
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 flex items-center gap-2 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg">
            <i data-lucide="circle-check" class="w-4 h-4 shrink-0"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">#</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Anggota</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Buku</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Tgl Pinjam</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Jatuh Tempo</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($peminjaman as $item)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-4 text-slate-400 text-xs">{{ $item->id }}</td>
                    <td class="px-5 py-4">
                        <p class="font-semibold text-slate-900">{{ $item->anggota->user->nama_lengkap ?? '-' }}</p>
                        <p class="text-xs text-slate-400">{{ $item->anggota->nomor_anggota ?? '' }}</p>
                    </td>
                    <td class="px-5 py-4 text-slate-600">
                        {{ $item->detailPeminjamans->first()->buku->judul ?? '-' }}
                        @if($item->detailPeminjamans->count() > 1)
                            <span class="text-xs text-slate-400">+{{ $item->detailPeminjamans->count() - 1 }} lainnya</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-slate-600">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                    <td class="px-5 py-4 text-slate-600">{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y') }}</td>
                    <td class="px-5 py-4">
                        @if($item->status === 'dipinjam')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">
                                <i data-lucide="clock" class="w-3 h-3"></i> Dipinjam
                            </span>
                        @elseif($item->status === 'terlambat')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-600">
                                <i data-lucide="alert-circle" class="w-3 h-3"></i> Terlambat
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                <i data-lucide="check-circle" class="w-3 h-3"></i> Dikembalikan
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.peminjaman.show', $item) }}"
                                class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-sky-600 hover:bg-sky-50 transition-colors">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.peminjaman.destroy', $item) }}"
                                onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-16 text-center">
                        <i data-lucide="arrow-left-right" class="w-10 h-10 mx-auto text-slate-300 mb-3"></i>
                        <p class="text-slate-500 font-medium">Belum ada data peminjaman</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($peminjaman->hasPages())
            <div class="px-5 py-3 border-t border-slate-100 flex items-center justify-between">
                <p class="text-xs text-slate-400">Total {{ $peminjaman->total() }} transaksi</p>
                {{ $peminjaman->links('pagination::tailwind') }}
            </div>
        @endif
    </div>

</x-admin-layout>