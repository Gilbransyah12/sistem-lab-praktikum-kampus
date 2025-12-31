@extends('layouts.mahasiswa')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="dashboard-container">
    {{-- Welcome Card --}}
    <div class="welcome-card">
        <div class="welcome-content">
            <div class="welcome-text">
                <h1>Selamat Datang, {{ Auth::user()->nama }}! 👋</h1>
                <p>Selamat datang di Panel Mahasiswa Lab Praktikum UMPAR. Kelola pendaftaran dan jadwal praktikum Anda dengan mudah.</p>
                <div class="welcome-actions">
                    @if(!$is_peserta)
                        <a href="{{ route('mahasiswa.pendaftaran.create') }}" class="btn-welcome primary">
                            <i class="fas fa-plus-circle"></i> Daftar Praktikum
                        </a>
                    @else
                        <a href="{{ route('mahasiswa.jadwal.index') }}" class="btn-welcome secondary">
                            <i class="fas fa-calendar-alt"></i> Lihat Jadwal
                        </a>
                    @endif
                </div>
            </div>
            <div class="welcome-illustration">
                <i class="fas fa-microscope"></i>
            </div>
        </div>
        <div class="card-pattern"></div>
    </div>

    {{-- Stats Grid --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon-wrapper teal">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $total_pendaftaran }}</div>
                <div class="stat-label">Total Pendaftaran</div>
            </div>
            <div class="stat-chart">
                <!-- Mini chart decoration -->
                <svg viewBox="0 0 100 40" class="mini-chart">
                    <path d="M0 35 Q 25 10 50 25 T 100 15" fill="none" stroke="#2dd4bf" stroke-width="3" />
                </svg>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon-wrapper green">
                <i class="fas fa-check-double"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $pendaftaran_diterima }}</div>
                <div class="stat-label">Pendaftaran Diterima</div>
            </div>
            <div class="stat-chart">
                 <svg viewBox="0 0 100 40" class="mini-chart">
                    <path d="M0 30 Q 30 35 60 10 T 100 5" fill="none" stroke="#4ade80" stroke-width="3" />
                </svg>
            </div>
        </div>

        <div class="stat-card">
             <div class="stat-icon-wrapper orange">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $is_peserta ? 'Aktif' : 'Non-Aktif' }}</div>
                <div class="stat-label">Status Peserta</div>
            </div>
        </div>
    </div>

    {{-- Jadwal Section --}}
    @if(isset($jadwal_saya) && $jadwal_saya->count() > 0)
    <div class="section-container" style="margin-bottom: 2rem;">
        <div class="section-header">
            <h3 class="section-title">
                <i class="fas fa-calendar-alt"></i> Jadwal Praktikum Saya
            </h3>
        </div>
        
        <div class="premium-card">
            <div class="table-responsive">
                <table class="table table-hover" style="margin: 0;">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th style="padding: 1rem 1.5rem;">Mata Kuliah / Praktikum</th>
                            <th>Waktu</th>
                            <th>Ruangan</th>
                            <th>Instruktur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwal_saya as $j)
                        <tr>
                            <td style="padding: 1rem 1.5rem;">
                                <div style="font-weight: 700; color: #0f766e;">{{ $j->mata_kuliah }}</div>
                                <div style="font-size: 0.85em; color: #64748b;">{{ $j->praktikum->nama_praktikum }} (Praktikum {{ $j->praktikum->praktikum_ke }})</div>
                                <span class="badge badge-info" style="font-size: 0.75em; background: #e0f2fe; color: #0284c7; padding: 2px 6px; border-radius: 4px;">Kelas {{ $j->kelas->nama_kelas }}</span>
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $j->hari }}</div>
                                <div style="font-size: 0.85em; color: #64748b;">{{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}</div>
                            </td>
                            <td>{{ $j->ruangan->nama_ruangan }}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <div style="width: 24px; height: 24px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7em;">
                                        {{ substr($j->instruktur->nama ?? 'U', 0, 1) }}
                                    </div>
                                    {{ $j->instruktur->nama }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Recent Pendaftaran --}}
    <div class="section-container">
        <div class="section-header">
            <h3 class="section-title">
                <i class="fas fa-history"></i> Riwayat Pendaftaran
            </h3>
            <a href="{{ route('mahasiswa.pendaftaran.index') }}" class="view-all-link">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="premium-card">
            @if($pendaftaran_terbaru->count() > 0)
                <div class="premium-list">
                    @foreach($pendaftaran_terbaru as $p)
                        <div class="list-item">
                            <div class="item-icon {{ $p->status }}">
                                <i class="fas fa-flask"></i>
                            </div>
                            <div class="item-content">
                                <div class="item-title">{{ $p->item_title ?? $p->praktikum->nama_praktikum ?? 'Praktikum' }}</div>
                                <div class="item-subtitle">
                                    <span class="meta-badge"><i class="fas fa-layer-group"></i> {{ $p->kelas->nama_kelas ?? '-' }}</span>
                                    <span class="meta-text"><i class="far fa-calendar"></i> {{ $p->tanggal_daftar?->format('d M Y') }}</span>
                                </div>
                            </div>
                            <div class="item-status">
                                @if($p->status === 'diterima')
                                    <span class="status-badge success"><i class="fas fa-check"></i> Diterima</span>
                                @elseif($p->status === 'ditolak')
                                    <span class="status-badge danger"><i class="fas fa-times"></i> Ditolak</span>
                                @else
                                    <span class="status-badge warning"><i class="fas fa-clock"></i> Pending</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state-premium">
                    <div class="empty-icon-wrapper">
                        <i class="fas fa-clipboard"></i>
                    </div>
                    <h4>Belum Ada Pendaftaran</h4>
                    <p>Anda belum mendaftar praktikum apapun saat ini.</p>
                    <a href="{{ route('mahasiswa.pendaftaran.create') }}" class="btn-action-primary">
                        <i class="fas fa-plus"></i> Daftar Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* =====================================================
   MAHASISWA DASHBOARD - PREMIUM TEAL THEME
   ===================================================== */

.dashboard-container {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

/* Welcome Card */
.welcome-card {
    background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
    border-radius: 20px;
    padding: 2.5rem;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(15, 118, 110, 0.2);
}

.card-pattern {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-image: radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 20%),
                      radial-gradient(circle at 90% 80%, rgba(255,255,255,0.05) 0%, transparent 20%);
    pointer-events: none;
}

.welcome-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    z-index: 1;
}

.welcome-text h1 {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 0.75rem;
    line-height: 1.2;
}

.welcome-text p {
    font-size: 1rem;
    opacity: 0.9;
    max-width: 600px;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.welcome-actions {
    display: flex;
    gap: 1rem;
}

.btn-welcome {
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9375rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s;
}

.btn-welcome.primary {
    background: white;
    color: #0f766e;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.btn-welcome.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.15);
}

.btn-welcome.secondary {
    background: rgba(255, 255, 255, 0.15);
    color: white;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
}

.btn-welcome.secondary:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
}

.welcome-illustration i {
    font-size: 6rem;
    color: rgba(255, 255, 255, 0.15);
    transform: rotate(-15deg);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    border: 1px solid #f1f5f9;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
}

.stat-icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.stat-icon-wrapper.teal { background: #f0fdfa; color: #0d9488; }
.stat-icon-wrapper.green { background: #dcfce7; color: #16a34a; }
.stat-icon-wrapper.orange { background: #ffedd5; color: #ea580c; }

.stat-info {
    flex: 1;
    z-index: 1;
}

.stat-value {
    font-size: 1.875rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.2;
}

.stat-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #64748b;
    margin-top: 0.25rem;
}

.stat-chart {
    position: absolute;
    bottom: 1rem;
    right: 1rem;
    width: 80px;
    opacity: 0.5;
}

/* Recent Section */
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.25rem;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-title i {
    color: #0f766e;
}

.view-all-link {
    font-size: 0.875rem;
    font-weight: 600;
    color: #0d9488;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.view-all-link:hover {
    color: #0f766e;
    gap: 0.75rem;
}

/* Premium Card & List */
.premium-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    overflow: hidden;
}

.premium-list {
    display: flex;
    flex-direction: column;
}

.list-item {
    display: flex;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.2s;
    gap: 1.25rem;
}

.list-item:hover {
    background: #f8fafc;
}

.list-item:last-child {
    border-bottom: none;
}

.item-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.item-icon.diterima { background: #dcfce7; color: #16a34a; }
.item-icon.ditolak { background: #fee2e2; color: #dc2626; }
.item-icon.pending { background: #fef3c7; color: #d97706; }
.item-icon { background: #f1f5f9; color: #64748b; } /* Default */

.item-content {
    flex: 1;
}

.item-title {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.item-subtitle {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.meta-badge {
    background: #e0f2fe;
    color: #0284c7;
    padding: 0.15rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.meta-text {
    font-size: 0.8125rem;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.status-badge {
    padding: 0.35rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.status-badge.success { background: #dcfce7; color: #16a34a; }
.status-badge.danger { background: #fee2e2; color: #dc2626; }
.status-badge.warning { background: #fef3c7; color: #d97706; }

/* Empty State Premium */
.empty-state-premium {
    padding: 4rem 2rem;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.empty-icon-wrapper {
    width: 80px;
    height: 80px;
    background: #f1f5f9;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: #94a3b8;
    margin-bottom: 1.5rem;
}

.empty-state-premium h4 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.empty-state-premium p {
    color: #64748b;
    max-width: 400px;
    margin-bottom: 2rem;
}

.btn-action-primary {
    background: #0f766e;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
    box-shadow: 0 4px 10px rgba(15, 118, 110, 0.2);
}

.btn-action-primary:hover {
    background: #0d9488;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(15, 118, 110, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .welcome-card {
        padding: 1.5rem;
    }

    .welcome-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .welcome-actions {
        display: none;
    }
    
    .welcome-text h1 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .welcome-text p {
        margin: 0;
        font-size: 0.9rem;
    }
    
    .list-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .item-icon {
        display: none;
    }
    
    .item-status {
        align-self: flex-start;
    }

    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
}

/* Table Responsive - Horizontal Scroll */
.table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    margin: 0;
}

.table-responsive table {
    min-width: 600px;
}

.table-responsive th,
.table-responsive td {
    white-space: nowrap;
}

@media (max-width: 768px) {
    .table-responsive {
        border-radius: 8px;
    }
    
    .table-responsive table th,
    .table-responsive table td {
        padding: 0.75rem 1rem !important;
        font-size: 0.875rem;
    }
}
</style>
@endpush
