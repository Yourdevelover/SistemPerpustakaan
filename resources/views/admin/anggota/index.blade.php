<x-admin-layout title="Data Anggota" subtitle="Kelola seluruh anggota perpustakaan">

    <div class="flex items-center justify-between mb-6">
        <form method="GET" class="flex items-center gap-2">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, nomor anggota..."
                    class="input-field pl-9 pr-4 py-2 text-sm border rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 w-64"
                />
            </div>
            <select name="status" class="text-sm border border-slate-200 rounded-lg px-3 py-2 bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            <button type="submit" class="px-3 py-2 text-sm bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors">Filter</button>
        </form>
        <a href="{{ route('admin.anggota.create') }}"
            class="flex items-center gap-2 px-4 py-2 bg-sky-600 text-white text-sm font-semibold rounded-lg hover:bg-sky-700 transition-colors">
            <i data-lucide="user-plus" class="w-4 h-4"></i> Tambah Anggota
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
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Anggota</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">No. Anggota</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Jenis</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Kelas</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($anggota as $a)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-sky-100 flex items-center justify-center text-sky-700 text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($a->user->nama_lengkap ?? '?', 0, 2)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">{{ $a->user->nama_lengkap ?? '-' }}</p>
                                <p class="text-xs text-slate-400">{{ $a->user->email ?? '' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-slate-600 font-mono text-xs">{{ $a->nomor_anggota }}</td>
                    <td class="px-5 py-4 text-slate-600 capitalize">{{ $a->jenis_anggota }}</td>
                    <td class="px-5 py-4 text-slate-600">{{ $a->kelas ?? '-' }}</td>
                    <td class="px-5 py-4">
                        @if($a->status === 'aktif')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.anggota.edit', $a) }}"
                                class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-sky-600 hover:bg-sky-50 transition-colors">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.anggota.destroy', $a) }}"
                                onsubmit="return confirm('Hapus anggota ini? Data user juga akan ikut terhapus.')">
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
                        <i data-lucide="users" class="w-10 h-10 mx-auto text-slate-300 mb-3"></i>
                        <p class="text-slate-500 font-medium">Belum ada anggota terdaftar</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($anggota->hasPages())
            <div class="px-5 py-3 border-t border-slate-100 flex items-center justify-between">
                <p class="text-xs text-slate-400">Total {{ $anggota->total() }} anggota</p>
                {{ $anggota->links('pagination::tailwind') }}
            </div>
        @endif
    </div>

</x-admin-layout>