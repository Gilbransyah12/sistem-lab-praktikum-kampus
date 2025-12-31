@extends('layouts.admin')

@section('title', 'Detail Absensi')

@section('content')
<div class="page-header">
    <a href="{{ route('admin.absensi.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali</span>
    </a>
</div>

<!-- Info Card -->
<div class="info-card">
    <div class="info-grid">
        <div class="info-item">
            <span class="info-label">Praktikum</span>
            <span class="info-value">{{ $sesi->jadwal->praktikum->nama_praktikum ?? '-' }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Kelas</span>
            <span class="info-value">{{ $sesi->jadwal->kelas->nama_kelas ?? '-' }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Instruktur</span>
            <span class="info-value">{{ $sesi->jadwal->instruktur->nama ?? '-' }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Pertemuan</span>
            <span class="info-value">Pertemuan ke-{{ $sesi->pertemuan_ke }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Tanggal</span>
            <span class="info-value">{{ $sesi->tanggal->format('d F Y') }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Materi</span>
            <span class="info-value">{{ $sesi->materi ?? '-' }}</span>
        </div>
    </div>
</div>

<!-- Absensi Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Hadir Peserta</h3>
        <div class="stats-summary">
            <span class="stat-badge success">
                <i class="fas fa-check-circle"></i>
                Hadir: {{ collect($absensi)->where('status', 'Hadir')->count() }}
            </span>
            <span class="stat-badge warning">
                <i class="fas fa-clock"></i>
                Izin: {{ collect($absensi)->where('status', 'Izin')->count() }}
            </span>
            <span class="stat-badge danger">
                <i class="fas fa-times-circle"></i>
                Alpha: {{ collect($absensi)->where('status', 'Alpha')->count() }}
            </span>
        </div>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama Peserta</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftaran as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><code>{{ $p->peserta->nim ?? '-' }}</code></td>
                        <td>{{ $p->peserta->nama ?? '-' }}</td>
                        <td>
                            @php
                                $status = $absensi[$p->id] ?? null;
                            @endphp
                            @if($status === 'Hadir')
                                <span class="badge badge-success">Hadir</span>
                            @elseif($status === 'Izin')
                                <span class="badge badge-warning">Izin</span>
                            @elseif($status === 'Alpha')
                                <span class="badge badge-danger">Alpha</span>
                            @else
                                <span class="badge badge-info">Belum Absen</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-state">
                            <i class="fas fa-users"></i>
                            <p>Belum ada peserta terdaftar di kelas ini</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
.page-header {
    margin-bottom: 1.5rem;
}

.info-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow-md);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.info-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--dark-500);
}

.info-value {
    font-size: 1rem;
    font-weight: 500;
    color: var(--dark-800);
}

.stats-summary {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.stat-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.stat-badge.success {
    background: rgba(34, 197, 94, 0.1);
    color: #059669;
}

.stat-badge.warning {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.stat-badge.danger {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

code {
    background: var(--dark-100);
    padding: 0.125rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    color: var(--primary-700);
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem !important;
    color: var(--dark-400);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    display: block;
    color: var(--dark-300);
}

.empty-state p {
    margin: 0;
}
</style>
@endpush
@endsection
