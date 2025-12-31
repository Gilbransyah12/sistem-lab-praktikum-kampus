@extends('layouts.mahasiswa')

@section('title', 'Sertifikat Praktikum')

@section('breadcrumb')
    <span>/</span>
    <span>Sertifikat</span>
@endsection

@section('content')
{{-- Page Header --}}
<div class="page-header">
    <div class="header-content">
        <div class="header-info">
            <h2 class="header-title">
                <i class="fas fa-certificate"></i>
                Sertifikat Saya
            </h2>
            <p class="header-subtitle">Kumpulan sertifikat praktikum yang telah Anda selesaikan</p>
        </div>
        <div class="stat-badge">
            <i class="fas fa-award"></i>
            <span>{{ $sertifikats->count() }} Sertifikat</span>
        </div>
    </div>
</div>

{{-- Sertifikat Grid --}}
@if($sertifikats->count() > 0)
<div class="sertifikat-grid">
    @foreach($sertifikats as $s)
    <div class="sertifikat-card">
        <div class="card-header">
            <div class="icon-wrapper">
                <i class="fas fa-file-certificate"></i>
            </div>
            <span class="status-chip valid">
                <i class="fas fa-check-circle"></i> Valid
            </span>
        </div>
        
        <div class="card-body">
            <h3 class="praktikum-name">{{ $s->pendaftaran->praktikum->nama_praktikum ?? '-' }}</h3>
            <p class="periode-name">{{ $s->pendaftaran->periode->nama_periode ?? '-' }}</p>
            
            <div class="meta-info">
                <div class="meta-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Terbit: {{ $s->tanggal_terbit->format('d M Y') }}</span>
                </div>

            </div>
        </div>
        
        <div class="card-footer">
            <a href="{{ route('mahasiswa.sertifikat.print', $s->id) }}" target="_blank" class="btn btn-primary btn-block">
                <i class="fas fa-download"></i> Unduh / Cetak
            </a>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <div class="empty-icon">
        <i class="fas fa-award"></i>
    </div>
    <h3>Belum Ada Sertifikat</h3>
    <p>Anda belum memiliki sertifikat praktikum yang diterbitkan. Sertifikat akan muncul setelah Anda menyelesaikan praktikum dan dinyatakan lulus.</p>
</div>
@endif
@endsection

@push('styles')
<style>
/* Header */
.page-header {
    margin-bottom: 2rem;
}

.header-content {
    background: white;
    padding: 1.5rem;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.header-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.25rem;
}

.header-title i {
    color: #0d9488;
}

.header-subtitle {
    color: #64748b;
    font-size: 0.875rem;
}

.stat-badge {
    background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
    color: #0d9488;
    padding: 0.5rem 1rem;
    border-radius: 9999px;
    font-weight: 600;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Grid */
.sertifikat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

/* Card */
.sertifikat-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #f1f5f9;
}

.sertifikat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 15px -3px rgba(13, 148, 136, 0.1);
    border-color: #ccfbf1;
}

.card-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    display: flex;
    justify-content: space-between;
    align-items: start;
    position: relative;
    overflow: hidden;
}

.card-header::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: url("data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'%3E%3Ccircle cx='3' cy='3' r='3'/%3E%3Ccircle cx='13' cy='13' r='3'/%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.3;
}

.icon-wrapper {
    width: 48px;
    height: 48px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(4px);
}

.icon-wrapper i {
    font-size: 1.5rem;
    color: #2dd4bf;
}

.status-chip {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.status-chip.valid {
    background: rgba(34, 197, 94, 0.2);
    color: #4ade80;
    border: 1px solid rgba(34, 197, 94, 0.3);
}

.card-body {
    padding: 1.5rem;
}

.praktikum-name {
    font-size: 1.125rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.25rem;
    line-height: 1.4;
}

.periode-name {
    color: #64748b;
    font-size: 0.875rem;
    margin-bottom: 1.25rem;
}

.meta-info {
    background: #f8fafc;
    border-radius: 8px;
    padding: 0.75rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8125rem;
    color: #475569;
}

.meta-item i {
    color: #0d9488;
    width: 16px;
}

.card-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #f1f5f9;
}

.btn-block {
    display: flex;
    width: 100%;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-primary {
    background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
    color: white;
    box-shadow: 0 4px 6px -1px rgba(13, 148, 136, 0.2);
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 8px -1px rgba(13, 148, 136, 0.3);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 16px;
    border: 2px dashed #e2e8f0;
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

.empty-state h3 {
    color: #1e293b;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #64748b;
    max-width: 400px;
    margin: 0 auto;
}

@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
}
</style>
@endpush
