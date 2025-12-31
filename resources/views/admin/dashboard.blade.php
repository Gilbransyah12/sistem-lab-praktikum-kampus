@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
{{-- Welcome Section --}}
<div class="welcome-section">
    <div class="welcome-card">
        <div class="welcome-content">
            <div class="welcome-text">
                <h2>Selamat Datang, Administrator! 👋</h2>
                <p>Pantau aktivitas laboratorium, kelola data master, dan verifikasi pendaftaran praktikum.</p>
            </div>
            <div class="welcome-illustration">
                <i class="fas fa-layer-group"></i>
            </div>
        </div>
    </div>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $total_peserta ?? 0 }}</h3>
            <p>Total Peserta</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon success">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $total_instruktur ?? 0 }}</h3>
            <p>Total Instruktur</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon warning">
            <i class="fas fa-book"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $total_praktikum ?? 0 }}</h3>
            <p>Total Praktikum</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon info">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $total_pendaftaran ?? 0 }}</h3>
            <p>Total Pendaftaran</p>
        </div>
    </div>
</div>

{{-- Recent Registrations --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-clock"></i>
            Pendaftaran Terbaru
        </h3>
        <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-sm btn-nav">
            Lihat Semua <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Peserta</th>
                        <th>Praktikum</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftaran_terbaru ?? [] as $p)
                    <tr>
                        <td>
                            <div class="date-badge">
                                <i class="far fa-calendar-alt"></i>
                                {{ $p->tanggal_daftar->format('d/m/Y') }}
                            </div>
                        </td>
                        <td>
                            <div class="user-info">
                                <div class="avatar-circle">{{ substr($p->peserta->nama ?? 'U', 0, 1) }}</div>
                                <div>
                                    <span class="user-name">{{ $p->peserta->nama ?? '-' }}</span>
                                    <span class="user-sub">{{ $p->peserta->nim ?? '-' }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="praktikum-name">{{ $p->praktikum->nama_praktikum ?? '-' }}</span>
                        </td>
                        <td>
                            @switch($p->status)
                                @case('pending')
                                    <span class="status-badge pending">
                                        <i class="fas fa-clock"></i> Pending
                                    </span>
                                    @break
                                @case('diterima')
                                    <span class="status-badge success">
                                        <i class="fas fa-check-circle"></i> Diterima
                                    </span>
                                    @break
                                @case('ditolak')
                                    <span class="status-badge danger">
                                        <i class="fas fa-times-circle"></i> Ditolak
                                    </span>
                                    @break
                            @endswitch
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <p>Belum ada pendaftaran terbaru</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* =====================================================
   ADMIN DASHBOARD STYLES - PREMIUM CYAN THEME
   ===================================================== */

/* Welcome Section */
.welcome-section {
    margin-bottom: 2rem;
}

.welcome-card {
    background: linear-gradient(135deg, #0f766e 0%, #14b8a6 50%, #2dd4bf 100%);
    border-radius: 20px;
    padding: 2.5rem;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 30px -10px rgba(20, 184, 166, 0.5);
}

.welcome-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);
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
    font-size: 1.75rem;
    font-weight: 800;
    margin-bottom: 0.75rem;
    letter-spacing: -0.025em;
}

.welcome-text p {
    font-size: 1rem;
    opacity: 0.95;
    max-width: 500px;
    line-height: 1.6;
}

.welcome-illustration {
    font-size: 3.5rem;
    background: rgba(255, 255, 255, 0.2);
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 20px;
    backdrop-filter: blur(10px);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.75rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    border: 1px solid rgba(226, 232, 240, 0.8);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.1);
    border-color: #99f6e4;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.stat-icon.primary { background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%); color: white; box-shadow: 0 8px 16px -4px rgba(20, 184, 166, 0.4); }
.stat-icon.success { background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; box-shadow: 0 8px 16px -4px rgba(16, 185, 129, 0.4); }
.stat-icon.warning { background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%); color: white; box-shadow: 0 8px 16px -4px rgba(245, 158, 11, 0.4); }
.stat-icon.info { background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: white; box-shadow: 0 8px 16px -4px rgba(99, 102, 241, 0.4); }

.stat-info h3 {
    font-size: 2rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
    margin-bottom: 0.25rem;
    letter-spacing: -0.05em;
}

.stat-info p {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 600;
}

/* Card Styles */
.card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    border: 1px solid #f1f5f9;
    overflow: hidden;
}

.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #f1f5f9;
    background: white;
}

.card-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-title i {
    color: #0f766e;
    background: #f0fdfa;
    padding: 8px;
    border-radius: 8px;
    font-size: 1rem;
}

.card-body {
    padding: 0;
}

.btn-nav {
    color: #0f766e;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    background: #f0fdfa;
    transition: all 0.2s;
    font-size: 0.875rem;
}

.btn-nav:hover {
    background: #ccfbf1;
    transform: translateX(2px);
}

/* Premium Table */
.table-container {
    overflow-x: auto;
}

.premium-table {
    width: 100%;
    border-collapse: collapse;
}

.premium-table th {
    background: #f8fafc;
    padding: 1rem 2rem;
    text-align: left;
    font-weight: 600;
    color: #64748b;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid #e2e8f0;
}

.premium-table td {
    padding: 1.25rem 2rem;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.premium-table tr:last-child td {
    border-bottom: none;
}

.premium-table tr:hover {
    background: #fcfcfc;
}

/* Table Elements */
.date-badge {
    font-size: 0.875rem;
    font-weight: 500;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.user-info {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    justify-content: flex-start !important;
    gap: 1rem;
}

.avatar-circle {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: #475569;
    font-size: 1rem;
}

.user-name {
    display: block;
    font-weight: 600;
    color: #334155;
    font-size: 0.9375rem;
}

.user-sub {
    display: block;
    font-size: 0.75rem;
    color: #94a3b8;
}

.praktikum-name {
    font-weight: 500;
    color: #475569;
    background: #f1f5f9;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.875rem;
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem 1rem;
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.status-badge.pending { background: #fff7ed; color: #c2410c; border: 1px solid #ffedd5; }
.status-badge.success { background: #ecfdf5; color: #047857; border: 1px solid #d1fae5; }
.status-badge.danger { background: #fef2f2; color: #b91c1c; border: 1px solid #fee2e2; }

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem !important;
}

.empty-icon {
    font-size: 3rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
}

.empty-state p {
    color: #94a3b8;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 768px) {
    .welcome-content {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .card-header {
        padding: 1rem;
    }
    
    .premium-table td, .premium-table th {
        padding: 1rem;
    }
}
</style>
@endpush
