@extends('layouts.mahasiswa')

@section('title', 'Detail Jadwal')

@section('breadcrumb')
    <span>/</span>
    <a href="{{ route('mahasiswa.jadwal.index') }}">Jadwal</a>
    <span>/</span>
    <span>Detail</span>
@endsection

@section('content')
<div class="detail-container">
    {{-- Jadwal Header Card --}}
    <div class="jadwal-detail-header">
        <div class="header-bg"></div>
        <div class="header-content">
            <div class="header-icon">
                <i class="fas fa-flask"></i>
            </div>
            <div class="header-info">
                <h2>{{ $jadwal->praktikum->nama_praktikum ?? '-' }}</h2>
                <p>{{ $jadwal->kelas->nama_kelas ?? '-' }}</p>
            </div>
            <div class="header-badge">
                <i class="fas fa-check-circle"></i>
                Aktif
            </div>
        </div>
    </div>

    {{-- Info Cards Row --}}
    <div class="info-cards-row">
        <div class="info-card">
            <div class="info-card-icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="info-card-content">
                <span class="info-label">Hari</span>
                <span class="info-value">{{ $jadwal->hari }}</span>
            </div>
        </div>
        <div class="info-card">
            <div class="info-card-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="info-card-content">
                <span class="info-label">Waktu</span>
                <span class="info-value">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</span>
            </div>
        </div>
        <div class="info-card">
            <div class="info-card-icon">
                <i class="fas fa-door-open"></i>
            </div>
            <div class="info-card-content">
                <span class="info-label">Ruangan</span>
                <span class="info-value">{{ $jadwal->ruangan->nama_ruangan ?? '-' }}</span>
            </div>
        </div>
        <div class="info-card">
            <div class="info-card-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="info-card-content">
                <span class="info-label">Mata Kuliah</span>
                <span class="info-value">{{ $jadwal->mata_kuliah ?? '-' }}</span>
            </div>
        </div>
        <div class="info-card">
            <div class="info-card-icon">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="info-card-content">
                <span class="info-label">Instruktur</span>
                <span class="info-value">{{ $jadwal->instruktur->nama ?? '-' }}</span>
            </div>
        </div>
    </div>

    {{-- Materi & Modul Card --}}
    <div class="detail-card" style="margin-bottom: 1.5rem;">
        <div class="detail-header">
            <h3>
                <i class="fas fa-book-open"></i>
                Materi & Modul
            </h3>
        </div>
        <div class="detail-body">
            @if($jadwal->modul && $jadwal->modul->count() > 0)
            <div class="modul-grid">
                @foreach($jadwal->modul as $m)
                <div class="modul-item">
                    <div class="modul-icon-wrapper {{ $m->file_type }}">
                        @if(in_array($m->file_type, ['pdf']))
                        <i class="fas fa-file-pdf"></i>
                        @elseif(in_array($m->file_type, ['doc', 'docx']))
                        <i class="fas fa-file-word"></i>
                        @elseif(in_array($m->file_type, ['ppt', 'pptx']))
                        <i class="fas fa-file-powerpoint"></i>
                        @elseif(in_array($m->file_type, ['xls', 'xlsx']))
                        <i class="fas fa-file-excel"></i>
                        @elseif(in_array($m->file_type, ['zip', 'rar']))
                        <i class="fas fa-file-archive"></i>
                        @else
                        <i class="fas fa-file-alt"></i>
                        @endif
                    </div>
                    <div class="modul-details">
                        <div class="modul-main">
                            <h4>{{ $m->judul }}</h4>
                            <div class="modul-sub">
                                @if($m->pertemuan_ke)
                                <span class="modul-badge">Pertemuan {{ $m->pertemuan_ke }}</span>
                                @endif
                                <span class="modul-size">{{ $m->formatted_file_size }}</span>
                            </div>
                        </div>
                        <a href="{{ route('mahasiswa.modul.download', $m) }}" class="btn-download" title="Download Materials">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state-mini">
                <i class="fas fa-folder-open"></i>
                <p>Belum ada modul yang tersedia</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Sesi & Absensi Card --}}
    <div class="detail-card">
        <div class="detail-header">
            <h3>
                <i class="fas fa-clipboard-list"></i>
                Sesi & Absensi
            </h3>
        </div>
        <div class="detail-body">
            @if($jadwal->sesi && $jadwal->sesi->count() > 0)
            <div class="sesi-list">
                @foreach($jadwal->sesi as $sesi)
                <div class="sesi-item">
                    <div class="sesi-number">
                        <span>{{ $loop->iteration }}</span>
                    </div>
                    <div class="sesi-content">
                        <div class="sesi-info">
                            <h4>Pertemuan {{ $loop->iteration }}</h4>
                            <p>{{ \Carbon\Carbon::parse($sesi->tanggal)->format('d F Y') }}</p>
                        </div>
                        <div class="sesi-status">
                            @php
                                $today = \Carbon\Carbon::now()->startOfDay();
                                $sesiDate = \Carbon\Carbon::parse($sesi->tanggal)->startOfDay();
                            @endphp

                            @if(isset($absensi[$sesi->id]))
                                @switch(ucfirst(strtolower($absensi[$sesi->id])))
                                    @case('Hadir')
                                        <span class="status-badge success">
                                            <i class="fas fa-check-circle"></i> Hadir
                                        </span>
                                        @break
                                    @case('Izin')
                                        <span class="status-badge warning">
                                            <i class="fas fa-info-circle"></i> Izin
                                        </span>
                                        @break
                                    @case('Sakit')
                                        <span class="status-badge info">
                                            <i class="fas fa-medkit"></i> Sakit
                                        </span>
                                        @break
                                    @case('Alpha')
                                        <span class="status-badge danger">
                                            <i class="fas fa-times-circle"></i> Alpha
                                        </span>
                                        @break
                                @endswitch
                            @else
                                @if($sesiDate->gt($today))
                                    {{-- Future --}}
                                    <span class="status-badge pending" style="background: #f1f5f9; color: #64748b;">
                                        <i class="fas fa-clock"></i> Akan Datang
                                    </span>
                                @elseif($sesiDate->eq($today))
                                    {{-- Today --}}
                                    <span class="status-badge warning" style="background: #fef3c7; color: #d97706;">
                                        <i class="fas fa-hourglass-half"></i> Belum Diabsen
                                    </span>
                                @else
                                    {{-- Past --}}
                                    <span class="status-badge danger">
                                        <i class="fas fa-question-circle"></i> Tanpa Keterangan
                                    </span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-sesi">
                <i class="fas fa-calendar-plus"></i>
                <p>Belum ada sesi terjadwal</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Actions --}}
    <div class="detail-actions">
        <a href="{{ route('mahasiswa.jadwal.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
/* =====================================================
   JADWAL DETAIL STYLES
   ===================================================== */

.detail-container {
    max-width: 800px;
    margin: 0 auto;
}

/* Header Card */
.jadwal-detail-header {
    position: relative;
    background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.header-bg {
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='rgba(255,255,255,0.1)' d='M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,213.3C672,224,768,224,864,202.7C960,181,1056,139,1152,128C1248,117,1344,139,1392,149.3L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'/%3E%3C/svg%3E") no-repeat bottom;
    background-size: cover;
}

.header-content {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.header-icon {
    width: 72px;
    height: 72px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    flex-shrink: 0;
}

.header-info {
    flex: 1;
}

.header-info h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 0.25rem;
}

.header-info p {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.85);
}

.header-badge {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 600;
    color: white;
}

/* Info Cards Row */
.info-cards-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.info-card {
    background: white;
    border-radius: 14px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}

.info-card-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0d9488;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.info-card-content {
    display: flex;
    flex-direction: column;
}

.info-label {
    font-size: 0.75rem;
    color: #64748b;
    font-weight: 500;
}

.info-value {
    font-size: 0.9375rem;
    color: #0f172a;
    font-weight: 600;
}

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

/* Sesi List */
.sesi-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.sesi-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}

.sesi-number {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1rem;
    flex-shrink: 0;
}

.sesi-content {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.sesi-info h4 {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 0.125rem;
}

.sesi-info p {
    font-size: 0.8125rem;
    color: #64748b;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 0.875rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-badge.success {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.status-badge.warning {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.status-badge.info {
    background: rgba(14, 165, 233, 0.1);
    color: #0284c7;
}

.status-badge.danger {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.status-badge.pending {
    background: rgba(100, 116, 139, 0.1);
    color: #64748b;
}

/* Empty Sesi */
.empty-sesi {
    text-align: center;
    padding: 2rem;
    color: #94a3b8;
}

.empty-sesi i {
    font-size: 2.5rem;
    margin-bottom: 0.75rem;
    display: block;
}

/* Actions */
.detail-actions {
    display: flex;
    justify-content: flex-start;
}

/* Button */
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

.btn-secondary {
    background: white;
    color: #475569;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.btn-secondary:hover {
    background: #f1f5f9;
    border-color: #0d9488;
    color: #0d9488;
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        text-align: center;
    }
    
    .header-badge {
        margin-top: 0.5rem;
    }
    
    .info-cards-row {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .sesi-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
}

@media (max-width: 480px) {
    .info-cards-row {
        grid-template-columns: 1fr;
    }
}
/* Module Styles */
.modul-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
}

.modul-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    transition: all 0.2s ease;
}

.modul-item:hover {
    border-color: #0d9488;
    box-shadow: 0 4px 12px rgba(13, 148, 136, 0.1);
    transform: translateY(-2px);
}

.modul-icon-wrapper {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.modul-icon-wrapper.pdf { background: #fee2e2; color: #dc2626; }
.modul-icon-wrapper.doc, .modul-icon-wrapper.docx { background: #dbeafe; color: #2563eb; }
.modul-icon-wrapper.ppt, .modul-icon-wrapper.pptx { background: #ffedd5; color: #ea580c; }
.modul-icon-wrapper.xls, .modul-icon-wrapper.xlsx { background: #dcfce7; color: #16a34a; }
.modul-icon-wrapper.zip, .modul-icon-wrapper.rar { background: #ecfeff; color: #0891b2; }
.modul-icon-wrapper:not(.pdf):not(.doc):not(.docx):not(.ppt):not(.pptx):not(.xls):not(.xlsx):not(.zip):not(.rar) { background: #f1f5f9; color: #64748b; }

.modul-details {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    min-width: 0;
}

.modul-main {
    flex: 1;
    min-width: 0;
}

.modul-main h4 {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 0.25rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.modul-sub {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.75rem;
}

.modul-badge {
    padding: 0.125rem 0.5rem;
    background: #f0fdfa;
    color: #0d9488;
    border-radius: 9999px;
    font-weight: 600;
}

.modul-size {
    color: #94a3b8;
}

.btn-download {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #f8fafc;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    border: 1px solid #e2e8f0;
}

.btn-download:hover {
    background: #0d9488;
    color: white;
    border-color: #0d9488;
}

.empty-state-mini {
    text-align: center;
    padding: 2rem;
    color: #94a3b8;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px dashed #e2e8f0;
}

.empty-state-mini i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    display: block;
}

@media (max-width: 480px) {
    .modul-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush
