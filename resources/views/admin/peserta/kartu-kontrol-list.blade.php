@extends('layouts.admin')

@section('title', 'Kartu Kontrol - ' . ($user->nama ?? 'Peserta'))

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-id-card"></i>
            Pilih Kartu Kontrol - {{ $user->nama ?? 'Peserta' }}
        </h3>
        <div class="header-actions">
            <a href="{{ route('admin.peserta.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    
    <div class="card-body">
        {{-- Student Info --}}
        <div class="student-info-card">
            <div class="info-row">
                <span class="label">NIM:</span>
                <span class="value">{{ $user->nim ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Nama:</span>
                <span class="value">{{ $user->nama ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Kelas:</span>
                <span class="value">{{ $pendaftaran->kelas->nama_kelas ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Periode:</span>
                <span class="value">Praktikum {{ $pendaftaran->periode->praktikum_ke_romawi ?? $pendaftaran->periode->praktikum_ke }}</span>
            </div>
        </div>

        @if($jadwalList->count() > 0)
            <h4 style="margin: 1.5rem 0 1rem; color: #1e293b; font-weight: 600;">
                <i class="fas fa-book-open" style="color: #0f766e; margin-right: 0.5rem;"></i>
                Daftar Mata Kuliah ({{ $jadwalList->count() }} Kartu Kontrol)
            </h4>
            
            <div class="jadwal-grid">
                @foreach($jadwalList as $jadwal)
                <div class="jadwal-card">
                    <div class="jadwal-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="jadwal-info">
                        <h5>{{ $jadwal->mata_kuliah }}</h5>
                        <div class="jadwal-meta">
                            <span><i class="fas fa-clock"></i> {{ $jadwal->hari }} {{ substr($jadwal->jam_mulai, 0, 5) }}-{{ substr($jadwal->jam_selesai, 0, 5) }}</span>
                            <span><i class="fas fa-chalkboard-teacher"></i> {{ $jadwal->instruktur->nama ?? '-' }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.peserta.kartu-kontrol', [$pendaftaran->id, $jadwal->id]) }}" 
                       class="btn-view-kartu">
                        <i class="fas fa-print"></i> Lihat & Cetak
                    </a>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-jadwal">
                <i class="fas fa-calendar-times"></i>
                <p>Belum ada jadwal tersedia untuk periode ini.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #f1f5f9;
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
}

.card-body {
    padding: 2rem;
}

.student-info-card {
    background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
    border-radius: 12px;
    padding: 1.25rem 1.5rem;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.info-row {
    display: flex;
    gap: 0.5rem;
}

.info-row .label {
    color: #64748b;
    font-size: 0.875rem;
}

.info-row .value {
    font-weight: 600;
    color: #0f766e;
}

.jadwal-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1rem;
}

.jadwal-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    transition: all 0.2s;
}

.jadwal-card:hover {
    border-color: #0d9488;
    box-shadow: 0 4px 12px rgba(13, 148, 136, 0.1);
}

.jadwal-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.jadwal-info {
    flex: 1;
}

.jadwal-info h5 {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.jadwal-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    font-size: 0.75rem;
    color: #64748b;
}

.jadwal-meta span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.jadwal-meta i {
    color: #0d9488;
}

.btn-view-kartu {
    background: #dcfce7;
    color: #16a34a;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    transition: all 0.2s;
    white-space: nowrap;
}

.btn-view-kartu:hover {
    background: #bbf7d0;
    transform: translateY(-1px);
}

.empty-jadwal {
    text-align: center;
    padding: 3rem;
    color: #94a3b8;
}

.empty-jadwal i {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.btn-secondary {
    background: #64748b;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    font-size: 0.875rem;
}

.btn-secondary:hover {
    background: #475569;
}

@media (max-width: 768px) {
    .jadwal-grid {
        grid-template-columns: 1fr;
    }
    
    .jadwal-card {
        flex-direction: column;
        text-align: center;
    }
    
    .jadwal-meta {
        justify-content: center;
    }
}
</style>
@endpush
