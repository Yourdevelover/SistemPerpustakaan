<x-admin-layout title="Manajemen Buku" subtitle="Kelola seluruh koleksi buku perpustakaan">

    {{-- Header Actions --}}
    <div class="flex items-center justify-between mb-6">
        <form method="GET" action="{{ route('admin.buku.index') }}" class="flex items-center gap-2">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari judul, penulis, ISBN..."
                    class="input-field pl-9 pr-4 py-2 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 w-72"
                />
            </div>
            <select name="kategori" class="text-sm border border-slate-200 rounded-lg px-3 py-2 bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500">
                <option value="">Semua Kategori</option>
                @foreach(\App\Models\KategoriBuku::all() as $kat)
                    <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="px-3 py-2 text-sm bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors">
                Filter
            </button>
        </form>

        <a href="{{ route('admin.buku.create') }}"
            class="flex items-center gap-2 px-4 py-2 bg-sky-600 text-white text-sm font-semibold rounded-lg hover:bg-sky-700 transition-colors">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Tambah Buku
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-4 flex items-center gap-2 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg">
            <i data-lucide="circle-check" class="w-4 h-4 shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Buku</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Kategori</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Stok</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Rak</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($bukus as $buku)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-12 bg-slate-100 rounded flex items-center justify-center flex-shrink-0">
                                @if($buku->cover_path)
                                    <img src="{{ Storage::url($buku->cover_path) }}" class="w-9 h-12 object-cover rounded">
                                @else
                                    <i data-lucide="book" class="w-4 h-4 text-slate-400"></i>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">{{ $buku->judul }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $buku->penulis }} · {{ $buku->tahun_terbit }}</p>
                                <p class="text-xs text-slate-400">ISBN: {{ $buku->isbn }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-sky-50 text-sky-700">
                            {{ $buku->kategori->nama_kategori ?? '-' }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-semibold text-slate-900">{{ $buku->jumlah_tersedia }}</p>
                        <p class="text-xs text-slate-400">dari {{ $buku->jumlah_total }}</p>
                    </td>
                    <td class="px-5 py-4 text-slate-600">{{ $buku->lokasi_rak ?? '-' }}</td>
                    <td class="px-5 py-4">
                        @if($buku->jumlah_tersedia > 0)
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Tersedia
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Habis
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.buku.edit', $buku) }}"
                                class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-sky-600 hover:bg-sky-50 transition-colors">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.buku.destroy', $buku) }}"
                                onsubmit="return confirm('Hapus buku ini?')">
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
                    <td colspan="6" class="px-5 py-16 text-center">
                        <i data-lucide="book-x" class="w-10 h-10 mx-auto text-slate-300 mb-3"></i>
                        <p class="text-slate-500 font-medium">Belum ada buku</p>
                        <p class="text-slate-400 text-xs mt-1">Tambahkan buku pertama ke koleksi perpustakaan</p>
                        <a href="{{ route('admin.buku.create') }}" class="inline-flex items-center gap-1.5 mt-4 px-4 py-2 bg-sky-600 text-white text-sm font-medium rounded-lg hover:bg-sky-700 transition-colors">
                            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Buku
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($bukus->hasPages())
            <div class="px-5 py-3 border-t border-slate-100 flex items-center justify-between">
                <p class="text-xs text-slate-400">
                    Menampilkan {{ $bukus->firstItem() }}–{{ $bukus->lastItem() }} dari {{ $bukus->total() }} buku
                </p>
                {{ $bukus->links('pagination::tailwind') }}
            </div>
        @endif
    </div>

</x-admin-layout>