<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Routes untuk dashboard admin
| Prefix: /admin
| Middleware: auth, admin
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

// Master Data
Route::get('/peserta/export', [Admin\PesertaController::class, 'export'])->name('peserta.export');
Route::get('/peserta/export-pdf', [Admin\PesertaController::class, 'exportPdf'])->name('peserta.export-pdf');
Route::get('/peserta/print-kartu-kontrol', [Admin\PesertaController::class, 'printAllKartuKontrol'])->name('peserta.print-kartu-kontrol');
Route::get('/peserta/{pendaftaran}/kartu-kontrol/{jadwal?}', [Admin\PesertaController::class, 'kartuKontrol'])->name('peserta.kartu-kontrol');
Route::resource('peserta', Admin\PesertaController::class);
Route::resource('instruktur', Admin\InstrukturController::class);
Route::resource('praktikum', Admin\PraktikumController::class);
Route::resource('kelas', Admin\KelasController::class);
Route::resource('ruangan', Admin\RuanganController::class);

// Akademik
Route::resource('periode', Admin\PeriodeController::class);
Route::get('/jadwal/export-pdf', [Admin\JadwalController::class, 'exportPdf'])->name('jadwal.export-pdf');
Route::resource('jadwal', Admin\JadwalController::class);

// Pendaftaran
Route::get('/pendaftaran', [Admin\PendaftaranController::class, 'index'])->name('pendaftaran.index');
Route::get('/pendaftaran/{pendaftaran}', [Admin\PendaftaranController::class, 'show'])->name('pendaftaran.show');
Route::patch('/pendaftaran/{pendaftaran}/status', [Admin\PendaftaranController::class, 'updateStatus'])->name('pendaftaran.status');
Route::delete('/pendaftaran/{pendaftaran}', [Admin\PendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');

// Absensi & Laporan
Route::get('/absensi', [Admin\AbsensiController::class, 'index'])->name('absensi.index');
Route::get('/absensi/sesi/{sesi}', [Admin\AbsensiController::class, 'show'])->name('absensi.show');
Route::get('/absensi/laporan', [Admin\AbsensiController::class, 'laporan'])->name('absensi.laporan');
Route::get('/absensi/export', [Admin\AbsensiController::class, 'export'])->name('absensi.export');
Route::get('/absensi/pdf', [Admin\AbsensiController::class, 'pdf'])->name('absensi.pdf');
