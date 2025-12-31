@extends('layouts.instruktur')

@section('title', 'Input Absensi')

@section('content')
{{-- Page Header --}}
<div class="page-header">
    <div class="header-card">
        <div class="header-icon">
            <i class="fas fa-clipboard-check"></i>
        </div>
        <div class="header-info">
            <h2>Absensi Pertemuan {{ $sesi->pertemuan_ke }}</h2>
            <p>{{ $sesi->jadwal->praktikum->nama_praktikum ?? '-' }} • {{ \Carbon\Carbon::parse($sesi->tanggal)->format('d F Y') }}</p>
            @if($sesi->materi)
            <span class="materi-badge"><i class="fas fa-book"></i> {{ $sesi->materi }}</span>
            @endif
        </div>
    </div>
</div>

{{-- Absensi Form --}}
<form action="{{ route('instruktur.absensi.store-absen', $sesi) }}" method="POST">
    @csrf
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-users"></i>
                Daftar Peserta ({{ $pendaftaran->count() }} Mahasiswa)
            </h3>
            <div class="quick-actions">
                <button type="button" class="btn btn-sm btn-outline" onclick="setAllStatus('Hadir')">
                    <i class="fas fa-check-double"></i> Semua Hadir
                </button>
            </div>
        </div>
        <div class="card-body">
            @if($pendaftaran->count() > 0)
            <div class="absensi-list">
                @foreach($pendaftaran as $index => $p)
                <div class="absensi-item">
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
                    <div class="absensi-controls">
                        <input type="hidden" name="absensi[{{ $index }}][pendaftaran_id]" value="{{ $p->id }}">
                        
                        <div class="status-options">
                            <label class="status-option hadir">
                                <input type="radio" name="absensi[{{ $index }}][status]" value="Hadir" 
                                       {{ isset($absensi[$p->id]) && $absensi[$p->id] == 'Hadir' ? 'checked' : '' }} required>
                                <span><i class="fas fa-check"></i> Hadir</span>
                            </label>
                            <label class="status-option izin">
                                <input type="radio" name="absensi[{{ $index }}][status]" value="Izin"
                                       {{ isset($absensi[$p->id]) && $absensi[$p->id] == 'Izin' ? 'checked' : '' }}>
                                <span><i class="fas fa-file-alt"></i> Izin</span>
                            </label>
                            <label class="status-option sakit">
                                <input type="radio" name="absensi[{{ $index }}][status]" value="Sakit"
                                       {{ isset($absensi[$p->id]) && $absensi[$p->id] == 'Sakit' ? 'checked' : '' }}>
                                <span><i class="fas fa-medkit"></i> Sakit</span>
                            </label>
                            <label class="status-option alfa">
                                <input type="radio" name="absensi[{{ $index }}][status]" value="Alfa"
                                       {{ isset($absensi[$p->id]) && $absensi[$p->id] == 'Alfa' ? 'checked' : '' }}>
                                <span><i class="fas fa-times"></i> Alfa</span>
                            </label>
                        </div>
                        
                        <input type="text" name="absensi[{{ $index }}][keterangan]" 
                               placeholder="Keterangan (opsional)" class="keterangan-input">
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
        <a href="{{ route('instruktur.absensi.sesi', $sesi->jadwal) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
        @if($pendaftaran->count() > 0)
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            Simpan Absensi
        </button>
        @endif
    </div>
</form>

<script>
function setAllStatus(status) {
    document.querySelectorAll(`input[value="${status}"]`).forEach(radio => {
        radio.checked = true;
    });
}
</script>
@endsection

@push('styles')
<style>
/* =====================================================
   ABSENSI FORM STYLES
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
    margin-bottom: 0.5rem;
}

.materi-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.75rem;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 9999px;
    font-size: 0.75rem;
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
    display: flex;
    align-items: center;
    justify-content: space-between;
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

/* Absensi List */
.absensi-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.absensi-item {
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

.absensi-controls {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 1rem;
}

/* Status Options */
.status-options {
    display: flex;
    gap: 0.5rem;
}

.status-option {
    cursor: pointer;
}

.status-option input {
    display: none;
}

.status-option span {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    border: 2px solid transparent;
    transition: all 0.2s ease;
}

.status-option.hadir span {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
    border-color: rgba(16, 185, 129, 0.2);
}

.status-option.hadir input:checked + span {
    background: #10b981;
    color: white;
    border-color: #10b981;
}

.status-option.izin span {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
    border-color: rgba(245, 158, 11, 0.2);
}

.status-option.izin input:checked + span {
    background: #f59e0b;
    color: white;
    border-color: #f59e0b;
}

.status-option.sakit span {
    background: rgba(14, 165, 233, 0.1);
    color: #0284c7;
    border-color: rgba(14, 165, 233, 0.2);
}

.status-option.sakit input:checked + span {
    background: #0ea5e9;
    color: white;
    border-color: #0ea5e9;
}

.status-option.alfa span {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
    border-color: rgba(239, 68, 68, 0.2);
}

.status-option.alfa input:checked + span {
    background: #ef4444;
    color: white;
    border-color: #ef4444;
}

.keterangan-input {
    flex: 1;
    max-width: 200px;
    padding: 0.5rem 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.8125rem;
}

.keterangan-input:focus {
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

.btn-sm {
    padding: 0.5rem 0.875rem;
    font-size: 0.8125rem;
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

.btn-outline {
    background: transparent;
    color: #0891b2;
    border: 1px solid #0891b2;
}

.btn-outline:hover {
    background: #0891b2;
    color: white;
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
    .absensi-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .peserta-info {
        min-width: auto;
    }
    
    .absensi-controls {
        width: 100%;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px solid #e2e8f0;
    }
    
    .status-options {
        flex-wrap: wrap;
    }
    
    .keterangan-input {
        max-width: 100%;
        width: 100%;
    }
}

@media (max-width: 640px) {
    .header-card {
        flex-direction: column;
        text-align: center;
    }
    
    .card-header {
        flex-direction: column;
        gap: 0.75rem;
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

