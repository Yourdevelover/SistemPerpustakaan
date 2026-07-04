<x-admin-layout title="Kategori Buku" subtitle="Kelola kategori koleksi buku">

    @if(session('success'))
        <div class="mb-4 flex items-center gap-2 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg">
            <i data-lucide="circle-check" class="w-4 h-4 shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Form Tambah --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 h-fit">
            <h2 class="text-sm font-semibold text-slate-900 mb-4">Tambah Kategori</h2>
            <form method="POST" action="{{ route('admin.kategori.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" required
                        placeholder="Contoh: Fiksi, Sains..."
                        class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500"
                    />
                    @error('nama_kategori')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" placeholder="Deskripsi singkat kategori..."
                        class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 resize-none">{{ old('deskripsi') }}</textarea>
                </div>
                <button type="submit"
                    class="btn-primary w-full flex items-center justify-center gap-2 px-4 py-2.5 text-white text-sm font-semibold rounded-lg transition-colors">
                    <i data-lucide="plus" class="w-4 h-4"></i> Tambah Kategori
                </button>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 overflow-hidden h-fit">
            <div class="px-5 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-900">Daftar Kategori</h2>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50">
                        <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Nama Kategori</th>
                        <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Deskripsi</th>
                        <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Jumlah Buku</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($kategoris as $kategori)
                    <tr class="hover:bg-slate-50 transition-colors" id="row-{{ $kategori->id }}">
                        <td class="px-5 py-4 font-medium text-slate-900">{{ $kategori->nama_kategori }}</td>
                        <td class="px-5 py-4 text-slate-500">{{ $kategori->deskripsi ?? '-' }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-sky-50 text-sky-700">
                                {{ $kategori->bukus_count }} buku
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                {{-- FIX: Gunakan addslashes() agar nama/deskripsi dengan tanda kutip tidak merusak JS --}}
                                <button onclick="openEdit({{ $kategori->id }}, '{{ addslashes($kategori->nama_kategori) }}', '{{ addslashes($kategori->deskripsi ?? '') }}')"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-sky-600 hover:bg-sky-50 transition-colors">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.kategori.destroy', $kategori) }}"
                                    onsubmit="return confirm('Hapus kategori ini?')">
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
                        <td colspan="4" class="px-5 py-12 text-center text-slate-400 text-sm">
                            <i data-lucide="tag" class="w-8 h-8 mx-auto mb-2 text-slate-300"></i>
                            Belum ada kategori
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @if($kategoris->hasPages())
                <div class="px-5 py-3 border-t border-slate-100">
                    {{ $kategoris->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Edit --}}
    <div id="modal-edit" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40">
        <div class="bg-white rounded-xl border border-slate-200 p-6 w-full max-w-md mx-4">
            <h3 class="text-sm font-semibold text-slate-900 mb-4">Edit Kategori</h3>
            <form method="POST" id="form-edit" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Kategori</label>
                    <input type="text" name="nama_kategori" id="edit-nama" required
                        class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" id="edit-deskripsi" rows="3"
                        class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 resize-none"></textarea>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeEdit()"
                        class="flex-1 px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-sky-600 text-white text-sm font-semibold rounded-lg hover:bg-sky-700 transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEdit(id, nama, deskripsi) {
            document.getElementById('edit-nama').value = nama;
            document.getElementById('edit-deskripsi').value = deskripsi;
            document.getElementById('form-edit').action = `/admin/kategori/${id}`;
            document.getElementById('modal-edit').classList.remove('hidden');
        }
        function closeEdit() {
            document.getElementById('modal-edit').classList.add('hidden');
        }
    </script>

</x-admin-layout>