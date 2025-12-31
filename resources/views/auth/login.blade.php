@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">
            <i class="fas fa-flask"></i>
        </div>
        <h1>Lab<span style="color: #0d9488;">UMPAR</span></h1>
        <p>Silakan login untuk melanjutkan</p>
    </div>

    <div class="auth-body">
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

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">

                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="login" class="form-control" 
                           value="{{ old('login') }}" placeholder="Email / NIM / Username" required autofocus>
                    <label class="floating-label">Email / NIM / Username</label>
                </div>
            </div>

            <div class="form-group">

                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control" 
                           placeholder="Password" required>
                    <label class="floating-label">Password</label>
                </div>
            </div>

            <div class="form-check">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Ingat saya di perangkat ini</label>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i>
                <span>Masuk Sekarang</span>
            </button>
        </form>

        <div class="auth-divider">
            <span>Belum punya akun?</span>
        </div>

        <a href="{{ route('register') }}" class="btn btn-secondary">
            <i class="fas fa-user-plus"></i>
            <span>Daftar Akun Mahasiswa</span>
        </a>
    </div>

    <div class="auth-footer">
        <p>Sistem Informasi Lab Praktikum &copy; {{ date('Y') }} <strong>UMPAR</strong></p>
    </div>
</div>
@endsection

@push('styles')
<style>
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
    background: white;
    color: #0d9488;
    border: 2px solid #0d9488;
    font-weight: 600;
}

.btn-secondary:hover {
    background: #0d9488;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13, 148, 136, 0.2);
}
</style>
@endpush
