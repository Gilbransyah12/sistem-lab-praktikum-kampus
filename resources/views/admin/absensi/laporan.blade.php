@extends('layouts.admin')

@section('title', 'Laporan Absensi')

@section('content')
<div class="page-header mb-4">
    <a href="{{ route('admin.absensi.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-chart-bar"></i>
            Laporan Rekap Absensi
        </h3>
    </div>
    
    <div class="card-body">
        <!-- Filter -->
        <div class="filter-section">
            <form action="{{ route('admin.absensi.laporan') }}" method="GET" class="filter-form">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label for="jadwal_id"><i class="fas fa-calendar-alt"></i> Pilih Jadwal Praktikum</label>
                        <div class="search-input-wrapper">
                            <select name="jadwal_id" id="jadwal_id" class="filter-select">
                                <option value="">-- Pilih Jadwal --</option>
                                @foreach($jadwal as $j)
                                    <option value="{{ $j->id }}" {{ request('jadwal_id') == $j->id ? 'selected' : '' }}>
                                        {{ $j->praktikum->nama_praktikum }} - {{ $j->kelas->nama_kelas }} ({{ $j->instruktur->nama ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="search-btn">
                                <i class="fas fa-search"></i> Tampilkan
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            @if(request('jadwal_id'))
            <div class="export-actions">
                <a href="{{ route('admin.absensi.export', ['jadwal_id' => request('jadwal_id')]) }}" class="btn-export excel">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <a href="{{ route('admin.absensi.pdf', ['jadwal_id' => request('jadwal_id')]) }}" class="btn-export pdf" target="_blank">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
            </div>
            @endif
        </div>

        @if(request('jadwal_id') && count($data) > 0)
        <!-- Report Table -->
        <div class="table-container mt-4">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th width="15%">NIM</th>
                        <th width="30%">Nama Peserta</th>
                        <th class="text-center" width="15%">Total Hadir</th>
                        <th width="35%">Persentase Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $selectedJadwal = $jadwal->find(request('jadwal_id'));
                        $totalSesi = $selectedJadwal ? $selectedJadwal->sesi->count() : 1;
                    @endphp
                    @foreach($data as $index => $d)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <span class="nim-badge">{{ $d['peserta']->nim ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="name-text">{{ $d['peserta']->nama ?? '-' }}</span>
                        </td>
                        <td class="text-center">
                            <span class="attendance-count">{{ $d['total_hadir'] }} / {{ $totalSesi }}</span>
                        </td>
                        <td>
                            @php
                                $percentage = $totalSesi > 0 ? round(($d['total_hadir'] / $totalSesi) * 100) : 0;
                            @endphp
                            <div class="progress-bar-wrapper">
                                <span class="progress-text">{{ $percentage }}%</span>
                                <div class="progress-track">
                                    <div class="progress-fill {{ $percentage >= 75 ? 'success' : ($percentage >= 50 ? 'warning' : 'danger') }}" 
                                         style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @elseif(request('jadwal_id'))
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-user-clock"></i>
            </div>
            <p>Belum ada data absensi untuk jadwal ini</p>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-filter"></i>
            </div>
            <p>Silakan pilih jadwal terlebih dahulu untuk melihat laporan rekap absensi</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
/* =====================================================
   LAPORAN ABSENSI STYLES - TEAL THEME
   ===================================================== */

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-back:hover {
    color: #0f766e;
    transform: translateX(-3px);
}

/* Card Header */
.card-header {
    background: white;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-title i {
    color: #0f766e;
    background: #f0fdfa;
    padding: 10px;
    border-radius: 12px;
}

/* Filter Section */
.filter-section {
    background: #f8fafc;
    padding: 1.5rem 2rem;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}

.filter-grid {
    display: flex;
    gap: 1.25rem;
}

.filter-group {
    flex: 1;
}

.filter-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-size: 0.75rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.filter-group label i {
    color: #0f766e;
    margin-right: 0.25rem;
}

.search-input-wrapper {
    display: flex;
    gap: 0.75rem;
}

.filter-select {
    flex: 1;
    padding: 0.625rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.875rem;
    color: #334155;
    background: white;
    transition: all 0.2s;
    cursor: pointer;
}

.filter-select:focus {
    border-color: #14b8a6;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
    outline: none;
}

.search-btn {
    padding: 0 1.5rem;
    background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.search-btn:hover {
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
    transform: translateY(-2px);
}

.export-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}

.btn-export {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.2s;
    color: white;
}

.btn-export.excel { background: #10b981; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2); }
.btn-export.excel:hover { background: #059669; transform: translateY(-2px); box-shadow: 0 6px 14px rgba(16, 185, 129, 0.3); }

.btn-export.pdf { background: #ef4444; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2); }
.btn-export.pdf:hover { background: #dc2626; transform: translateY(-2px); box-shadow: 0 6px 14px rgba(239, 68, 68, 0.3); }

/* Premium Table */
.table-container {
    overflow-x: auto;
}

.premium-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.premium-table th {
    background: #f8fafc;
    padding: 1rem 1.5rem;
    font-size: 0.75rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 2px solid #e2e8f0;
}

.premium-table td {
    padding: 1.25rem 1.5rem;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
}

.premium-table tbody tr {
    transition: all 0.2s;
}

.premium-table tbody tr:hover {
    background: #fcfcfc;
}

/* Badges & Elements */
.nim-badge {
    background: #f1f5f9;
    color: #475569;
    padding: 0.25rem 0.6rem;
    border-radius: 6px;
    font-family: monospace;
    font-weight: 700;
    font-size: 0.875rem;
    border: 1px solid #e2e8f0;
}

.name-text {
    font-weight: 600;
    color: #334155;
}

.attendance-count {
    font-weight: 700;
    color: #0f766e;
    font-size: 1rem;
}

/* Progress Bar */
.progress-bar-wrapper {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.progress-text {
    font-weight: 700;
    font-size: 0.9375rem;
    color: #334155;
    min-width: 45px;
}

.progress-track {
    flex: 1;
    height: 10px;
    background: #e2e8f0;
    border-radius: 9999px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    border-radius: 9999px;
    transition: width 0.5s ease;
}

.progress-fill.success { background: linear-gradient(90deg, #10b981, #34d399); }
.progress-fill.warning { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
.progress-fill.danger { background: linear-gradient(90deg, #ef4444, #f87171); }

/* Empty State */
.empty-state {
    padding: 4rem 2rem !important;
    text-align: center;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: #f1f5f9;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.empty-icon i {
    font-size: 2.5rem;
    color: #94a3b8;
}

.empty-state p {
    color: #64748b;
    font-weight: 500;
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .filter-grid, .search-input-wrapper {
        flex-direction: column;
    }
    
    .search-btn {
        width: 100%;
        justify-content: center;
    }
    
    .export-actions {
        flex-direction: column;
    }
    
    .btn-export {
        width: 100%;
        justify-content: center;
    }
    
    .premium-table td, .premium-table th {
        padding: 1rem;
    }
}
</style>
@endpush
