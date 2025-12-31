@extends('layouts.admin')

@section('title', 'Data Praktikum')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-book"></i>
            Daftar Praktikum
        </h3>
        <div class="header-actions">
            <a href="{{ route('admin.praktikum.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Praktikum
            </a>
        </div>
    </div>
    
    {{-- Filter Section --}}
    <div class="card-filter">
        <form id="filter-form" action="{{ route('admin.praktikum.index') }}" method="GET" class="filter-form">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="praktikum_ke"><i class="fas fa-filter"></i> Filter Praktikum</label>
                    <select name="praktikum_ke" id="praktikum_ke" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Praktikum</option>
                        @foreach($praktikumOptions as $val => $label)
                            <option value="{{ $val }}" {{ request('praktikum_ke') == $val ? 'selected' : '' }}>
                                Praktikum {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            @if(request('praktikum_ke'))
            <div class="filter-reset">
                <a href="{{ route('admin.praktikum.index') }}" class="btn btn-sm btn-secondary">
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
                        <th class="text-center" width="20%">Praktikum Ke</th>
                        <th width="55%">Nama Praktikum</th>
                        <th class="text-center" width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($praktikum as $index => $p)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">
                            <span class="praktikum-badge">
                                {{ strtoupper($p->praktikum_ke) }}
                            </span>
                        </td>
                        <td>
                            <span class="praktikum-title">{{ $p->nama_praktikum }}</span>
                        </td>
                        <td class="text-center">
                            <div class="action-cell justify-content-center">
                                <a href="{{ route('admin.praktikum.edit', $p) }}" class="btn-action edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.praktikum.destroy', $p) }}" method="POST" 
                                      onsubmit="return confirm('Yakin hapus praktikum ini?')" style="display:inline;">
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
                        <td colspan="4" class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <p>Tidak ada data praktikum ditemukan</p>
                            @if(request('praktikum_ke'))
                                <small>Coba reset filter pencarian Anda</small>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($praktikum->hasPages())
        <div class="pagination-wrapper">
            {{ $praktikum->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
/* =====================================================
   PRAKTIKUM INDEX STYLES - CYAN THEME
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
    display: flex; /* Flex layout to align items if needed */
    justify-content: space-between;
    align-items: center;
}

.filter-form {
    flex: 1;
    display: flex;
    align-items: flex-end; /* Align bottom of button/input */
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-grid {
    display: flex;
    gap: 1.25rem;
    align-items: center;
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
    color: #0891b2;
    margin-right: 0.25rem;
}

.filter-select {
    min-width: 250px;
    padding: 0.625rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.875rem;
    color: #334155;
    background: white;
    transition: all 0.2s;
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

/* Badges & Titles */
.praktikum-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #f0fdfa;
    color: #0d9488;
    border: 1px solid #ccfbf1;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 700;
    font-family: monospace;
    font-size: 0.9375rem;
    min-width: 50px;
}

.praktikum-title {
    font-weight: 600;
    color: #334155;
    font-size: 1rem;
}

/* Action Buttons */
.action-cell {
    display: flex;
    gap: 0.5rem;
}

.btn-action {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.9375rem;
}

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
    
    .filter-select {
        min-width: auto;
        width: 100%;
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
