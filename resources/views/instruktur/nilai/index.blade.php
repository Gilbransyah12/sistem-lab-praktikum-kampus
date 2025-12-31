@extends('layouts.instruktur')

@section('title', 'Penilaian')

@section('content')
{{-- Page Header --}}
<div class="page-header">
    <div class="header-content">
        <div class="header-info">
            <h2 class="header-title">
                <i class="fas fa-star"></i>
                Manajemen Nilai
            </h2>
            <p class="header-subtitle">Kelola nilai mahasiswa untuk setiap kelas praktikum</p>
        </div>
    </div>
</div>

{{-- Filter Section --}}
<div class="card-filter" style="margin-bottom: 1.5rem; background: white; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);">
    <form action="{{ route('instruktur.nilai.index') }}" method="GET" class="filter-form">
        <div class="filter-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem;">
            <div class="filter-group">
                <label for="kelas_id" style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem; font-weight: 600; color: #64748b;">
                    <i class="fas fa-filter" style="color: #0891b2; margin-right: 0.25rem;"></i> Filter Kelas
                </label>
                <select name="kelas_id" id="kelas_id" class="filter-select" onchange="this.form.submit()" style="width: 100%; padding: 0.625rem 1rem; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.875rem; color: #334155;">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label for="praktikum_id" style="display: block; margin-bottom: 0.5rem; font-size: 0.875rem; font-weight: 600; color: #64748b;">
                    <i class="fas fa-flask" style="color: #0891b2; margin-right: 0.25rem;"></i> Filter Praktikum
                </label>
                <select name="praktikum_id" id="praktikum_id" class="filter-select" onchange="this.form.submit()" style="width: 100%; padding: 0.625rem 1rem; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.875rem; color: #334155;">
                    <option value="">Semua Praktikum</option>
                    @foreach($praktikumList as $p)
                        <option value="{{ $p->id }}" {{ request('praktikum_id') == $p->id ? 'selected' : '' }}>
                            Praktikum {{ $p->praktikum_ke }} - {{ $p->nama_praktikum }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        @if(request('kelas_id') || request('praktikum_id'))
        <div class="filter-reset" style="margin-top: 1rem; display: flex; justify-content: flex-end;">
            <a href="{{ route('instruktur.nilai.index') }}" class="btn btn-sm btn-secondary" style="background: #f1f5f9; color: #64748b; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-size: 0.8125rem; font-weight: 600;">
                <i class="fas fa-times" style="margin-right: 0.5rem;"></i> Reset Filter
            </a>
        </div>
        @endif
    </form>
</div>

{{-- Jadwal Cards --}}
@if($jadwal->count() > 0)
<div class="jadwal-cards">
    @foreach($jadwal as $j)
    <div class="jadwal-card">
        <div class="card-icon">
            <i class="fas fa-flask"></i>
        </div>
        <div class="card-content">
            <h3>{{ $j->praktikum->nama_praktikum ?? '-' }}</h3>
            <p class="card-subtitle">{{ $j->kelas->nama_kelas ?? '-' }}</p>
        </div>
        <div class="card-action">
            <a href="{{ route('instruktur.nilai.show', $j) }}" class="btn btn-primary">
                <i class="fas fa-eye"></i>
                Lihat Nilai
            </a>
            <a href="{{ route('instruktur.nilai.edit', $j) }}" class="btn btn-secondary">
                <i class="fas fa-edit"></i>
                Input Nilai
            </a>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state-card">
    <div class="empty-icon">
        <i class="fas fa-star-half-alt"></i>
    </div>
    <h3>Belum Ada Jadwal</h3>
    <p>Anda belum memiliki jadwal praktikum yang aktif.</p>
</div>
@endif
@endsection

@push('styles')
<style>
/* =====================================================
   NILAI INDEX STYLES
   ===================================================== */

.page-header {
    margin-bottom: 1.5rem;
}

.header-content {
    background: white;
    padding: 1.5rem;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.header-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.375rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.25rem;
}

.header-title i {
    color: #f59e0b;
}

.header-subtitle {
    color: #64748b;
    font-size: 0.875rem;
}

/* Jadwal Cards */
.jadwal-cards {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.jadwal-card {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    padding: 1.5rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid transparent;
    transition: all 0.3s ease;
}

.jadwal-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(6, 182, 212, 0.12);
    border-color: rgba(6, 182, 212, 0.2);
}

.card-icon {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.card-content {
    flex: 1;
}

.card-content h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.25rem;
}

.card-subtitle {
    font-size: 0.875rem;
    color: #64748b;
}

.card-action {
    display: flex;
    gap: 0.5rem;
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
    border-color: #0891b2;
    color: #0891b2;
}

/* Empty State */
.empty-state-card {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.empty-icon i {
    font-size: 2.5rem;
    color: #f59e0b;
}

.empty-state-card h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.5rem;
}

.empty-state-card p {
    color: #64748b;
}

/* Responsive */
@media (max-width: 768px) {
    .jadwal-card {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .card-action {
        width: 100%;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
    }
    
    .card-action .btn {
        flex: 1;
        justify-content: center;
    }
}
</style>
@endpush

