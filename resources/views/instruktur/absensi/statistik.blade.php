@extends('layouts.instruktur')

@section('title', 'Statistik Absensi')

@section('content')
{{-- Page Header --}}
<div class="page-header">
    <div class="header-content">
        <div class="header-left">
            <a href="{{ route('instruktur.absensi.sesi', $jadwal) }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="header-info">
                <h2 class="header-title">Statistik Kehadiran</h2>
                <div class="header-meta">
                    <span class="meta-item">
                        <i class="fas fa-flask"></i> {{ $jadwal->praktikum->nama_praktikum }}
                    </span>
                    <span class="meta-separator">•</span>
                    <span class="meta-item">
                        <i class="fas fa-user-friends"></i> {{ $jadwal->kelas->nama_kelas }}
                    </span>
                    <span class="meta-separator">•</span>
                    <span class="meta-item">
                        <i class="fas fa-calendar-check"></i> Total {{ $totalSessions }} Sesi
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="35%">Mahasiswa</th>
                    <th width="10%" class="text-center">Hadir</th>
                    <th width="10%" class="text-center">Izin</th>
                    <th width="10%" class="text-center">Sakit</th>
                    <th width="10%" class="text-center">Alfa</th>
                    <th width="20%">Persentase</th>
                </tr>
            </thead>
            <tbody>
                @forelse($statistik as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="stats-user-info">
                            <div class="stats-user-avatar">
                                <span>{{ substr($s['student']->peserta->user->nama, 0, 1) }}</span>
                            </div>
                            <div class="stats-user-details">
                                <span class="stats-user-name">{{ $s['student']->peserta->user->nama }}</span>
                                <span class="stats-user-nim">{{ $s['student']->peserta->user->nim }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-success">{{ $s['hadir'] }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-warning">{{ $s['izin'] }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-info">{{ $s['sakit'] }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-danger">{{ $s['alfa'] }}</span>
                    </td>
                    <td>
                        <div class="progress-wrapper">
                            <div class="progress-info">
                                <span class="progress-percentage">{{ $s['percentage'] }}%</span>
                                <span class="progress-status">
                                    @if($s['percentage'] <= 20)
                                        <i class="fas fa-exclamation-circle text-danger"></i>
                                    @elseif($s['percentage'] <= 40)
                                        <i class="fas fa-exclamation-triangle text-warning"></i>
                                    @elseif($s['percentage'] <= 80)
                                        <i class="fas fa-info-circle text-info"></i>
                                    @else
                                        <i class="fas fa-check-circle text-success"></i>
                                    @endif
                                </span>
                            </div>
                            <div class="progress-bar-bg">
                                @php
                                    $colorClass = 'bg-success';
                                    if($s['percentage'] <= 20) $colorClass = 'bg-danger';
                                    elseif($s['percentage'] <= 40) $colorClass = 'bg-warning';
                                    elseif($s['percentage'] <= 80) $colorClass = 'bg-info';
                                @endphp
                                <div class="progress-bar-fill {{ $colorClass }}" 
                                     style="width: {{ $s['percentage'] }}%"></div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        Belum ada data mahasiswa.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Header Styles */
.page-header {
    margin-bottom: 1.5rem;
}

.header-content {
    background: white;
    padding: 1.5rem;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.btn-back {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: #f1f5f9;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-back:hover {
    background: #e2e8f0;
    color: #0f172a;
}

.header-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 0.25rem 0;
}

.header-meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.875rem;
    color: #64748b;
}

.header-meta i {
    color: #0891b2;
    margin-right: 0.25rem;
}

.meta-separator {
    color: #cbd5e1;
}

/* Content Card */
.content-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    padding: 1.5rem;
}

/* Table */
.table {
    width: 100%;
    border-collapse: collapse;
}

.table th {
    background: #f8fafc;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.875rem;
    color: #475569;
    border-radius: 8px;
}

.table td {
    padding: 1rem;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.text-center { text-align: center; }

/* User Info */
.stats-user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    justify-content: flex-start; /* Ensure left alignment */
}

.stats-user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1rem;
    flex-shrink: 0;
}

.stats-user-details {
    display: flex;
    flex-direction: column;
    text-align: left;
}

.stats-user-name {
    font-weight: 600;
    color: #0f172a;
    font-size: 0.9375rem;
}

.stats-user-nim {
    font-size: 0.8125rem;
    color: #64748b;
}

/* Badges */
.badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    height: 32px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
}

.badge-success { background: #dcfce7; color: #166534; }
.badge-warning { background: #fef9c3; color: #854d0e; }
.badge-info { background: #dbeafe; color: #1e40af; }
.badge-danger { background: #fee2e2; color: #991b1b; }

/* Progress Bar */
.progress-wrapper {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    min-width: 150px;
}

.progress-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.875rem;
    font-weight: 600;
}

.progress-bar-bg {
    height: 8px;
    background: #f1f5f9;
    border-radius: 9999px;
    overflow: hidden;
}

.progress-bar-fill {
    height: 100%;
    border-radius: 9999px;
    transition: width 0.5s ease;
}

.bg-success { background: #22c55e; }
.bg-danger { background: #ef4444; }
.bg-warning { background: #eab308; }
.bg-info { background: #3b82f6; }

.text-success { color: #22c55e; }
.text-danger { color: #ef4444; }
.text-warning { color: #eab308; }
.text-info { color: #3b82f6; }

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .table-responsive {
        overflow-x: auto;
    }
}
</style>
@endpush
