<?php

use App\Http\Controllers\Instruktur;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Instruktur Routes
|--------------------------------------------------------------------------
| Routes untuk dashboard instruktur
| Prefix: /instruktur
| Middleware: auth, instruktur
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [Instruktur\DashboardController::class, 'index'])->name('dashboard');

// Absensi
Route::get('/absensi', [Instruktur\AbsensiController::class, 'index'])->name('absensi.index');
Route::get('/absensi/jadwal/{jadwal}', [Instruktur\AbsensiController::class, 'sesi'])->name('absensi.sesi');
Route::get('/absensi/jadwal/{jadwal}/create', [Instruktur\AbsensiController::class, 'createSesi'])->name('absensi.create-sesi');
Route::post('/absensi/jadwal/{jadwal}/store', [Instruktur\AbsensiController::class, 'storeSesi'])->name('absensi.store-sesi');
Route::get('/absensi/sesi/{sesi}/absen', [Instruktur\AbsensiController::class, 'absen'])->name('absensi.absen');
Route::post('/absensi/sesi/{sesi}/absen', [Instruktur\AbsensiController::class, 'storeAbsen'])->name('absensi.store-absen');
Route::get('/absensi/jadwal/{jadwal}/statistik', [Instruktur\AbsensiController::class, 'statistik'])->name('absensi.statistik');

// Nilai
Route::get('/nilai', [Instruktur\NilaiController::class, 'index'])->name('nilai.index');
Route::get('/nilai/jadwal/{jadwal}', [Instruktur\NilaiController::class, 'show'])->name('nilai.show');
Route::get('/nilai/jadwal/{jadwal}/edit', [Instruktur\NilaiController::class, 'edit'])->name('nilai.edit');
Route::put('/nilai/jadwal/{jadwal}', [Instruktur\NilaiController::class, 'update'])->name('nilai.update');

// Modul
Route::get('/modul', [Instruktur\ModulController::class, 'index'])->name('modul.index');
Route::get('/modul/jadwal/{jadwal}', [Instruktur\ModulController::class, 'show'])->name('modul.show');
Route::get('/modul/jadwal/{jadwal}/create', [Instruktur\ModulController::class, 'create'])->name('modul.create');
Route::post('/modul/jadwal/{jadwal}', [Instruktur\ModulController::class, 'store'])->name('modul.store');
Route::get('/modul/{modul}/download', [Instruktur\ModulController::class, 'download'])->name('modul.download');
Route::delete('/modul/{modul}', [Instruktur\ModulController::class, 'destroy'])->name('modul.destroy');
