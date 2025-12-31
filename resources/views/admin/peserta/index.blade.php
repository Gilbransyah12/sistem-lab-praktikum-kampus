@extends('layouts.admin')

@section('title', 'Data Peserta')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-users"></i>
            Daftar Peserta
        </h3>
        <div class="header-actions">
            <a href="{{ route('admin.peserta.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Peserta
            </a>
            <a href="{{ route('admin.peserta.export', request()->query()) }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('admin.peserta.export-pdf', request()->query()) }}" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <a href="{{ route('admin.peserta.print-kartu-kontrol', request()->query()) }}" class="btn btn-info">
                <i class="fas fa-print"></i> Cetak Semua Kartu
            </a>
        </div>
    </div>
    
    {{-- Filter Section --}}
    <div class="card-filter">
        <form action="{{ route('admin.peserta.index') }}" method="GET" class="filter-form">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="kelas_id"><i class="fas fa-filter"></i> Filter Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label for="praktikum_id"><i class="fas fa-flask"></i> Filter Praktikum</label>
                    <select name="praktikum_id" id="praktikum_id" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Praktikum</option>
                        @foreach($praktikumList as $praktikum)
                            <option value="{{ $praktikum->id }}" {{ request('praktikum_id') == $praktikum->id ? 'selected' : '' }}>
                                {{ $praktikum->praktikum_ke }} - {{ $praktikum->nama_praktikum }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group search-group">
                    <label for="search"><i class="fas fa-search"></i> Cari Peserta</label>
                    <div class="search-input-wrapper">
                        <input type="text" name="search" id="search" class="filter-input" 
                               placeholder="Cari NIM atau Nama..." value="{{ request('search') }}">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            @if(request('kelas_id') || request('praktikum_id') || request('search'))
            <div class="filter-reset">
                <a href="{{ route('admin.peserta.index') }}" class="btn btn-sm btn-secondary">
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
                        <th class="text-center" width="5%">No</th>
                        <th width="25%">Peserta</th>
                        <th width="20%">Kelas & Praktikum</th>
                        <th width="13%" class="text-center">Kontak</th>
                        <th width="10%" class="text-center">Berkas</th>
                        <th width="15%" class="text-center">Tanggal Daftar</th>
                        <th width="12%" class="text-center">Aksi</th>
                </thead>
                <tbody>
                    @forelse($peserta as $index => $p)
                    <tr>
                        <td class="text-center">{{ $peserta->firstItem() + $index }}</td>
                        <td>
                            <div class="user-info">
                                <div class="avatar-circle">{{ substr($p->nama ?? 'U', 0, 1) }}</div>
                                <div>
                                    <span class="user-name">{{ $p->nama }}</span>
                                    <span class="user-sub">{{ $p->nim }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="meta-tags" style="display: flex; align-items: center; white-space: nowrap;">
                                @php
                                    $romans = [1=>'I', 2=>'II', 3=>'III', 4=>'IV', 5=>'V', 6=>'VI', 7=>'VII', 8=>'VIII'];
                                    $kelas = $p->kelas->nama_kelas ?? '-';
                                    $praktikum = $p->praktikum ? ($romans[$p->praktikum->praktikum_ke] ?? $p->praktikum->praktikum_ke) : '-';
                                    $namaPraktikum = $p->praktikum->nama_praktikum ?? '';
                                @endphp
                                
                                <span class="meta-badge combined-badge">
                                    <i class="fas fa-layer-group" style="margin-right: 6px;"></i> 
                                    <strong>{{ $kelas }}</strong> - <span>Praktikum {{ $praktikum }}</span>
                                </span>
                            </div>
                        </td>
                        <td class="text-center">
                            @if($p->no_hp_wa)
                                <a href="https://wa.me/{{ $p->no_hp_wa }}" target="_blank" class="btn-wa">
                                    <i class="fab fa-whatsapp"></i> {{ $p->no_hp_wa }}
                                </a>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="file-actions">
                                {{-- Kartu Kontrol View --}}
                                <a href="{{ route('admin.peserta.kartu-kontrol', $p->id) }}" 
                                   class="btn-icon-file kartu-kontrol" title="Lihat Kartu Kontrol">
                                    <i class="fas fa-id-card"></i>
                                </a>
                                {{-- Bukti Pembayaran --}}
                                @if($p->berkas_path)
                                    <a href="{{ asset('storage/' . $p->berkas_path) }}" target="_blank" class="btn-icon-file bukti-bayar" title="Bukti Pembayaran">
                                        <i class="fas fa-receipt"></i>
                                    </a>
                                @endif
                                {{-- KRS --}}
                                @if($p->krs_path)
                                    <a href="{{ asset('storage/' . $p->krs_path) }}" target="_blank" class="btn-icon-file krs" title="KRS">
                                        <i class="fas fa-file-alt"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="date-badge">
                                {{ $p->tanggal_daftar?->format('d/m/Y') ?? '-' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="action-cell justify-content-center">
                                <a href="{{ route('admin.peserta.edit', $p->peserta_id) }}" class="btn-action edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- Kita pakai form pendaftaran saja untuk hapus atau sesuaikan dengan route --}}
                                <form action="{{ route('admin.peserta.destroy', $p->peserta_id) }}" method="POST" 
                                      onsubmit="return confirm('Yakin hapus peserta ini?')" style="display:inline;">
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
                                <i class="fas fa-users-slash"></i>
                            </div>
                            <p>Tidak ada data peserta ditemukan</p>
                            @if(request('kelas_id') || request('search'))
                                <small>Coba reset filter pencarian Anda</small>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($peserta->hasPages())
        <div class="pagination-wrapper">
            {{ $peserta->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
/* =====================================================
   PESERTA INDEX STYLES - CYAN THEME
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
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
    align-items: end;
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

.filter-select, .filter-input {
    width: 100%;
    padding: 0.625rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.875rem;
    color: #334155;
    background: white;
    transition: all 0.2s;
}

.filter-select:focus, .filter-input:focus {
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
    margin-top: 1rem;
    display: flex;
    justify-content: flex-end;
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

/* User Info */
.user-info {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    justify-content: flex-start !important;
    gap: 1rem;
}

.avatar-circle {
    width: 42px;
    height: 42px;
    background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: #475569;
    font-size: 1.125rem;
    flex-shrink: 0;
}

.user-name {
    display: block;
    font-weight: 600;
    color: #1e293b;
    font-size: 0.9375rem;
}

.user-sub {
    display: block;
    font-size: 0.8125rem;
    color: #94a3b8;
}

/* Meta Tags */
.meta-tags {
    display: flex;
    align-items: center;
    white-space: nowrap;
}

.meta-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
}

.class-badge { background: #e0f2fe; color: #0284c7; }
.praktikum-badge { background: #f0fdfa; color: #0d9488; }
.combined-badge { 
    background: #f1f5f9; 
    color: #334155; 
    border: 1px solid #e2e8f0;
    font-size: 0.8125rem;
}
.combined-badge .text-muted {
    color: #64748b;
    font-weight: 500;
    margin-left: 4px;
}

/* Contact & Files */
.btn-wa {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: #dcfce7;
    color: #16a34a;
    padding: 0.375rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.8125rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-wa:hover {
    background: #bbf7d0;
    transform: scale(1.05);
}

.file-actions {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
}

.btn-icon-file {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    background: #f1f5f9;
    transition: all 0.2s;
}

.btn-icon-file:hover {
    background: #e2e8f0;
    color: #0f172a;
}

.btn-icon-file.kartu-kontrol {
    background: #dcfce7;
    color: #16a34a;
}

.btn-icon-file.kartu-kontrol:hover {
    background: #bbf7d0;
    color: #15803d;
    transform: scale(1.05);
}

.date-badge {
    font-family: monospace;
    color: #64748b;
    background: #f8fafc;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
}

/* Action Buttons */
.action-cell {
    display: flex;
    gap: 0.5rem;
}

.btn-action {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.875rem;
}

.btn-action.edit { background: #e0e7ff; color: #4338ca; }
.btn-action.edit:hover { background: #c7d2fe; transform: translateY(-2px); }

.btn-action.delete { background: #fee2e2; color: #b91c1c; }
.btn-action.delete:hover { background: #fecaca; transform: translateY(-2px); }

/* Buttons */
.btn-primary {
    background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
    color: white;
    border: none;
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
}

.btn-primary:hover {
    box-shadow: 0 6px 16px rgba(20, 184, 166, 0.4);
    transform: translateY(-2px);
}

.btn-success {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    color: white;
    border: none;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-info {
    background: linear-gradient(135deg, #0284c7 0%, #0ea5e9 100%);
    color: white;
    border: none;
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
}

.btn-info:hover {
    box-shadow: 0 6px 16px rgba(14, 165, 233, 0.4);
    transform: translateY(-2px);
}

.btn-danger {
    background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
    color: white;
    border: none;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.btn-danger:hover {
    box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
    transform: translateY(-2px);
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

.pagination-wrapper {
    padding: 1.5rem 2rem;
    border-top: 1px solid #f1f5f9;
}

/* Responsive */
@media (max-width: 768px) {
    .card-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .header-actions {
        flex-direction: column;
    }
    
    .filter-grid {
        grid-template-columns: 1fr;
    }
    
    .premium-table td, .premium-table th {
        padding: 1rem;
    }
    
    .meta-tags {
        flex-direction: row;
        flex-wrap: wrap;
    }
}
</style>
@endpush
