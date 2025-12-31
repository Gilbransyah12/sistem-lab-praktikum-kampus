<?php

use App\Http\Controllers\Mahasiswa;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Mahasiswa Routes
|--------------------------------------------------------------------------
| Routes untuk dashboard mahasiswa
| Prefix: /mahasiswa
| Middleware: auth, mahasiswa
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [Mahasiswa\DashboardController::class, 'index'])->name('dashboard');

// Pendaftaran Praktikum
Route::get('/pendaftaran', [Mahasiswa\PendaftaranController::class, 'index'])->name('pendaftaran.index');
Route::get('/pendaftaran/create', [Mahasiswa\PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [Mahasiswa\PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::get('/pendaftaran/{pendaftaran}', [Mahasiswa\PendaftaranController::class, 'show'])->name('pendaftaran.show');

// Jadwal (hanya untuk yang sudah jadi peserta)
Route::get('/jadwal/export-pdf', [Mahasiswa\JadwalController::class, 'exportPdf'])->name('jadwal.export-pdf');
Route::get('/jadwal', [Mahasiswa\JadwalController::class, 'index'])->name('jadwal.index');
Route::get('/jadwal/{jadwal}', [Mahasiswa\JadwalController::class, 'show'])->name('jadwal.show');

// Modul Download
Route::get('/modul/{modul}/download', [Mahasiswa\ModulController::class, 'download'])->name('modul.download');

// Kartu Kontrol
Route::get('/kartu-kontrol', [Mahasiswa\KartuKontrolController::class, 'index'])->name('kartu-kontrol.index');
Route::get('/kartu-kontrol/{pendaftaran}/{jadwal?}', [Mahasiswa\KartuKontrolController::class, 'show'])->name('kartu-kontrol.show');
Route::get('/kartu-kontrol/{pendaftaran}/{jadwal}/pdf', [Mahasiswa\KartuKontrolController::class, 'exportPdf'])->name('kartu-kontrol.pdf');

// Sertifikat
Route::get('/sertifikat', [Mahasiswa\DashboardController::class, 'sertifikat'])->name('sertifikat.index');
