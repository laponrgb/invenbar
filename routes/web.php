<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SumberDanaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DataSiswaController;
use App\Http\Controllers\DataGuruController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('lokasi', LokasiController::class);
    Route::resource('sumberdana', SumberDanaController::class);

    Route::get('/barang/laporan', [BarangController::class, 'cetakLaporan'])
        ->name('barang.laporan');

    Route::resource('barang', BarangController::class);

    Route::resource('peminjaman', PeminjamanController::class);
    Route::patch('peminjaman/{peminjaman}/return', [PeminjamanController::class, 'return'])->name('peminjaman.return');
    Route::get('peminjaman/{peminjaman}/extend', [PeminjamanController::class, 'extendForm'])->name('peminjaman.extend.form');
    Route::patch('peminjaman/{peminjaman}/extend', [PeminjamanController::class, 'extend'])->name('peminjaman.extend');

    Route::get('data-siswa/import', [DataSiswaController::class, 'importForm'])->name('data-siswa.import.form');
    Route::post('data-siswa/import', [DataSiswaController::class, 'import'])->name('data-siswa.import');
    Route::post('data-siswa/bulk-delete', [DataSiswaController::class, 'bulkDelete'])->name('data-siswa.bulk-delete');
    Route::resource('data-siswa', DataSiswaController::class);
    
    Route::get('data-guru/import', [DataGuruController::class, 'importForm'])->name('data-guru.import.form');
    Route::post('data-guru/import', [DataGuruController::class, 'import'])->name('data-guru.import');
    Route::post('data-guru/bulk-delete', [DataGuruController::class, 'bulkDelete'])->name('data-guru.bulk-delete');
    Route::resource('data-guru', DataGuruController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
