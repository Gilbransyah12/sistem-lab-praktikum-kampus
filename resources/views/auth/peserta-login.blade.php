@extends('layouts.auth')

@section('title', 'Login Peserta')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">
            <i class="fas fa-flask"></i>
        </div>
        <h1>Lab<span style="color: #0d9488;">UMPAR</span></h1>
        <p>Login dengan NIM Anda untuk mengakses</p>
    </div>

    <div class="auth-body">
        <div class="tabs">
            <a href="{{ route('login') }}" class="tab">
                <i class="fas fa-user-shield" style="margin-right: 0.375rem;"></i>Admin/Instruktur
            </a>
            <a href="{{ route('peserta.login') }}" class="tab active">
                <i class="fas fa-user-graduate" style="margin-right: 0.375rem;"></i>Peserta
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('peserta.login') }}">
            @csrf
            
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-id-card" style="margin-right: 0.375rem; color: #0d9488;"></i>Nomor Induk Mahasiswa (NIM)
                </label>
                <div class="input-group">
                    <input type="text" name="nim" class="form-control" 
                           value="{{ old('nim') }}" placeholder="Contoh: 2021001234" required autofocus>
                    <i class="fas fa-id-card"></i>
                </div>
            </div>

            <!-- Info Box -->
            <div style="background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%); border: 1px solid #99f6e4; border-radius: 0.75rem; padding: 1rem; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
                    <i class="fas fa-info-circle" style="color: #0d9488; margin-top: 0.125rem;"></i>
                    <div style="font-size: 0.8125rem; color: #0f766e; line-height: 1.5;">
                        <strong>Informasi Penting:</strong><br>
                        Masukkan NIM Anda yang sudah terdaftar di sistem praktikum untuk masuk ke dashboard peserta.
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i>
                <span>Masuk sebagai Peserta</span>
            </button>
        </form>
    </div>

    <div class="auth-footer">
        <p>Sistem Informasi Lab Praktikum &copy; {{ date('Y') }} <strong>UMPAR</strong></p>
    </div>
</div>
@endsection
