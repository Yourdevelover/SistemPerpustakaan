<?php if (isset($component)) { $__componentOriginal259af620ba24bc8031c58cecf0a656e6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal259af620ba24bc8031c58cecf0a656e6 = $attributes; } ?>
<?php $component = App\View\Components\MemberLayout::resolve(['title' => 'Dashboard','subtitle' => 'Selamat datang, '.e(optional(Auth::user())->nama_lengkap ?? 'Demo').'!'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('member-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\MemberLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

<?php $tab = request('tab', 'home'); ?>


<?php if($tab === 'home'): ?>

    
    <div class="mb-6 bg-gradient-to-r from-sky-600 to-sky-700 rounded-xl p-5 text-white flex items-center justify-between">
        <div>
            <p class="text-sky-100 text-xs font-medium mb-1">Halo, selamat datang!</p>
            <h2 class="text-lg font-bold"><?php echo e(optional(Auth::user())->nama_lengkap ?? 'Demo User'); ?></h2>
            <p class="text-sky-200 text-xs mt-0.5">
                <?php echo e($anggota->nomor_anggota); ?> · <?php echo e(ucfirst($anggota->jenis_anggota)); ?>

                <?php if($anggota->kelas): ?> · <?php echo e($anggota->kelas); ?> <?php endif; ?>
            </p>
        </div>
        <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center text-white text-xl font-bold">
            <?php echo e(strtoupper(substr(optional(Auth::user())->nama_lengkap ?? 'DU', 0, 2))); ?>

        </div>
    </div>

    
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Total Pinjam</p>
                <div class="w-8 h-8 bg-sky-50 rounded-lg flex items-center justify-center">
                    <i data-lucide="book" class="w-4 h-4 text-sky-600"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-900"><?php echo e($totalPinjam); ?></p>
            <p class="text-xs text-slate-400 mt-1">Sepanjang waktu</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Sedang Dipinjam</p>
                <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center">
                    <i data-lucide="arrow-left-right" class="w-4 h-4 text-amber-600"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-900"><?php echo e($sedangDipinjam); ?></p>
            <p class="text-xs text-slate-400 mt-1">Buku aktif</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Terlambat</p>
                <div class="w-8 h-8 bg-rose-50 rounded-lg flex items-center justify-center">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-rose-500"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-900"><?php echo e($terlambat); ?></p>
            <p class="text-xs text-slate-400 mt-1">Melewati jatuh tempo</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Denda</p>
                <div class="w-8 h-8 bg-rose-50 rounded-lg flex items-center justify-center">
                    <i data-lucide="receipt" class="w-4 h-4 text-rose-500"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-900">Rp <?php echo e(number_format($dendaBelumLunas, 0, ',', '.')); ?></p>
            <p class="text-xs text-slate-400 mt-1">Belum lunas</p>
        </div>
    </div>

    
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

        
        <div class="xl:col-span-2 bg-white rounded-xl border border-slate-200">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-900">Buku yang Sedang Dipinjam</h2>
                <a href="?tab=aktif" class="text-xs text-sky-600 hover:text-sky-700 font-medium flex items-center gap-1">
                    Lihat semua <i data-lucide="arrow-right" class="w-3 h-3"></i>
                </a>
            </div>
            <div class="divide-y divide-slate-50">
                <?php $__empty_1 = true; $__currentLoopData = $peminjamanAktif->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $buku = optional($item->detailPeminjamans->first())->buku;
                        $isLate = \Carbon\Carbon::now()->startOfDay()->gt(\Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->startOfDay());
                        $hariSisa = \Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->startOfDay(), false);
                    ?>
                    <div class="px-5 py-4 flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-sky-50 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="book-open" class="w-5 h-5 text-sky-600"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-900 truncate"><?php echo e(optional($buku)->judul ?? '-'); ?></p>
                            <p class="text-xs text-slate-400 mt-0.5"><?php echo e(optional($buku)->penulis ?? ''); ?></p>
                            <p class="text-xs mt-1">
                                <?php if($isLate): ?>
                                    <span class="text-rose-500 font-medium">Terlambat <?php echo e(abs($hariSisa)); ?> hari</span>
                                <?php elseif($hariSisa <= 2): ?>
                                    <span class="text-amber-500 font-medium">Jatuh tempo <?php echo e($hariSisa == 0 ? 'hari ini' : "dalam $hariSisa hari"); ?></span>
                                <?php else: ?>
                                    <span class="text-slate-400">Jatuh tempo <?php echo e(\Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y')); ?></span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <?php if($isLate): ?>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 font-medium flex-shrink-0">Terlambat</span>
                        <?php else: ?>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 font-medium flex-shrink-0">Dipinjam</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="px-5 py-12 text-center">
                        <i data-lucide="check-circle" class="w-8 h-8 mx-auto text-green-300 mb-2"></i>
                        <p class="text-slate-400 text-sm">Tidak ada buku yang sedang dipinjam</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="space-y-4">
            
            <?php if($dendas->count() > 0): ?>
            <div class="bg-white rounded-xl border border-rose-200 p-5">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-7 h-7 bg-rose-50 rounded-lg flex items-center justify-center">
                        <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-500"></i>
                    </div>
                    <h3 class="text-sm font-semibold text-rose-700">Tagihan Denda</h3>
                </div>
                <div class="space-y-2">
                    <?php $__currentLoopData = $dendas->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-600 truncate max-w-[140px]"><?php echo e(optional(optional($item->detailPeminjamans->first())->buku)->judul ?? 'Buku'); ?></span>
                            <span class="font-semibold text-rose-600">Rp <?php echo e(number_format(optional($item->denda)->jumlah_denda, 0, ',', '.')); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <a href="?tab=denda" class="mt-3 block text-center text-xs font-semibold text-rose-600 hover:text-rose-700">
                    Lihat semua denda →
                </a>
            </div>
            <?php endif; ?>

            
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <h3 class="text-sm font-semibold text-slate-900 mb-3">Info Keanggotaan</h3>
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500">No. Anggota</span>
                        <span class="font-semibold text-slate-900"><?php echo e($anggota->nomor_anggota); ?></span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500">Jenis</span>
                        <span class="font-semibold text-slate-900"><?php echo e(ucfirst($anggota->jenis_anggota)); ?></span>
                    </div>
                    <?php if($anggota->kelas): ?>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500">Kelas</span>
                        <span class="font-semibold text-slate-900"><?php echo e($anggota->kelas); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500">Status</span>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium <?php echo e($anggota->status === 'aktif' ? 'bg-green-50 text-green-700' : 'bg-rose-50 text-rose-600'); ?>">
                            <?php echo e(ucfirst($anggota->status)); ?>

                        </span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500">Terdaftar</span>
                        <span class="font-semibold text-slate-900"><?php echo e(\Carbon\Carbon::parse($anggota->tanggal_daftar)->format('d M Y')); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php elseif($tab === 'pinjam'): ?>

    <div class="mb-5 flex items-center gap-3">
        <form method="GET" action="<?php echo e(route('member.dashboard')); ?>" class="flex gap-2 flex-1 max-w-md">
            <input type="hidden" name="tab" value="pinjam">
            <div class="relative flex-1">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                <input type="text" name="cari" value="<?php echo e(request('cari')); ?>" placeholder="Cari judul atau penulis..."
                    class="w-full pl-9 pr-4 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white text-slate-900">
            </div>
            <button type="submit" class="px-4 py-2 bg-sky-600 text-white text-sm font-semibold rounded-lg hover:bg-sky-700 transition-colors">
                Cari
            </button>
        </form>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-4 flex items-center gap-2 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg">
            <i data-lucide="circle-check" class="w-4 h-4 shrink-0"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="mb-4 flex items-center gap-2 px-4 py-3 bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-lg">
            <i data-lucide="circle-alert" class="w-4 h-4 shrink-0"></i> <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
        <?php $__empty_1 = true; $__currentLoopData = $bukuTersedia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $buku): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-xl border border-slate-200 p-5 flex flex-col gap-3">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-lg bg-sky-50 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="book-open" class="w-5 h-5 text-sky-600"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-900 line-clamp-2 leading-snug"><?php echo e($buku->judul); ?></p>
                    <p class="text-xs text-slate-400 mt-0.5"><?php echo e($buku->penulis); ?></p>
                </div>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <span class="text-xs px-2 py-0.5 bg-slate-100 text-slate-600 rounded-full"><?php echo e(optional($buku->kategori)->nama_kategori ?? '-'); ?></span>
                <span class="text-xs px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-full font-medium"><?php echo e($buku->jumlah_tersedia); ?> tersedia</span>
            </div>
            <div class="text-xs text-slate-400 space-y-0.5">
                <p>Penerbit: <?php echo e($buku->penerbit); ?></p>
                <p>Tahun: <?php echo e($buku->tahun_terbit); ?></p>
                <?php if($buku->lokasi_rak): ?>
                    <p>Rak: <?php echo e($buku->lokasi_rak); ?></p>
                <?php endif; ?>
            </div>
            
            <div class="pt-1 border-t border-slate-100">
                <p class="text-xs text-slate-400 text-center leading-relaxed">
                    <i data-lucide="info" class="w-3 h-3 inline mb-0.5"></i>
                    Untuk meminjam, hubungi petugas perpustakaan dengan menyebutkan buku ini.
                </p>
                <div class="mt-2 text-center">
                    <span class="text-xs font-semibold text-sky-600 bg-sky-50 px-3 py-1.5 rounded-lg inline-block">
                        ISBN: <?php echo e($buku->isbn); ?>

                    </span>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-3 py-16 text-center">
                <i data-lucide="book-x" class="w-10 h-10 mx-auto text-slate-300 mb-3"></i>
                <p class="text-slate-500 font-medium">Tidak ada buku yang tersedia</p>
            </div>
        <?php endif; ?>
    </div>

    <?php if($bukuTersedia->hasPages()): ?>
        <div class="mt-5"><?php echo e($bukuTersedia->appends(['tab' => 'pinjam', 'cari' => request('cari')])->links('pagination::tailwind')); ?></div>
    <?php endif; ?>


<?php elseif($tab === 'aktif'): ?>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-slate-900">Buku yang Sedang Dipinjam</h2>
            <span class="text-xs bg-amber-50 text-amber-700 font-medium px-2.5 py-0.5 rounded-full"><?php echo e($peminjamanAktif->count()); ?> aktif</span>
        </div>
        <div class="divide-y divide-slate-50">
            <?php $__empty_1 = true; $__currentLoopData = $peminjamanAktif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $buku = optional($item->detailPeminjamans->first())->buku;
                    $isLate = \Carbon\Carbon::now()->startOfDay()->gt(\Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->startOfDay());
                    $hariSisa = \Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->startOfDay(), false);
                ?>
                <div class="px-5 py-4">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-sky-50 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="book-open" class="w-5 h-5 text-sky-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <p class="text-sm font-semibold text-slate-900"><?php echo e(optional($buku)->judul ?? '-'); ?></p>
                                    <p class="text-xs text-slate-400 mt-0.5"><?php echo e(optional($buku)->penulis ?? ''); ?></p>
                                </div>
                                <?php if($isLate): ?>
                                    <span class="flex-shrink-0 text-xs px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 font-medium">Terlambat</span>
                                <?php else: ?>
                                    <span class="flex-shrink-0 text-xs px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 font-medium">Dipinjam</span>
                                <?php endif; ?>
                            </div>
                            <div class="mt-2 grid grid-cols-2 gap-x-4 gap-y-1 text-xs text-slate-500">
                                <span>Tgl Pinjam: <strong class="text-slate-700"><?php echo e(\Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y')); ?></strong></span>
                                <span>Jatuh Tempo:
                                    <strong class="<?php echo e($isLate ? 'text-rose-600' : 'text-slate-700'); ?>">
                                        <?php echo e(\Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y')); ?>

                                    </strong>
                                </span>
                            </div>
                            <?php if($isLate): ?>
                                <p class="mt-1.5 text-xs text-rose-500 font-medium">
                                    ⚠ Terlambat <?php echo e(abs($hariSisa)); ?> hari · Denda estimasi Rp <?php echo e(number_format(abs($hariSisa) * 1000, 0, ',', '.')); ?>

                                </p>
                            <?php elseif($hariSisa <= 2): ?>
                                <p class="mt-1.5 text-xs text-amber-500 font-medium">
                                    ⏰ Segera kembalikan — <?php echo e($hariSisa == 0 ? 'jatuh tempo hari ini!' : "sisa $hariSisa hari"); ?>

                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-5 py-16 text-center">
                    <i data-lucide="check-circle" class="w-10 h-10 mx-auto text-green-300 mb-3"></i>
                    <p class="text-slate-500 font-medium">Tidak ada buku yang sedang dipinjam</p>
                </div>
            <?php endif; ?>
        </div>
    </div>


<?php elseif($tab === 'riwayat'): ?>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100">
            <h2 class="text-sm font-semibold text-slate-900">Riwayat Peminjaman</h2>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Buku</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Tgl Pinjam</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Tgl Kembali</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Denda</th>
                    <th class="text-left text-xs font-semibold text-slate-500 px-5 py-3 uppercase tracking-wide">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php $__empty_1 = true; $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-4">
                            <p class="font-semibold text-slate-900"><?php echo e(optional(optional($item->detailPeminjamans->first())->buku)->judul ?? '-'); ?></p>
                            <p class="text-xs text-slate-400"><?php echo e(optional(optional($item->detailPeminjamans->first())->buku)->penulis ?? ''); ?></p>
                        </td>
                        <td class="px-5 py-4 text-slate-600"><?php echo e(\Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y')); ?></td>
                        <td class="px-5 py-4 text-slate-600"><?php echo e($item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') : '-'); ?></td>
                        <td class="px-5 py-4">
                            <?php if($item->denda): ?>
                                <span class="text-sm font-semibold <?php echo e($item->denda->status_bayar === 'lunas' ? 'text-slate-400 line-through' : 'text-rose-600'); ?>">
                                    Rp <?php echo e(number_format($item->denda->jumlah_denda, 0, ',', '.')); ?>

                                </span>
                            <?php else: ?>
                                <span class="text-slate-400">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                <i data-lucide="check" class="w-3 h-3"></i> Dikembalikan
                            </span>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-5 py-16 text-center">
                            <i data-lucide="history" class="w-10 h-10 mx-auto text-slate-300 mb-3"></i>
                            <p class="text-slate-500 font-medium">Belum ada riwayat peminjaman</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if($riwayat->hasPages()): ?>
            <div class="px-5 py-3 border-t border-slate-100"><?php echo e($riwayat->appends(['tab' => 'riwayat'])->links('pagination::tailwind')); ?></div>
        <?php endif; ?>
    </div>


<?php elseif($tab === 'denda'): ?>

    <?php if($dendaBelumLunas > 0): ?>
        <div class="mb-4 flex items-center gap-3 px-4 py-3 bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-lg">
            <i data-lucide="alert-triangle" class="w-4 h-4 shrink-0"></i>
            <span>Kamu memiliki total denda <strong>Rp <?php echo e(number_format($dendaBelumLunas, 0, ',', '.')); ?></strong> yang belum lunas. Segera hubungi petugas perpustakaan.</span>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100">
            <h2 class="text-sm font-semibold text-slate-900">Denda Saya</h2>
        </div>
        <div class="divide-y divide-slate-50">
            <?php $__empty_1 = true; $__currentLoopData = $dendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="px-5 py-4 flex items-start gap-4">
                    <div class="w-10 h-10 rounded-lg bg-rose-50 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="receipt" class="w-5 h-5 text-rose-500"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="text-sm font-semibold text-slate-900"><?php echo e(optional(optional($item->detailPeminjamans->first())->buku)->judul ?? 'Buku'); ?></p>
                                <p class="text-xs text-slate-400 mt-0.5">Peminjaman #<?php echo e($item->id); ?> · Jatuh tempo <?php echo e(\Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y')); ?></p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-rose-600">Rp <?php echo e(number_format(optional($item->denda)->jumlah_denda, 0, ',', '.')); ?></p>
                                <span class="text-xs px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 font-medium">Belum Lunas</span>
                            </div>
                        </div>
                        <div class="mt-2 p-3 bg-amber-50 rounded-lg text-xs text-amber-700 flex items-start gap-2">
                            <i data-lucide="info" class="w-3.5 h-3.5 mt-0.5 shrink-0"></i>
                            Bayar denda langsung ke petugas perpustakaan dengan menunjukkan nomor peminjaman di atas.
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-5 py-16 text-center">
                    <i data-lucide="check-circle" class="w-10 h-10 mx-auto text-green-300 mb-3"></i>
                    <p class="text-slate-500 font-medium">Tidak ada denda — kamu tertib!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php endif; ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal259af620ba24bc8031c58cecf0a656e6)): ?>
<?php $attributes = $__attributesOriginal259af620ba24bc8031c58cecf0a656e6; ?>
<?php unset($__attributesOriginal259af620ba24bc8031c58cecf0a656e6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal259af620ba24bc8031c58cecf0a656e6)): ?>
<?php $component = $__componentOriginal259af620ba24bc8031c58cecf0a656e6; ?>
<?php unset($__componentOriginal259af620ba24bc8031c58cecf0a656e6); ?>
<?php endif; ?><?php /**PATH C:\Users\xeean\Documents\Develover\sistem-perpustakaan\resources\views/member/dashboard.blade.php ENDPATH**/ ?>