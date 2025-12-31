@extends('layouts.mahasiswa')

@section('title', 'Pendaftaran Praktikum')

@section('breadcrumb')
    <span>/</span>
    <span>Pendaftaran</span>
@endsection

@section('content')
{{-- Page Header --}}
<div class="page-header">
    <div class="header-content">
        <div class="header-info">
            <h2 class="header-title">
                <i class="fas fa-file-alt"></i>
                Pendaftaran Praktikum
            </h2>
            <p class="header-subtitle">Kelola pendaftaran praktikum Anda</p>
        </div>
        <a href="{{ route('mahasiswa.pendaftaran.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Daftar Baru
        </a>
    </div>
</div>

{{-- Stats Cards --}}
<div class="stats-row">
    <div class="mini-stat">
        <div class="mini-stat-icon total">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="mini-stat-info">
            <span class="mini-stat-value">{{ $pendaftaran->total() }}</span>
            <span class="mini-stat-label">Total</span>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon success">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="mini-stat-info">
            <span class="mini-stat-value">{{ $pendaftaran->where('status', 'diterima')->count() }}</span>
            <span class="mini-stat-label">Diterima</span>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon warning">
            <i class="fas fa-clock"></i>
        </div>
        <div class="mini-stat-info">
            <span class="mini-stat-value">{{ $pendaftaran->where('status', 'pending')->count() }}</span>
            <span class="mini-stat-label">Pending</span>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon danger">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="mini-stat-info">
            <span class="mini-stat-value">{{ $pendaftaran->where('status', 'ditolak')->count() }}</span>
            <span class="mini-stat-label">Ditolak</span>
        </div>
    </div>
</div>

{{-- Pendaftaran List --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-list"></i>
            Daftar Pendaftaran
        </h3>
    </div>
    <div class="card-body">
        @if($pendaftaran->count() > 0)
        <div class="pendaftaran-list">
            @foreach($pendaftaran as $p)
            <div class="pendaftaran-item">
                <div class="pendaftaran-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="pendaftaran-content">
                    <div class="pendaftaran-main">
                        <h4 class="pendaftaran-title">{{ $p->praktikum->nama_praktikum ?? '-' }}</h4>
                        <div class="pendaftaran-meta">
                            <span><i class="fas fa-layer-group"></i> {{ $p->kelas->nama_kelas ?? '-' }}</span>
                            <span><i class="fas fa-calendar"></i> {{ $p->periode->nama_periode ?? '-' }}</span>
                            <span><i class="fas fa-clock"></i> {{ $p->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="pendaftaran-actions">
                        @switch($p->status)
                            @case('pending')
                                <span class="badge badge-warning">
                                    <i class="fas fa-hourglass-half"></i> Pending
                                </span>
                                @break
                            @case('diterima')
                                <span class="badge badge-success">
                                    <i class="fas fa-check"></i> Diterima
                                </span>
                                @break
                            @case('ditolak')
                                <span class="badge badge-danger">
                                    <i class="fas fa-times"></i> Ditolak
                                </span>
                                @break
                        @endswitch
                        <a href="{{ route('mahasiswa.pendaftaran.show', $p) }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-eye"></i>
                            Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- Pagination --}}
        <div class="pagination-wrapper">
            {{ $pendaftaran->links() }}
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h4>Belum Ada Pendaftaran</h4>
            <p>Anda belum mendaftar praktikum apapun.</p>
            <a href="{{ route('mahasiswa.pendaftaran.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Daftar Sekarang
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
/* =====================================================
   PENDAFTARAN PAGE STYLES
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

/* Stats Row */
.stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.mini-stat {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: white;
    padding: 1rem 1.25rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.mini-stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
}

.mini-stat-icon.total {
    background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%);
    color: white;
}

.mini-stat-icon.success {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    color: white;
}

.mini-stat-icon.warning {
    background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
    color: white;
}

.mini-stat-icon.danger {
    background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
    color: white;
}

.mini-stat-info {
    display: flex;
    flex-direction: column;
}

.mini-stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #0f172a;
    line-height: 1;
}

.mini-stat-label {
    font-size: 0.75rem;
    color: #64748b;
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
    color: #0d9488;
}

.card-body {
    padding: 1.5rem;
}

/* Pendaftaran List */
.pendaftaran-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.pendaftaran-item {
    display: flex;
    gap: 1rem;
    padding: 1.25rem;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
}

.pendaftaran-item:hover {
    border-color: rgba(13, 148, 136, 0.3);
    box-shadow: 0 4px 12px rgba(13, 148, 136, 0.1);
}

.pendaftaran-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.pendaftaran-content {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}

.pendaftaran-title {
    font-size: 1rem;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 0.5rem;
}

.pendaftaran-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    font-size: 0.8125rem;
    color: #64748b;
}

.pendaftaran-meta span {
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.pendaftaran-meta i {
    color: #94a3b8;
}

.pendaftaran-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-shrink: 0;
}

/* Badge */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 0.875rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-success {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.badge-warning {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.badge-danger {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

/* Button */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.btn-sm {
    padding: 0.5rem 0.875rem;
    font-size: 0.8125rem;
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

.btn-secondary {
    background: white;
    color: #475569;
    border: 1px solid #e2e8f0;
}

.btn-secondary:hover {
    background: #f1f5f9;
    border-color: #0d9488;
    color: #0d9488;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem;
}

.empty-state i {
    font-size: 4rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
}

.empty-state h4 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #64748b;
    margin-bottom: 1.5rem;
}

/* Pagination */
.pagination-wrapper {
    margin-top: 1.5rem;
    display: flex;
    justify-content: center;
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .stats-row {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .pendaftaran-item {
        flex-direction: column;
    }
    
    .pendaftaran-content {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .pendaftaran-actions {
        width: 100%;
        justify-content: flex-start;
        padding-top: 0.75rem;
        border-top: 1px solid #e2e8f0;
    }
}

@media (max-width: 480px) {
    .stats-row {
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }
    
    .mini-stat {
        padding: 0.875rem;
    }
    
    .mini-stat-value {
        font-size: 1.25rem;
    }
}
</style>
@endpush
