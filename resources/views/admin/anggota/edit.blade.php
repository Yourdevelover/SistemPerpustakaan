<x-admin-layout title="Edit Anggota" subtitle="Perbarui data anggota perpustakaan">
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-slate-200 p-6">
        @if($errors->any())
            <div class="mb-5 flex gap-2 px-4 py-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg">
                <i data-lucide="circle-alert" class="w-4 h-4 mt-0.5 shrink-0"></i>
                <ul class="space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form method="POST" action="{{ route('admin.anggota.update', $anggota) }}" class="space-y-5">
            @csrf @method('PUT')

            {{-- Info readonly --}}
            <div class="bg-slate-50 rounded-lg px-4 py-3 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold flex-shrink-0">
                    {{ strtoupper(substr($anggota->user->nama_lengkap ?? '?', 0, 2)) }}
                </div>
                <div>
                    <p class="font-semibold text-slate-900 text-sm">{{ $anggota->user->nama_lengkap }}</p>
                    <p class="text-xs text-slate-400">{{ $anggota->nomor_anggota }} · {{ $anggota->user->email }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Jenis Anggota</label>
                    <select name="jenis_anggota" required
                        class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                        <option value="siswa" {{ $anggota->jenis_anggota == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="guru" {{ $anggota->jenis_anggota == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="kepala_sekolah" {{ $anggota->jenis_anggota == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Status</label>
                    <select name="status" required
                        class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                        <option value="aktif" {{ $anggota->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ $anggota->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Kelas</label>
                    <input type="text" name="kelas" value="{{ old('kelas', $anggota->kelas) }}"
                        class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $anggota->telepon) }}"
                        class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat', $anggota->alamat) }}"
                        class="w-full px-3 py-2.5 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                <a href="{{ route('admin.anggota.index') }}"
                    class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit"
                    class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
</x-admin-layout>