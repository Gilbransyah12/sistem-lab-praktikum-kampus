@extends('layouts.instruktur')

@section('title', 'Input Nilai')

@section('content')
{{-- Page Header --}}
<div class="page-header">
    <div class="header-card">
        <div class="header-icon">
            <i class="fas fa-edit"></i>
        </div>
        <div class="header-info">
            <h2>Input Nilai</h2>
            <p>{{ $jadwal->praktikum->nama_praktikum ?? '-' }} • {{ $jadwal->kelas->nama_kelas ?? '-' }}</p>
        </div>
    </div>
</div>

{{-- Nilai Form --}}
<form action="{{ route('instruktur.nilai.update', $jadwal) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-users"></i>
                Daftar Peserta ({{ $pendaftaran->count() }} Mahasiswa)
            </h3>
        </div>
        <div class="card-body">
            @if($pendaftaran->count() > 0)
            <div class="nilai-list">
                @foreach($pendaftaran as $index => $p)
                <div class="nilai-item">
                    <div class="peserta-number">{{ $index + 1 }}</div>
                    <div class="peserta-info">
                        <div class="peserta-avatar">
                            {{ strtoupper(substr($p->peserta->nama ?? 'P', 0, 1)) }}
                        </div>
                        <div class="peserta-details">
                            <h4>{{ $p->peserta->nama ?? '-' }}</h4>
                            <span>{{ $p->peserta->nim ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="nilai-controls">
                        <input type="hidden" name="nilai[{{ $index }}][pendaftaran_id]" value="{{ $p->id }}">
                        
                        <div class="nilai-input-group">
                            <label>Nilai Akhir</label>
                            <input type="number" name="nilai[{{ $index }}][nilai_akhir]" 
                                   value="{{ $p->nilai->nilai_akhir ?? '' }}"
                                   min="0" max="100" step="0.01"
                                   placeholder="0-100" class="nilai-input">
                        </div>
                        
                        <div class="catatan-input-group">
                            <label>Catatan</label>
                            <input type="text" name="nilai[{{ $index }}][catatan]" 
                                   value="{{ $p->nilai->catatan ?? '' }}"
                                   placeholder="Catatan (opsional)" class="catatan-input">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state">
                <i class="fas fa-users-slash"></i>
                <p>Tidak ada peserta terdaftar untuk kelas ini</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Actions --}}
    <div class="action-bar">
        <a href="{{ route('instruktur.nilai.show', $jadwal) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
        @if($pendaftaran->count() > 0)
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            Simpan Nilai
        </button>
        @endif
    </div>
</form>
@endsection

@push('styles')
<style>
/* =====================================================
   NILAI EDIT STYLES
   ===================================================== */

.page-header {
    margin-bottom: 1.5rem;
}

.header-card {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
    border-radius: 16px;
    color: white;
}

.header-icon {
    width: 64px;
    height: 64px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.header-info h2 {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.header-info p {
    font-size: 0.875rem;
    opacity: 0.9;
}

/* Card */
.card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.card-header {
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom: 1px solid #e2e8f0;
}

.card-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
    color: #0f172a;
}

.card-title i {
    color: #0891b2;
}

.card-body {
    padding: 1.5rem;
}

/* Nilai List */
.nilai-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.nilai-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}

.peserta-number {
    width: 32px;
    height: 32px;
    background: #e2e8f0;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
    color: #64748b;
    flex-shrink: 0;
}

.peserta-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    min-width: 200px;
}

.peserta-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.peserta-details h4 {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 0.125rem;
}

.peserta-details span {
    font-size: 0.75rem;
    color: #64748b;
}

.nilai-controls {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.nilai-input-group,
.catatan-input-group {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.nilai-input-group label,
.catatan-input-group label {
    font-size: 0.6875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #64748b;
}

.nilai-input {
    width: 100px;
    padding: 0.625rem 0.75rem;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 700;
    color: #0f172a;
    text-align: center;
    transition: all 0.2s ease;
}

.nilai-input:focus {
    outline: none;
    border-color: #0891b2;
    box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1);
}

.catatan-input-group {
    flex: 1;
}

.catatan-input {
    width: 100%;
    padding: 0.625rem 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.catatan-input:focus {
    outline: none;
    border-color: #0891b2;
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
}

.action-bar {
    display: flex;
    justify-content: space-between;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 2rem;
    color: #94a3b8;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 0.75rem;
    display: block;
}

/* Responsive */
@media (max-width: 1024px) {
    .nilai-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .peserta-info {
        min-width: auto;
    }
    
    .nilai-controls {
        width: 100%;
        padding-top: 0.75rem;
        border-top: 1px solid #e2e8f0;
    }
}

@media (max-width: 640px) {
    .header-card {
        flex-direction: column;
        text-align: center;
    }
    
    .nilai-controls {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .nilai-input {
        width: 100%;
    }
    
    .action-bar {
        flex-direction: column-reverse;
        gap: 0.75rem;
    }
    
    .action-bar .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

