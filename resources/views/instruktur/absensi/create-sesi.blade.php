@extends('layouts.instruktur')

@section('title', 'Tambah Sesi')

@section('content')
<div class="form-container">
    {{-- Form Header --}}
    <div class="form-header">
        <div class="form-header-icon">
            <i class="fas fa-calendar-plus"></i>
        </div>
        <div class="form-header-text">
            <h2>Tambah Sesi Pertemuan</h2>
            <p>{{ $jadwal->praktikum->nama_praktikum ?? '-' }} - {{ $jadwal->kelas->nama_kelas ?? '-' }}</p>
        </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('instruktur.absensi.store-sesi', $jadwal) }}" method="POST" class="form-card">
        @csrf
        
        <div class="form-group">
            <label for="pertemuan_ke">Pertemuan Ke <span class="required">*</span></label>
            <input type="number" name="pertemuan_ke" id="pertemuan_ke" 
                   value="{{ old('pertemuan_ke', $nextPertemuan) }}" 
                   min="1" required class="form-control">
            @error('pertemuan_ke')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal <span class="required">*</span></label>
            <input type="date" name="tanggal" id="tanggal" 
                   value="{{ old('tanggal', date('Y-m-d')) }}" 
                   required class="form-control">
            @error('tanggal')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="materi">Materi (Opsional)</label>
            <input type="text" name="materi" id="materi" 
                   value="{{ old('materi') }}" 
                   placeholder="Contoh: Pengenalan Dasar" 
                   class="form-control">
            @error('materi')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('instruktur.absensi.sesi', $jadwal) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Simpan Sesi
            </button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
/* =====================================================
   FORM STYLES
   ===================================================== */

.form-container {
    max-width: 600px;
    margin: 0 auto;
}

.form-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
    border-radius: 16px;
    color: white;
    margin-bottom: 1.5rem;
}

.form-header-icon {
    width: 56px;
    height: 56px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.form-header-text h2 {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.form-header-text p {
    font-size: 0.875rem;
    opacity: 0.9;
}

.form-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-group label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
}

.required {
    color: #ef4444;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.9375rem;
    color: #0f172a;
    transition: all 0.2s ease;
}

.form-control:focus {
    outline: none;
    border-color: #0891b2;
    box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1);
}

.error-text {
    display: block;
    font-size: 0.8125rem;
    color: #ef4444;
    margin-top: 0.375rem;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-size: 0.9375rem;
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

@media (max-width: 640px) {
    .form-actions {
        flex-direction: column-reverse;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

