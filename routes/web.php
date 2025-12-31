<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\InstrukturMiddleware;
use App\Http\Middleware\MahasiswaMiddleware;
use App\Http\Middleware\PesertaMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Main route file - includes role-specific routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public Verification Route
Route::get('/verifikasi/sertifikat/{kode}', [App\Http\Controllers\VerifikasiController::class, 'check'])->name('verifikasi.check');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Registration (Mahasiswa only)
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes (from routes/admin.php)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(base_path('routes/admin.php'));

/*
|--------------------------------------------------------------------------
| Instruktur Routes (from routes/instruktur.php)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', InstrukturMiddleware::class])
    ->prefix('instruktur')
    ->name('instruktur.')
    ->group(base_path('routes/instruktur.php'));

/*
|--------------------------------------------------------------------------
| Mahasiswa Routes (from routes/mahasiswa.php)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', MahasiswaMiddleware::class])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(base_path('routes/mahasiswa.php'));

/*
|--------------------------------------------------------------------------
| Peserta Routes (from routes/peserta.php)
|--------------------------------------------------------------------------
*/
// Route::middleware(['auth', PesertaMiddleware::class])
//    ->prefix('peserta')
//    ->name('peserta.')
//    ->group(base_path('routes/peserta.php'));

