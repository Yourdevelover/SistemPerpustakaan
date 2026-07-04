<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\PengembalianController;
use App\Http\Controllers\Admin\DendaController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Member\DashboardController as MemberDashboard;

Route::get('/', function () {
    return redirect()->route('member.dashboard');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Koleksi
    Route::resource('buku', BukuController::class);
    Route::resource('kategori', KategoriController::class);

    // Sirkulasi
    Route::resource('peminjaman', PeminjamanController::class);
    Route::resource('pengembalian', PengembalianController::class)->only(['index', 'store']);
    Route::resource('denda', DendaController::class)->only(['index', 'show', 'edit', 'update']);

    Route::resource('anggota', AnggotaController::class)->parameters([
        'anggota' => 'anggota',
    ]);

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/ekspor', [LaporanController::class, 'ekspor'])->name('laporan.ekspor');
});

Route::prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [MemberDashboard::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';