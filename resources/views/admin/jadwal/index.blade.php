@extends('layouts.admin')

@section('title', 'Jadwal Praktikum')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-clock"></i>
            Daftar Jadwal Praktikum
        </h3>
        <div class="header-actions">
            <a href="{{ route('admin.jadwal.export-pdf', request()->all()) }}" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Jadwal
            </a>
            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">
                <i class="fas fa-sync-alt"></i> Refresh
            </a>
        </div>
    </div>
    
    {{-- Filter Section --}}
    <div class="card-filter">
        <form action="{{ route('admin.jadwal.index') }}" method="GET" class="filter-form">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="kelas_id"><i class="fas fa-layer-group"></i> Filter Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="filter-input" onchange="this.form.submit()">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas_filter as $k)
                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="praktikum_id"><i class="fas fa-flask"></i> Filter Praktikum</label>
                    <select name="praktikum_id" id="praktikum_id" class="filter-input" onchange="this.form.submit()">
                        <option value="">Semua Praktikum</option>
                        @foreach($praktikum_filter as $p)
                            <option value="{{ $p->id }}" {{ request('praktikum_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_praktikum }} ({{ $p->praktikum_ke }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group search-group">
                    <label for="search"><i class="fas fa-search"></i> Cari Jadwal</label>
                    <div class="search-input-wrapper">
                        <input type="text" name="search" id="search" class="filter-input" 
                               placeholder="Cari Mata Kuliah, Praktikum..." value="{{ request('search') }}">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            @if(request('search'))
            <div class="filter-reset">
                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-sm btn-secondary">
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
                        <th width="15%">Waktu</th>
                        <th width="10%">Kelas</th>
                        <th width="20%">Mata Kuliah</th>
                        <th width="20%">Praktikum</th>
                        <th width="20%">Instruktur</th>
                        <th class="text-center" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwal as $index => $j)
                    <tr>
                        <td class="text-center">{{ $jadwal->firstItem() + $index }}</td>
                        <td>
                            <div class="time-info">
                                <span class="day-badge">{{ $j->hari }}</span>
                                <span class="time-range">
                                    <i class="far fa-clock"></i> {{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <span class="info-badge class-badge">
                                {{ $j->kelas->nama_kelas ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <div class="mata-kuliah-info">
                                <span class="d-block fw-bold" style="color: #0f766e; font-size: 0.95em;">{{ $j->mata_kuliah ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="praktikum-info">
                                <span class="p-name">{{ $j->praktikum->nama_praktikum ?? '-' }}</span>
                                <span class="p-romawi">Praktikum {{ $j->praktikum->praktikum_ke ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="user-info-mini">
                                <div class="avatar-mini">{{ substr($j->instruktur->nama ?? 'U', 0, 1) }}</div>
                                <span>{{ $j->instruktur->nama ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="action-cell justify-content-center">
                                <a href="{{ route('admin.jadwal.show', $j->id) }}" class="btn-action view" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.jadwal.edit', $j->id) }}" class="btn-action edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.jadwal.destroy', $j->id) }}" method="POST" 
                                      onsubmit="return confirm('Yakin hapus jadwal ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <p>Tidak ada jadwal praktikum ditemukan</p>
                            @if(request('search'))
                                <small>Coba reset filter pencarian Anda</small>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($jadwal->hasPages())
        <div class="pagination-wrapper">
            {{ $jadwal->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
/* =====================================================
   JADWAL INDEX STYLES - TEAL THEME
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

.header-actions {
    display: flex;
    gap: 0.75rem;
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
    max-width: 400px;
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

.filter-input {
    width: 100%;
    padding: 0.625rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.875rem;
    color: #334155;
    background: white;
    transition: all 0.2s;
}

.filter-input:focus {
    border-color: #14b8a6;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
    outline: none;
}

.search-input-wrapper {
    display: flex;
}

.search-input-wrapper .filter-input {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border-right: none;
}

.search-btn {
    padding: 0 1.25rem;
    background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
    color: white;
    border: none;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
}

.search-btn:hover {
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
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

/* Specific Badges */
.time-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    align-items: flex-start;
}

.day-badge {
    background: #0f766e;
    color: white;
    padding: 0.15rem 0.6rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
}

.time-range {
    color: #64748b;
    font-size: 0.8125rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.info-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.6rem;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.class-badge { background: #e0f2fe; color: #0284c7; }
.room-badge { background: #fef3c7; color: #d97706; }

.praktikum-info {
    display: flex;
    flex-direction: column;
}

.p-name { font-weight: 600; color: #334155; font-size: 0.9375rem; }
.p-romawi { font-size: 0.75rem; color: #64748b; }

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
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.875rem;
}

.btn-action.view { background: #dcfce7; color: #16a34a; }
.btn-action.view:hover { background: #bbf7d0; transform: translateY(-2px); }

.btn-action.edit { background: #e0e7ff; color: #4338ca; }
.btn-action.edit:hover { background: #c7d2fe; transform: translateY(-2px); }

.btn-action.delete { background: #fee2e2; color: #b91c1c; }
.btn-action.delete:hover { background: #fecaca; transform: translateY(-2px); }

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
    padding: 0.625rem 1rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
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
    .card-header {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
        text-align: center;
    }

    .card-title {
        justify-content: center;
    }

    .header-actions {
        width: 100%;
        flex-direction: column;
    }

    .header-actions .btn {
        width: 100%;
        justify-content: center;
    }

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
.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
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
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}

.btn-danger:hover {
    box-shadow: 0 6px 16px rgba(220, 38, 38, 0.4);
    transform: translateY(-2px);
}
</style>
@endpush
