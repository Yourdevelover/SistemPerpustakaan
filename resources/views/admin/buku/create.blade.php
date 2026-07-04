<x-admin-layout title="Tambah Buku" subtitle="Tambahkan buku baru ke koleksi perpustakaan">

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-slate-200 p-6">

            @if($errors->any())
                <div class="mb-5 flex gap-2 px-4 py-3 bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-lg">
                    <i data-lucide="circle-alert" class="w-4 h-4 mt-0.5 shrink-0"></i>
                    <ul class="space-y-0.5">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.buku.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Judul Buku <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul') }}" required
                            class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent"
                            placeholder="Masukkan judul buku">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Penulis <span class="text-rose-500">*</span></label>
                        <input type="text" name="penulis" value="{{ old('penulis') }}" required
                            class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent"
                            placeholder="Nama penulis">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Penerbit <span class="text-rose-500">*</span></label>
                        <input type="text" name="penerbit" value="{{ old('penerbit') }}" required
                            class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent"
                            placeholder="Nama penerbit">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">ISBN <span class="text-rose-500">*</span></label>
                        <input type="text" name="isbn" value="{{ old('isbn') }}" required
                            class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent"
                            placeholder="978-xxx-xxx-xxx-x">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Tahun Terbit <span class="text-rose-500">*</span></label>
                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', date('Y')) }}" required
                            min="1900" max="{{ date('Y') }}"
                            class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori <span class="text-rose-500">*</span></label>
                        <select name="kategori_id" required
                            class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500">
                            <option value="">Pilih kategori</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Jumlah Buku <span class="text-rose-500">*</span></label>
                        <input type="number" name="jumlah_total" value="{{ old('jumlah_total', 1) }}" required min="1"
                            class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Lokasi Rak</label>
                        <input type="text" name="lokasi_rak" value="{{ old('lokasi_rak') }}"
                            class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent"
                            placeholder="Contoh: A-01">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Cover Buku</label>
                        <div class="border-2 border-dashed border-slate-200 rounded-lg p-6 text-center hover:border-sky-300 transition-colors cursor-pointer"
                            onclick="document.getElementById('cover').click()">
                            <i data-lucide="image-plus" class="w-8 h-8 mx-auto text-slate-300 mb-2"></i>
                            <p class="text-sm text-slate-500">Klik untuk upload cover</p>
                            <p class="text-xs text-slate-400 mt-1">PNG, JPG — maks. 2MB</p>
                            <input type="file" id="cover" name="cover" accept="image/*" class="hidden"
                                onchange="previewCover(this)">
                        </div>
                        <img id="cover-preview" src="" class="hidden mt-3 h-32 rounded-lg object-cover border border-slate-200">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                    <a href="{{ route('admin.buku.index') }}"
                        class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="btn-primary flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-colors">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Simpan Buku
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewCover(input) {
            const preview = document.getElementById('cover-preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</x-admin-layout>