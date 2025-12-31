@extends('layouts.instruktur')

@section('title', 'Sesi Pertemuan')

@section('content')
{{-- Page Header --}}
<div class="page-header">
    <div class="header-card">
        <div class="header-icon">
            <i class="fas fa-flask"></i>
        </div>
        <div class="header-info">
            <h2>{{ $jadwal->praktikum->nama_praktikum ?? '-' }}</h2>
            <p>{{ $jadwal->kelas->nama_kelas ?? '-' }} • {{ $jadwal->hari }}, {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</p>
        </div>
        <div class="header-actions" style="display: flex; gap: 0.75rem;">
            <a href="{{ route('instruktur.absensi.statistik', $jadwal) }}" class="btn btn-secondary" style="background: rgba(255,255,255,0.2); color: white; border: none;">
                <i class="fas fa-chart-pie"></i> Statistik
            </a>
            <a href="{{ route('instruktur.absensi.create-sesi', $jadwal) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Sesi
            </a>
        </div>
    </div>
</div>

{{-- Sesi List --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-list"></i>
            Daftar Sesi Pertemuan
        </h3>
    </div>
    <div class="card-body">
        @if($jadwal->sesi && $jadwal->sesi->count() > 0)
        <div class="sesi-list">
            @foreach($jadwal->sesi->sortBy('pertemuan_ke') as $sesi)
            <div class="sesi-item">
                <div class="sesi-number">
                    <span>{{ $sesi->pertemuan_ke }}</span>
                </div>
                <div class="sesi-content">
                    <div class="sesi-info">
                        <h4>Pertemuan {{ $sesi->pertemuan_ke }}</h4>
                        <p>{{ \Carbon\Carbon::parse($sesi->tanggal)->format('l, d F Y') }}</p>
                        @if($sesi->materi)
                        <span class="materi-tag">
                            <i class="fas fa-book"></i>
                            {{ $sesi->materi }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="sesi-action">
                    <a href="{{ route('instruktur.absensi.absen', $sesi) }}" class="btn btn-primary">
                        <i class="fas fa-clipboard-check"></i>
                        Input Absensi
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-calendar-plus"></i>
            <h4>Belum Ada Sesi</h4>
            <p>Tambahkan sesi pertemuan baru untuk mulai mengisi absensi.</p>
            <a href="{{ route('instruktur.absensi.create-sesi', $jadwal) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Sesi Pertama
            </a>
        </div>
        @endif
    </div>
</div>

{{-- Back Button --}}
<div class="action-bar">
    <a href="{{ route('instruktur.absensi.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>
</div>
@endsection

@push('styles')
<style>
/* =====================================================
   SESI PAGE STYLES
   ===================================================== */

.page-header {
    margin-bottom: 1.5rem;
}

.header-card {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
    border-radius: 16px;
    color: white;
}

.header-icon {
    width: 64px;
    height: 64px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.header-info {
    flex: 1;
}

.header-info h2 {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.header-info p {
    font-size: 0.875rem;
    opacity: 0.9;
}

.header-card .btn-primary {
    background: white;
    color: #0891b2;
    box-shadow: none;
}

.header-card .btn-primary:hover {
    background: #f5f5ff;
}

/* Card */
.card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.card-header {
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom: 1px solid #e2e8f0;
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

/* Sesi List */
.sesi-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.sesi-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
}

.sesi-item:hover {
    border-color: rgba(6, 182, 212, 0.3);
    box-shadow: 0 4px 12px rgba(6, 182, 212, 0.1);
}

.sesi-number {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #0891b2 0%, #22d3ee 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.sesi-content {
    flex: 1;
}

.sesi-info h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 0.25rem;
}

.sesi-info p {
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 0.5rem;
}

.materi-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.625rem;
    background: #ecfeff;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    color: #0891b2;
}

.sesi-action {
    flex-shrink: 0;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: linear-gradient(135deg, #0891b2 0%, #22d3ee 100%);
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
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem;
}

.empty-state i {
    font-size: 3rem;
    color: #c7d2fe;
    margin-bottom: 1rem;
    display: block;
}

.empty-state h4 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #64748b;
    margin-bottom: 1.5rem;
}

.action-bar {
    display: flex;
    justify-content: flex-start;
}

/* Responsive */
@media (max-width: 768px) {
    .header-card {
        flex-direction: column;
        text-align: center;
    }
    
    .sesi-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .sesi-action {
        width: 100%;
        padding-top: 0.75rem;
        border-top: 1px solid #e2e8f0;
    }
    
    .sesi-action .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

