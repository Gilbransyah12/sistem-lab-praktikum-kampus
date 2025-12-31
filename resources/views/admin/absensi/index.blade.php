@extends('layouts.admin')

@section('title', 'Absensi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-clipboard-list"></i>
            Daftar Sesi Praktikum
        </h3>
        <div class="header-actions">
            <a href="{{ route('admin.absensi.laporan') }}" class="btn btn-primary">
                <i class="fas fa-chart-bar"></i> Laporan Absensi
            </a>
        </div>
    </div>
    
    {{-- Filter Section --}}
    <div class="card-filter">
        <form action="{{ route('admin.absensi.index') }}" method="GET" class="filter-form">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="jadwal_id"><i class="fas fa-filter"></i> Filter Jadwal</label>
                    <div class="select-wrapper">
                        <select name="jadwal_id" id="jadwal_id" class="filter-select" onchange="this.form.submit()">
                            <option value="">-- Semua Jadwal --</option>
                            @foreach($jadwal as $j)
                                <option value="{{ $j->id }}" {{ request('jadwal_id') == $j->id ? 'selected' : '' }}>
                                    {{ $j->praktikum->nama_praktikum }} - {{ $j->kelas->nama_kelas }} ({{ $j->instruktur->nama ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            @if(request('jadwal_id'))
            <div class="filter-reset">
                <a href="{{ route('admin.absensi.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-times"></i> Reset Filter
                </a>
            </div>
            @endif
        </form>
    </div>

    <div class="card-body">
        <div class="table-container">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th width="15%">Pertemuan</th>
                        <th width="15%">Tanggal & Waktu</th>
                        <th width="20%">Praktikum</th>
                        <th width="10%">Kelas</th>
                        <th width="20%">Instruktur</th>
                        <th class="text-center" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sesi as $index => $s)
                    <tr>
                        <td class="text-center">{{ $sesi->firstItem() + $index }}</td>
                        <td>
                            <span class="meeting-badge">Pertemuan {{ $s->pertemuan_ke }}</span>
                        </td>
                        <td>
                            <div class="date-info">
                                <span class="date-text"><i class="far fa-calendar"></i> {{ $s->tanggal->format('d/m/Y') }}</span>
                                <span class="time-text"><i class="far fa-clock"></i> {{ substr($s->jam_mulai, 0, 5) }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="praktikum-name">{{ $s->jadwal->praktikum->nama_praktikum ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="class-badge">{{ $s->jadwal->kelas->nama_kelas ?? '-' }}</span>
                        </td>
                        <td>
                            <div class="user-info-mini">
                                <div class="avatar-mini">{{ substr($s->jadwal->instruktur->nama ?? 'U', 0, 1) }}</div>
                                <span>{{ $s->jadwal->instruktur->nama ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="action-cell justify-content-center">
                                <a href="{{ route('admin.absensi.show', $s->id) }}" class="btn-action view" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <p>Belum ada sesi praktikum</p>
                            @if(request('jadwal_id'))
                                <small>Coba reset filter pencarian Anda</small>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($sesi->hasPages())
        <div class="pagination-wrapper">
            {{ $sesi->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
/* =====================================================
   ABSENSI INDEX STYLES - TEAL THEME
   ===================================================== */

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
.card-filter {
    background: #f8fafc;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.filter-form {
    flex: 1;
    display: flex;
    align-items: flex-end;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-grid {
    display: flex;
    gap: 1.25rem;
    align-items: center;
    flex: 1;
}

.filter-group {
    flex: 1;
    max-width: 500px;
}

.filter-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.filter-group label i {
    color: #0f766e;
    margin-right: 0.25rem;
}

.filter-select {
    width: 100%;
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

.filter-reset {
    margin-left: auto;
}

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

/* Badges & Text */
.meeting-badge {
    background: #f0fdfa;
    color: #0f766e;
    padding: 0.25rem 0.75rem;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.875rem;
    border: 1px solid #ccfbf1;
}

.date-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.date-text, .time-text {
    font-size: 0.8125rem;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.date-text i, .time-text i {
    color: #94a3b8;
    width: 14px;
}

.praktikum-name {
    font-weight: 600;
    color: #334155;
}

.class-badge {
    background: #e0f2fe;
    color: #0284c7;
    padding: 0.25rem 0.6rem;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.user-info-mini {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.avatar-mini {
    width: 28px;
    height: 28px;
    background: #f1f5f9;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 700;
    color: #64748b;
}

/* Action Buttons */
.action-cell {
    display: flex;
    gap: 0.5rem;
}

.btn-action {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.9375rem;
}

.btn-action.view { background: #dcfce7; color: #16a34a; }
.btn-action.view:hover { background: #bbf7d0; transform: translateY(-2px); }

/* Buttons */
.btn-primary {
    background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
    color: white;
    padding: 0.625rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    border: none;
    transition: all 0.2s;
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
}

.btn-primary:hover {
    box-shadow: 0 6px 16px rgba(20, 184, 166, 0.4);
    transform: translateY(-2px);
}

.btn-secondary {
    background: white;
    color: #64748b;
    border: 1px solid #e2e8f0;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.8125rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-secondary:hover {
    background: #f1f5f9;
    color: #334155;
    border-color: #cbd5e1;
}

.empty-state {
    padding: 4rem 2rem !important;
    text-align: center;
}

.empty-icon {
    font-size: 3rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
}

.justify-content-center { justify-content: center; }

.pagination-wrapper {
    padding: 1.5rem 2rem;
    border-top: 1px solid #f1f5f9;
}

/* Responsive */
@media (max-width: 768px) {
    .card-filter {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    
    .filter-form {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-group {
        max-width: 100%;
    }
    
    .filter-reset {
        margin-left: 0;
        text-align: center;
    }
    
    .premium-table td, .premium-table th {
        padding: 1rem;
    }
}
</style>
@endpush
