<x-admin-layout title="Pengembalian Buku" subtitle="Proses pengembalian dan catat kondisi buku">

    @if(session('success'))
        <div class="mb-4 flex items-center gap-2 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg">
            <i data-lucide="circle-check" class="w-4 h-4 shrink-0"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-slate-900">Buku Belum Dikembalikan</h2>
            <span class="text-xs bg-amber-50 text-amber-700 font-medium px-2.5 py-0.5 rounded-full">
                {{ $peminjaman->total() }} aktif
            </span>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Anggota</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Buku</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Jatuh Tempo</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($peminjaman as $item)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-4">
                        <p class="font-semibold text-slate-900">{{ optional($item->anggota)->user->nama_lengkap ?? '-' }}</p>
                        <p class="text-xs text-slate-400">{{ optional($item->anggota)->nomor_anggota ?? '' }}</p>
                    </td>
                    <td class="px-5 py-4 text-slate-700">
                        {{ optional(optional($item->detailPeminjamans->first())->buku)->judul ?? '-' }}
                    </td>
                    <td class="px-5 py-4">
                        <p class="text-slate-700">{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y') }}</p>
                        @if(\Carbon\Carbon::now()->gt($item->tanggal_jatuh_tempo))
                            <p class="text-xs text-rose-500 font-medium mt-0.5">
                                Terlambat {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->diffInDays(now()) }} hari
                            </p>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        @if($item->status === 'terlambat')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-600">
                                <i data-lucide="alert-circle" class="w-3 h-3"></i> Terlambat
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">
                                <i data-lucide="clock" class="w-3 h-3"></i> Dipinjam
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <button onclick="openReturn({{ $item->id }}, '{{ addslashes(optional(optional($item->anggota)->user)->nama_lengkap ?? '') }}')"
                            class="flex items-center gap-1.5 px-3 py-1.5 bg-sky-600 text-white text-xs font-semibold rounded-lg hover:bg-sky-700 transition-colors">
                            <i data-lucide="rotate-ccw" class="w-3 h-3"></i> Proses
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-16 text-center">
                        <i data-lucide="check-circle" class="w-10 h-10 mx-auto text-emerald-300 mb-3"></i>
                        <p class="text-slate-500 font-medium">Semua buku sudah dikembalikan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($peminjaman->hasPages())
            <div class="px-5 py-3 border-t border-slate-100">{{ $peminjaman->links('pagination::tailwind') }}</div>
        @endif
    </div>

    {{-- Modal Proses Pengembalian --}}
    <div id="modal-return" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40">
        <div class="bg-white rounded-xl border border-slate-200 p-6 w-full max-w-md mx-4">
            <h3 class="text-sm font-semibold text-slate-900 mb-1">Proses Pengembalian</h3>
            <p class="text-xs text-slate-400 mb-4" id="return-name"></p>
            <form method="POST" action="{{ route('admin.pengembalian.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="peminjaman_id" id="return-id">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" value="{{ date('Y-m-d') }}" required
                        class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Kondisi Buku Kembali</label>
                    <select name="kondisi_kembali" required
                        class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <option value="baik">Baik</option>
                        <option value="rusak_ringan">Rusak Ringan</option>
                        <option value="rusak_berat">Rusak Berat</option>
                    </select>
                </div>
                <div class="bg-amber-50 border border-amber-200 rounded-lg px-4 py-3 text-xs text-amber-700 flex items-start gap-2">
                    <i data-lucide="info" class="w-4 h-4 shrink-0 mt-0.5"></i>
                    Jika dikembalikan setelah jatuh tempo, denda akan otomatis dihitung Rp 1.000/hari.
                </div>
                <div class="flex gap-3 pt-1">
                    <button type="button" onclick="closeReturn()"
                        class="flex-1 px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">Batal</button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-sky-600 text-white text-sm font-semibold rounded-lg hover:bg-sky-700 transition-colors">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openReturn(id, name) {
            document.getElementById('return-id').value = id;
            document.getElementById('return-name').textContent = 'Anggota: ' + name;
            document.getElementById('modal-return').classList.remove('hidden');
        }
        function closeReturn() {
            document.getElementById('modal-return').classList.add('hidden');
        }
    </script>

</x-admin-layout>