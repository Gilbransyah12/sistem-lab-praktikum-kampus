@extends('layouts.instruktur')

@section('title', 'Dashboard')

@section('content')
{{-- Welcome Section --}}
<div class="welcome-section">
    <div class="welcome-card">
        <div class="welcome-content">
            <div class="welcome-text">
                <h2>Selamat Datang, {{ Auth::user()->name ?? 'Instruktur' }}! 👋</h2>
                <p>Kelola praktikum, absensi, dan nilai mahasiswa dari dashboard ini.</p>
            </div>
            <div class="welcome-illustration">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
        </div>
    </div>
</div>

{{-- Stats Cards --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $jadwal_aktif ?? 0 }}</h3>
            <p>Jadwal Aktif</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon success">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $total_peserta ?? 0 }}</h3>
            <p>Total Peserta</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon warning">
            <i class="fas fa-clipboard-check"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $jadwal->sum(fn($j) => $j->sesi->count() ?? 0) }}</h3>
            <p>Sesi Pertemuan</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon info">
            <i class="fas fa-star"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $jadwal->count() }}</h3>
            <p>Praktikum Diampu</p>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="quick-actions">
    <h3 class="section-title">
        <i class="fas fa-bolt"></i>
        Aksi Cepat
    </h3>
    <div class="actions-grid">
        <a href="{{ route('instruktur.absensi.index') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <span>Input Absensi</span>
        </a>
        <a href="{{ route('instruktur.nilai.index') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-star"></i>
            </div>
            <span>Input Nilai</span>
        </a>
        <a href="{{ route('instruktur.absensi.index') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-calendar-plus"></i>
            </div>
            <span>Buat Sesi Baru</span>
        </a>
        <a href="{{ route('instruktur.modul.index') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <span>Upload Modul</span>
        </a>
    </div>
</div>

{{-- My Classes --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-chalkboard"></i>
            Kelas yang Diampu
        </h3>
    </div>
    <div class="card-body">
        @if($jadwal->count() > 0)
        <div class="jadwal-grid">
            @foreach($jadwal as $j)
            <div class="jadwal-item">
                <div class="jadwal-icon">
                    <i class="fas fa-flask"></i>
                </div>
                <div class="jadwal-content">
                    <h4>{{ $j->praktikum->nama_praktikum ?? '-' }} / <span style="font-weight: 500; font-size: 0.9em; color: #64748b;">{{ $j->mata_kuliah ?? '-' }}</span></h4>
                    <div class="jadwal-meta">
                        <span><i class="fas fa-layer-group"></i> {{ $j->kelas->nama_kelas ?? '-' }} - {{ $j->mata_kuliah ?? '-' }}</span>
                        <span><i class="fas fa-clock"></i> {{ $j->hari }}, {{ $j->jam_mulai }} - {{ $j->jam_selesai }}</span>
                        <span><i class="fas fa-door-open"></i> {{ $j->ruangan->nama_ruangan ?? '-' }}</span>
                    </div>
                </div>
                <div class="jadwal-actions">
                    <a href="{{ route('instruktur.absensi.sesi', $j) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-clipboard-check"></i>
                        Absensi
                    </a>
                    <a href="{{ route('instruktur.nilai.show', $j) }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-star"></i>
                        Nilai
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p>Belum ada jadwal praktikum yang diampu</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
/* =====================================================
   INSTRUKTUR DASHBOARD STYLES - CYAN THEME
   ===================================================== */

/* Welcome Section */
.welcome-section {
    margin-bottom: 1.5rem;
}

.welcome-card {
    background: linear-gradient(135deg, #0891b2 0%, #06b6d4 50%, #22d3ee 100%);
    border-radius: 16px;
    padding: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(6, 182, 212, 0.3);
}

.welcome-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.welcome-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    z-index: 1;
}

.welcome-text h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.welcome-text p {
    font-size: 0.9375rem;
    opacity: 0.9;
    max-width: 400px;
}

.welcome-illustration {
    font-size: 4rem;
    opacity: 0.8;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(6, 182, 212, 0.15);
    border-color: rgba(6, 182, 212, 0.2);
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.375rem;
}

.stat-icon.primary {
    background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
    color: white;
    box-shadow: 0 8px 20px rgba(6, 182, 212, 0.3);
}

.stat-icon.success {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    color: white;
    box-shadow: 0 8px 20px rgba(5, 150, 105, 0.3);
}

.stat-icon.warning {
    background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
    color: white;
    box-shadow: 0 8px 20px rgba(217, 119, 6, 0.3);
}

.stat-icon.info {
    background: linear-gradient(135deg, #0284c7 0%, #0ea5e9 100%);
    color: white;
    box-shadow: 0 8px 20px rgba(2, 132, 199, 0.3);
}

.stat-info h3 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #0f172a;
    line-height: 1;
    margin-bottom: 0.25rem;
}

.stat-info p {
    font-size: 0.8125rem;
    color: #64748b;
    font-weight: 500;
}

/* Quick Actions */
.quick-actions {
    margin-bottom: 1.5rem;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.125rem;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 1rem;
}

.section-title i {
    color: #f59e0b;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.action-card {
    background: white;
    border-radius: 12px;
    padding: 1.25rem;
    text-align: center;
    text-decoration: none;
    color: #0f172a;
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    transition: all 0.3s ease;
}

.action-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(6, 182, 212, 0.15);
    border-color: rgba(6, 182, 212, 0.3);
}

.action-card:hover .action-icon {
    background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
    color: white;
}

.action-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #ecfeff 0%, #cffafe 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: #0891b2;
    margin: 0 auto 0.75rem;
    transition: all 0.3s ease;
}

.action-card span {
    font-size: 0.875rem;
    font-weight: 500;
}

/* Card */
.card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f1f5f9;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
}

.card-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
    color: #0f172a;
}

.card-title i {
    color: #0891b2;
}

.card-body {
    padding: 1.5rem;
}

/* Jadwal Grid */
.jadwal-grid {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.jadwal-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
}

.jadwal-item:hover {
    border-color: rgba(6, 182, 212, 0.3);
    box-shadow: 0 4px 12px rgba(6, 182, 212, 0.1);
}

.jadwal-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.jadwal-content {
    flex: 1;
}

.jadwal-content h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 0.5rem;
}

.jadwal-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    font-size: 0.8125rem;
    color: #64748b;
}

.jadwal-meta span {
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.jadwal-meta i {
    color: #94a3b8;
}

.jadwal-actions {
    display: flex;
    gap: 0.5rem;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.btn-sm {
    padding: 0.5rem 0.75rem;
}

.btn-primary {
    background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(6, 182, 212, 0.3);
}

.btn-primary:hover {
    box-shadow: 0 6px 20px rgba(6, 182, 212, 0.4);
}

.btn-secondary {
    background: white;
    color: #475569;
    border: 1px solid #e2e8f0;
}

.btn-secondary:hover {
    background: #f1f5f9;
    border-color: #0891b2;
    color: #0891b2;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 2rem;
    color: #94a3b8;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 0.75rem;
    display: block;
}

/* Responsive */
@media (max-width: 768px) {
    .welcome-content {
        flex-direction: column;
        text-align: center;
    }
    
    .jadwal-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .jadwal-actions {
        width: 100%;
        padding-top: 0.75rem;
        border-top: 1px solid #e2e8f0;
    }
    
    .jadwal-actions .btn {
        flex: 1;
        justify-content: center;
    }
}
</style>
@endpush
