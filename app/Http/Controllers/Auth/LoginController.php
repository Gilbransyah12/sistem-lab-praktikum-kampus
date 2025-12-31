<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string', // Can be username, email, or NIM
            'password' => 'required|string',
        ]);

        $loginField = $credentials['login'];
        $password = $credentials['password'];

        // Try to find user by username, email, or NIM
        $fieldType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 
                     (is_numeric($loginField) ? 'nim' : 'username');

        $attempt = Auth::attempt([
            $fieldType => $loginField,
            'password' => $password,
        ]);

        if ($attempt) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirect based on role
            return match($user->role) {
                'admin' => redirect()->intended('/admin/dashboard'),
                'instruktur' => redirect()->intended('/instruktur/dashboard'),
                'mahasiswa' => redirect()->intended('/mahasiswa/dashboard'),
                default => redirect('/'),
            };
        }

        return back()->withErrors([
            'login' => 'Email/NIM/Username atau password salah.',
        ])->onlyInput('login');
    }

    /**
     * Show mahasiswa login form (alternative route)
     */
    public function showMahasiswaLoginForm()
    {
        return view('auth.mahasiswa-login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

