<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PesertaMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Gunakan guard default (web) karena login menggunakan User model
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Opsional: Cek apakah user memiliki hak akses peserta
        // Misalnya: if (Auth::user()->role !== 'mahasiswa' && Auth::user()->role !== 'peserta') ...
        // Untuk saat ini kita pastikan login saja dulu untuk mengatasi loop logout

        return $next($request);
    }
}
