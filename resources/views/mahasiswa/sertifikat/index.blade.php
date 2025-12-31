@extends('layouts.mahasiswa')

@section('title', 'Sertifikat Saya')

@section('breadcrumb')
    <span>/</span>
    <span>Sertifikat</span>
@endsection

@section('content')
<div class="sertifikat-container">
    <div class="empty-state-card">
        <div class="empty-icon">
            <i class="fas fa-certificate"></i>
        </div>
        <h2 class="empty-title">Belum Ada Sertifikat</h2>
        <p class="empty-description">
            Anda belum memiliki sertifikat praktikum saat ini.<br>
            Selesaikan semua praktikum untuk mendapatkan sertifikat.
        </p>
        <a href="{{ route('mahasiswa.jadwal.index') }}" class="btn-back-home">
            <i class="fas fa-calendar-alt"></i>
            Lihat Jadwal Praktikum
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
.sertifikat-container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 60vh;
    padding: 2rem;
}

.empty-state-card {
    background: white;
    border-radius: 20px;
    padding: 3rem 2rem;
    text-align: center;
    max-width: 420px;
    width: 100%;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
}

.empty-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: #0d9488;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
}

.empty-description {
    font-size: 0.9375rem;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 2rem;
}

.btn-back-home {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
    color: white;
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9375rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-back-home:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(13, 148, 136, 0.3);
}

@media (max-width: 480px) {
    .empty-state-card {
        padding: 2rem 1.5rem;
    }
    
    .empty-icon {
        width: 80px;
        height: 80px;
        font-size: 2rem;
    }
    
    .empty-title {
        font-size: 1.25rem;
    }
}
</style>
@endpush
