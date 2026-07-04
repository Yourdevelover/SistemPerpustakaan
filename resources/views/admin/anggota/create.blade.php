<x-admin-layout title="Tambah Anggota" subtitle="Daftarkan anggota baru perpustakaan">
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-slate-200 p-6">
        @if($errors->any())
            <div class="mb-5 flex gap-2 px-4 py-3 bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-lg">
                <i data-lucide="circle-alert" class="w-4 h-4 mt-0.5 shrink-0"></i>
                <ul class="space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form method="POST" action="{{ route('admin.anggota.store') }}" class="space-y-5">
            @csrf
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Informasi Akun</p>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                        class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Username <span class="text-rose-500">*</span></label>
                    <input type="text" name="username" value="{{ old('username') }}" required
                        class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Email <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Password <span class="text-rose-500">*</span></label>
                    <input type="password" name="password" required
                        class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
            </div>

            <div class="border-t border-slate-100 pt-4">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-4">Informasi Anggota</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Jenis Anggota <span class="text-rose-500">*</span></label>
                        <select name="jenis_anggota" required
                            class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500">
                            <option value="">Pilih jenis</option>
                            <option value="siswa" {{ old('jenis_anggota') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="guru" {{ old('jenis_anggota') == 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="kepala_sekolah" {{ old('jenis_anggota') == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Kelas</label>
                        <input type="text" name="kelas" value="{{ old('kelas') }}" placeholder="Contoh: XII RPL 1"
                            class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Telepon</label>
                        <input type="text" name="telepon" value="{{ old('telepon') }}"
                            class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat</label>
                        <input type="text" name="alamat" value="{{ old('alamat') }}"
                            class="input-field w-full px-3 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                <a href="{{ route('admin.anggota.index') }}"
                    class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit"
                    class="btn-primary flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-colors">
                    <i data-lucide="user-plus" class="w-4 h-4"></i> Tambah Anggota
                </button>
            </div>
        </form>
    </div>
</div>
</x-admin-layout>