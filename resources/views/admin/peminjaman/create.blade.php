<x-admin-layout title="Catat Peminjaman" subtitle="Tambah transaksi peminjaman baru">
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-slate-200 p-6">
        @if($errors->any())
            <div class="mb-5 flex gap-2 px-4 py-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg">
                <i data-lucide="circle-alert" class="w-4 h-4 mt-0.5 shrink-0"></i>
                <ul class="space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.peminjaman.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Anggota <span class="text-red-500">*</span></label>
                <select name="anggota_id" required
                    class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                    <option value="">Pilih anggota</option>
                    @foreach($anggota as $a)
                        <option value="{{ $a->id }}" {{ old('anggota_id') == $a->id ? 'selected' : '' }}>
                            {{ $a->user->nama_lengkap }} ({{ $a->nomor_anggota }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Pilih Buku <span class="text-red-500">*</span></label>
                <div class="border border-slate-300 rounded-lg divide-y divide-slate-100 max-h-48 overflow-y-auto">
                    @foreach($bukus as $b)
                    <label class="flex items-center gap-3 px-4 py-2.5 hover:bg-slate-50 cursor-pointer">
                        <input type="checkbox" name="buku_ids[]" value="{{ $b->id }}"
                            {{ in_array($b->id, old('buku_ids', [])) ? 'checked' : '' }}
                            class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-800 truncate">{{ $b->judul }}</p>
                            <p class="text-xs text-slate-400">{{ $b->penulis }} · Stok: {{ $b->jumlah_tersedia }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Pinjam <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required
                        class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Durasi Pinjam <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="number" name="durasi_hari" value="{{ old('durasi_hari', 7) }}" required min="1" max="30"
                            class="w-full px-3 py-2.5 pr-12 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 text-sm">hari</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                <a href="{{ route('admin.peminjaman.index') }}"
                    class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit"
                    class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>
</x-admin-layout>