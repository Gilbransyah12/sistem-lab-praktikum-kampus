@extends('layouts.auth')

@section('title', 'Registrasi Mahasiswa')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">
            <i class="fas fa-user-graduate"></i>
        </div>
        <h1>Daftar Akun <span style="color: #0d9488;">Mahasiswa</span></h1>
        <p>Silakan isi data diri untuk membuat akun</p>
    </div>

    <div class="auth-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <ul style="margin: 0; padding-left: 1rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-group">
                <div class="input-group">
                    <i class="fas fa-id-card"></i>
                    <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" 
                           value="{{ old('nim') }}" placeholder="NIM" required autofocus>
                    <label class="floating-label">NIM <span class="required">*</span></label>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                           value="{{ old('nama') }}" placeholder="Nama Lengkap" required>
                    <label class="floating-label">Nama Lengkap <span class="required">*</span></label>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" placeholder="Email" required>
                    <label class="floating-label">Email <span class="required">*</span></label>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Password" required>
                    <label class="floating-label">Password <span class="required">*</span></label>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password_confirmation" class="form-control" 
                           placeholder="Konfirmasi Password" required>
                    <label class="floating-label">Konfirmasi Password <span class="required">*</span></label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-user-plus"></i>
                <span>Daftar Sekarang</span>
            </button>
        </form>

        <div class="auth-divider">
            <span>Sudah punya akun?</span>
        </div>

        <a href="{{ route('login') }}" class="btn btn-secondary">
            <i class="fas fa-sign-in-alt"></i>
            <span>Masuk ke Akun</span>
        </a>
    </div>

    <div class="auth-footer">
        <p>Sistem Informasi Lab Praktikum &copy; {{ date('Y') }} <strong>UMPAR</strong></p>
    </div>
</div>
@endsection

@push('styles')
<style>
.required {
    color: #ef4444;
}

.auth-divider {
    text-align: center;
    margin: 1.5rem 0;
    position: relative;
}

.auth-divider::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    width: 100%;
    height: 1px;
    background: #e2e8f0;
}

.auth-divider span {
    background: white;
    padding: 0 1rem;
    position: relative;
    color: #64748b;
    font-size: 0.875rem;
}

.btn-secondary {
    width: 100%;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
}

.btn-secondary:hover {
    background: #e2e8f0;
}
</style>
@endpush
