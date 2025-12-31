@extends('layouts.mahasiswa')

@section('title', 'Kartu Kontrol')

@section('breadcrumb')
    <span>/</span>
    <span>Kartu Kontrol</span>
@endsection

@section('content')
<div class="kartu-kontrol-container">
    {{-- Header --}}
    <div class="page-header">
        <div class="header-content">
            <div class="header-icon">
                <i class="fas fa-id-card"></i>
            </div>
            <div class="header-text">
                <h2>Kartu Kontrol Praktikum</h2>
                <p>Setiap mata kuliah dalam praktikum memiliki kartu kontrol masing-masing</p>
            </div>
        </div>
    </div>

    {{-- List Kartu Kontrol --}}
    @if($kartuKontrolList->count() > 0)
        {{-- Group by Periode --}}
        @php
            $groupedByPeriode = $kartuKontrolList->groupBy(function($item) {
                return $item['periode']->id ?? 0;
            });
        @endphp

        @foreach($groupedByPeriode as $periodeId => $items)
            @php
                $periode = $items->first()['periode'];
            @endphp
            <div class="periode-section">
                <div class="periode-header">
                    <h3>
                        <i class="fas fa-calendar-alt"></i>
                        Praktikum {{ $periode->praktikum_ke_romawi ?? $periode->praktikum_ke }} 
                        - {{ $periode->tahun_akademik }} / {{ $periode->semester }}
                    </h3>
                    <span class="badge-count">{{ $items->count() }} Mata Kuliah</span>
                </div>

                <div class="cards-grid">
                    @foreach($items as $item)
                    <div class="kartu-card">
                        <div class="kartu-header">
                            <div class="kartu-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div class="kartu-badge">
                                <span>{{ $item['jadwal']->hari ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="kartu-body">
                            <h3 class="kartu-title">{{ $item['mata_kuliah'] ?? 'Mata Kuliah' }}</h3>
                            <div class="kartu-info">
                                <div class="info-item">
                                    <i class="fas fa-layer-group"></i>
                                    <span>Kelas {{ $item['kelas']->nama_kelas ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ substr($item['jadwal']->jam_mulai, 0, 5) ?? '-' }} - {{ substr($item['jadwal']->jam_selesai, 0, 5) ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                    <span>{{ $item['jadwal']->instruktur->nama ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-door-open"></i>
                                    <span>{{ $item['jadwal']->ruangan->nama_ruangan ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="kartu-footer">
                            <a href="{{ route('mahasiswa.kartu-kontrol.show', [$item['pendaftaran']->id, $item['jadwal']->id]) }}" class="btn-view">
                                <i class="fas fa-eye"></i> Lihat Kartu
                            </a>
                            <a href="{{ route('mahasiswa.kartu-kontrol.pdf', [$item['pendaftaran']->id, $item['jadwal']->id]) }}" class="btn-print" target="_blank">
                                <i class="fas fa-print"></i> Cetak
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-id-card"></i>
            </div>
            <h3>Belum Ada Kartu Kontrol</h3>
            <p>Kartu kontrol akan tersedia setelah pendaftaran praktikum Anda disetujui dan jadwal tersedia.</p>
            <a href="{{ route('mahasiswa.pendaftaran.index') }}" class="btn-primary">
                <i class="fas fa-clipboard-list"></i> Lihat Pendaftaran
            </a>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.kartu-kontrol-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Page Header */
.page-header {
    background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
    border-radius: 16px;
    padding: 2rem;
    color: white;
    box-shadow: 0 10px 30px rgba(15, 118, 110, 0.2);
}

.header-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.header-icon {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    backdrop-filter: blur(10px);
}

.header-text h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.header-text p {
    opacity: 0.9;
    font-size: 0.9375rem;
}

/* Periode Section */
.periode-section {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

.periode-header {
    background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
    padding: 1rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e0f2f1;
}

.periode-header h3 {
    font-size: 1rem;
    font-weight: 700;
    color: #0f766e;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.badge-count {
    background: #0f766e;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}

/* Cards Grid */
.cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    padding: 1.5rem;
}

.kartu-card {
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid #f1f5f9;
    transition: all 0.3s ease;
}

.kartu-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    border-color: #0d9488;
}

.kartu-header {
    background: #f8fafc;
    padding: 1rem 1.25rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #f1f5f9;
}

.kartu-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    box-shadow: 0 4px 8px rgba(13, 148, 136, 0.25);
}

.kartu-badge span {
    background: #e0f2fe;
    color: #0284c7;
    padding: 0.25rem 0.6rem;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 600;
}

.kartu-body {
    padding: 1.25rem;
}

.kartu-title {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
    line-height: 1.3;
}

.kartu-info {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8125rem;
    color: #64748b;
}

.info-item i {
    width: 14px;
    color: #0d9488;
    font-size: 0.75rem;
}

.kartu-footer {
    padding: 1rem 1.25rem;
    background: #fafafa;
    border-top: 1px solid #f1f5f9;
    display: flex;
    gap: 0.5rem;
}

.btn-view, .btn-print {
    flex: 1;
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    transition: all 0.2s;
}

.btn-view {
    background: #0f766e;
    color: white;
}

.btn-view:hover {
    background: #0d9488;
    transform: translateY(-1px);
}

.btn-print {
    background: white;
    color: #0f766e;
    border: 1px solid #0f766e;
}

.btn-print:hover {
    background: #f0fdfa;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: #f1f5f9;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: #94a3b8;
    margin: 0 auto 1.5rem;
}

.empty-state h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #64748b;
    margin-bottom: 2rem;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

.btn-primary {
    background: #0f766e;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.btn-primary:hover {
    background: #0d9488;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        text-align: center;
    }
    
    .cards-grid {
        grid-template-columns: 1fr;
        padding: 1rem;
    }
    
    .periode-header {
        flex-direction: column;
        gap: 0.5rem;
        text-align: center;
    }
}
</style>
@endpush
