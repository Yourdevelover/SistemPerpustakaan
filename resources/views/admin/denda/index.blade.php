<x-admin-layout title="Denda" subtitle="Kelola tagihan denda keterlambatan">

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
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Jumlah Denda</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Status</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Tgl Bayar</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($dendas as $denda)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-4">
                        <p class="font-semibold text-slate-900">{{ $denda->peminjaman->anggota->user->nama_lengkap ?? '-' }}</p>
                        <p class="text-xs text-slate-400">ID Peminjaman #{{ $denda->peminjaman_id }}</p>
                    </td>
                    <td class="px-5 py-4 font-bold text-slate-900">
                        Rp {{ number_format($denda->jumlah_denda, 0, ',', '.') }}
                    </td>
                    <td class="px-5 py-4">
                        @if($denda->status_bayar === 'lunas')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                <i data-lucide="check-circle" class="w-3 h-3"></i> Lunas
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-600">
                                <i data-lucide="clock" class="w-3 h-3"></i> Belum Bayar
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-slate-500">
                        {{ $denda->tanggal_bayar ? \Carbon\Carbon::parse($denda->tanggal_bayar)->format('d M Y') : '-' }}
                    </td>
                    <td class="px-5 py-4">
                        @if($denda->status_bayar !== 'lunas')
                            <form method="POST" action="{{ route('admin.denda.update', $denda) }}">
                                @csrf @method('PUT')
                                <input type="hidden" name="status_bayar" value="lunas">
                                <button type="submit"
                                    class="flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 text-white text-xs font-semibold rounded-lg hover:bg-emerald-700 transition-colors">
                                    <i data-lucide="check" class="w-3 h-3"></i> Tandai Lunas
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-16 text-center">
                        <i data-lucide="receipt" class="w-10 h-10 mx-auto text-slate-300 mb-3"></i>
                        <p class="text-slate-500 font-medium">Tidak ada data denda</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($dendas->hasPages())
            <div class="px-5 py-3 border-t border-slate-100">{{ $dendas->links('pagination::tailwind') }}</div>
        @endif
    </div>

</x-admin-layout>