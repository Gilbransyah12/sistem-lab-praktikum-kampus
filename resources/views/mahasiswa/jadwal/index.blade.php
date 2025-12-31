@extends('layouts.mahasiswa')

@section('title', 'Jadwal Praktikum')

@section('breadcrumb')
    <span>/</span>
    <span>Jadwal</span>
@endsection

@section('content')
{{-- Page Header --}}
<div class="page-header">
    <div class="header-content">
        <div class="header-info">
            <h2 class="header-title">
                <i class="fas fa-calendar-alt"></i>
                Jadwal Praktikum
            </h2>
            <p class="header-subtitle">Lihat jadwal praktikum yang sudah terdaftar</p>
        </div>
        <div class="header-stats" style="display: flex; align-items: center; gap: 0.75rem;">
            <a href="{{ route('mahasiswa.jadwal.export-pdf') }}" class="btn btn-danger" style="background: #ef4444; border: none; color: white; padding: 0.625rem 1rem; border-radius: 9999px; font-weight: 600; font-size: 0.875rem; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.3);">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <div class="stat-badge">
                <i class="fas fa-book-open"></i>
                <span>{{ $jadwal->count() }} Praktikum</span>
            </div>
        </div>
    </div>
</div>

{{-- Jadwal Grid --}}
@if($jadwal->count() > 0)
<div class="jadwal-grid">
    @foreach($jadwal as $j)
    <div class="jadwal-card">
        <div class="jadwal-header">
            <div class="jadwal-icon">
                <i class="fas fa-flask"></i>
            </div>
            <div class="jadwal-badge">
                <i class="fas fa-check-circle"></i>
                Aktif
            </div>
        </div>
        
        <div class="jadwal-body">
            <h3 class="jadwal-title">{{ $j->praktikum->nama_praktikum ?? '-' }}</h3>
            <p class="jadwal-kelas">
                {{ $j->kelas->nama_kelas ?? '-' }}
                <span style="color: #cbd5e1; margin: 0 0.5rem;">|</span>
                <span style="color: #0f766e; font-weight: 700;">{{ $j->mata_kuliah ?? '-' }}</span>
            </p>
            
            <div class="jadwal-info">
                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <span>{{ $j->hari }}, {{ $j->jam_mulai }} - {{ $j->jam_selesai }}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-door-open"></i>
                    <span>{{ $j->ruangan->nama_ruangan ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-user-tie"></i>
                    <span>{{ $j->instruktur->nama ?? '-' }}</span>
                </div>
            </div>
        </div>
        
        <div class="jadwal-footer">
            <a href="{{ route('mahasiswa.jadwal.show', $j) }}" class="btn btn-primary btn-block">
                <i class="fas fa-eye"></i>
                Lihat Detail
            </a>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state-card">
    <div class="empty-icon">
        <i class="fas fa-calendar-times"></i>
    </div>
    <h3>Belum Ada Jadwal</h3>
    <p>Anda belum memiliki jadwal praktikum. Daftar praktikum terlebih dahulu untuk mendapatkan jadwal.</p>
    <a href="{{ route('mahasiswa.pendaftaran.index') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Daftar Praktikum
    </a>
</div>
@endif
@endsection

@push('styles')
<style>
/* =====================================================
   JADWAL INDEX STYLES
   ===================================================== */

/* Page Header */
.page-header {
    margin-bottom: 1.5rem;
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: white;
    padding: 1.5rem;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.header-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.375rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.25rem;
}

.header-title i {
    color: #0d9488;
}

.header-subtitle {
    color: #64748b;
    font-size: 0.875rem;
}

.stat-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
    border: 1px solid rgba(13, 148, 136, 0.2);
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 600;
    color: #0d9488;
}

/* Jadwal Grid */
.jadwal-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
}

/* Jadwal Card */
.jadwal-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.jadwal-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(13, 148, 136, 0.15);
    border-color: rgba(13, 148, 136, 0.2);
}

.jadwal-header {
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.jadwal-icon {
    width: 48px;
    height: 48px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.jadwal-badge {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    color: white;
}

.jadwal-body {
    padding: 1.5rem;
}

.jadwal-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.25rem;
}

.jadwal-kelas {
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 1.25rem;
}

.jadwal-info {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.875rem;
    color: #475569;
}

.info-item i {
    width: 16px;
    color: #0d9488;
}

.jadwal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #f1f5f9;
}

/* Button */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-size: 0.9375rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.btn-block {
    width: 100%;
}

.btn-primary {
    background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(13, 148, 136, 0.3);
}

.btn-primary:hover {
    box-shadow: 0 6px 20px rgba(13, 148, 136, 0.4);
    transform: translateY(-2px);
}

/* Empty State */
.empty-state-card {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.empty-icon i {
    font-size: 2.5rem;
    color: #0d9488;
}

.empty-state-card h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.5rem;
}

.empty-state-card p {
    color: #64748b;
    max-width: 400px;
    margin: 0 auto 1.5rem;
    line-height: 1.6;
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .jadwal-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush
