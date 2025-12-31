@extends('layouts.mahasiswa')

@section('title', 'Detail Pendaftaran')

@section('breadcrumb')
    <span>/</span>
    <a href="{{ route('mahasiswa.pendaftaran.index') }}">Pendaftaran</a>
    <span>/</span>
    <span>Detail</span>
@endsection

@section('content')
<div class="detail-container">
    {{-- Status Card --}}
    <div class="status-card status-{{ $pendaftaran->status }}">
        <div class="status-icon">
            @switch($pendaftaran->status)
                @case('pending')
                    <i class="fas fa-hourglass-half"></i>
                    @break
                @case('diterima')
                    <i class="fas fa-check-circle"></i>
                    @break
                @case('ditolak')
                    <i class="fas fa-times-circle"></i>
                    @break
            @endswitch
        </div>
        <div class="status-content">
            <span class="status-label">Status Pendaftaran</span>
            <span class="status-value">
                @switch($pendaftaran->status)
                    @case('pending')
                        Menunggu Verifikasi
                        @break
                    @case('diterima')
                        Diterima
                        @break
                    @case('ditolak')
                        Ditolak
                        @break
                @endswitch
            </span>
        </div>
    </div>

    {{-- Detail Card --}}
    <div class="detail-card">
        <div class="detail-header">
            <h3><i class="fas fa-book"></i> Informasi Praktikum</h3>
        </div>
        <div class="detail-body">
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Nama Praktikum</span>
                    <span class="detail-value">{{ $pendaftaran->praktikum->nama_praktikum ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Kelas</span>
                    <span class="detail-value">{{ $pendaftaran->kelas->nama_kelas ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Periode</span>
                    <span class="detail-value">{{ $pendaftaran->periode->nama_periode ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Tanggal Daftar</span>
                    <span class="detail-value">{{ $pendaftaran->created_at->format('d F Y, H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Timeline Card --}}
    <div class="detail-card">
        <div class="detail-header">
            <h3><i class="fas fa-history"></i> Riwayat Status</h3>
        </div>
        <div class="detail-body">
            <div class="timeline">
                <div class="timeline-item completed">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <span class="timeline-title">Pendaftaran Dikirim</span>
                        <span class="timeline-date">{{ $pendaftaran->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
                <div class="timeline-item {{ $pendaftaran->status !== 'pending' ? 'completed' : '' }}">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <span class="timeline-title">Verifikasi Admin</span>
                        <span class="timeline-date">
                            @if($pendaftaran->status !== 'pending')
                                {{ $pendaftaran->updated_at->format('d M Y, H:i') }}
                            @else
                                Menunggu...
                            @endif
                        </span>
                    </div>
                </div>
                @if($pendaftaran->status === 'diterima')
                <div class="timeline-item completed success">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <span class="timeline-title">Pendaftaran Diterima</span>
                        <span class="timeline-date">{{ $pendaftaran->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
                @elseif($pendaftaran->status === 'ditolak')
                <div class="timeline-item completed danger">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <span class="timeline-title">Pendaftaran Ditolak</span>
                        <span class="timeline-date">{{ $pendaftaran->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="detail-actions">
        <a href="{{ route('mahasiswa.pendaftaran.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
        @if($pendaftaran->status === 'diterima')
        <a href="{{ route('mahasiswa.jadwal.index') }}" class="btn btn-primary">
            <i class="fas fa-calendar-alt"></i>
            Lihat Jadwal
        </a>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
/* =====================================================
   PENDAFTARAN DETAIL STYLES
   ===================================================== */

.detail-container {
    max-width: 700px;
    margin: 0 auto;
}

/* Status Card */
.status-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    border-radius: 16px;
    margin-bottom: 1.5rem;
}

.status-card.status-pending {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border: 1px solid rgba(217, 119, 6, 0.2);
}

.status-card.status-diterima {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    border: 1px solid rgba(5, 150, 105, 0.2);
}

.status-card.status-ditolak {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border: 1px solid rgba(220, 38, 38, 0.2);
}

.status-icon {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.status-pending .status-icon {
    background: white;
    color: #d97706;
    box-shadow: 0 4px 12px rgba(217, 119, 6, 0.2);
}

.status-diterima .status-icon {
    background: white;
    color: #059669;
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
}

.status-ditolak .status-icon {
    background: white;
    color: #dc2626;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
}

.status-content {
    display: flex;
    flex-direction: column;
}

.status-label {
    font-size: 0.8125rem;
    font-weight: 500;
    opacity: 0.8;
}

.status-pending .status-label { color: #92400e; }
.status-diterima .status-label { color: #047857; }
.status-ditolak .status-label { color: #b91c1c; }

.status-value {
    font-size: 1.25rem;
    font-weight: 700;
}

.status-pending .status-value { color: #b45309; }
.status-diterima .status-value { color: #059669; }
.status-ditolak .status-value { color: #dc2626; }

/* Detail Card */
.detail-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.detail-header {
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom: 1px solid #e2e8f0;
}

.detail-header h3 {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
    color: #0f172a;
}

.detail-header h3 i {
    color: #0d9488;
}

.detail-body {
    padding: 1.5rem;
}

/* Detail Grid */
.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.detail-label {
    font-size: 0.8125rem;
    color: #64748b;
    font-weight: 500;
}

.detail-value {
    font-size: 1rem;
    color: #0f172a;
    font-weight: 600;
}

/* Timeline */
.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 9px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e2e8f0;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -2rem;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: white;
    border: 2px solid #e2e8f0;
}

.timeline-item.completed .timeline-marker {
    background: #0d9488;
    border-color: #0d9488;
}

.timeline-item.completed.success .timeline-marker {
    background: #10b981;
    border-color: #10b981;
}

.timeline-item.completed.danger .timeline-marker {
    background: #ef4444;
    border-color: #ef4444;
}

.timeline-marker::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: white;
}

.timeline-content {
    display: flex;
    flex-direction: column;
}

.timeline-title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #0f172a;
}

.timeline-date {
    font-size: 0.8125rem;
    color: #64748b;
}

/* Actions */
.detail-actions {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
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
}

/* Responsive */
@media (max-width: 640px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
    
    .detail-actions {
        flex-direction: column-reverse;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush
