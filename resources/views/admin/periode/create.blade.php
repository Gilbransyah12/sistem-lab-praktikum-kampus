@extends('layouts.admin')

@section('title', 'Tambah Periode')

@section('content')
<div class="page-header">
    <a href="{{ route('admin.periode.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali</span>
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Periode Pendaftaran</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.periode.store') }}" method="POST">
            @csrf
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Tahun Akademik <span class="required">*</span></label>
                    <input type="text" name="tahun_akademik" class="form-control" value="{{ old('tahun_akademik') }}" placeholder="2024/2025" required>
                    @error('tahun_akademik')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Semester <span class="required">*</span></label>
                    <select name="semester" class="form-control" required>
                        <option value="">-- Pilih Semester --</option>
                        <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                    @error('semester')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Praktikum Ke <span class="required">*</span></label>
                    <input type="number" name="praktikum_ke" class="form-control" value="{{ old('praktikum_ke') }}" min="1" placeholder="Contoh: 1" required>
                    @error('praktikum_ke')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Mulai <span class="required">*</span></label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ old('tanggal_awal') }}" required>
                    @error('tanggal_awal')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Selesai <span class="required">*</span></label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ old('tanggal_akhir') }}" required>
                    @error('tanggal_akhir')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group checkbox-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_aktif" value="1" {{ old('is_aktif') ? 'checked' : '' }}>
                    <span class="checkmark"></span>
                    <span class="checkbox-text">Aktifkan periode ini</span>
                </label>
                <p class="form-hint">Jika dicentang, periode lain akan dinonaktifkan secara otomatis.</p>
            </div>

            <div class="form-actions">
                <button type="reset" class="btn btn-secondary">
                    <i class="fas fa-undo"></i>
                    <span>Reset</span>
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    <span>Simpan Periode</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.page-header {
    margin-bottom: 1.5rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.25rem;
}

.required {
    color: #dc2626;
}

.form-error {
    display: block;
    margin-top: 0.375rem;
    font-size: 0.8125rem;
    color: #dc2626;
}

.checkbox-group {
    margin-top: 1.5rem;
}

.checkbox-label {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    font-weight: 500;
}

.checkbox-label input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: var(--primary-500);
}

.form-hint {
    margin: 0.375rem 0 0;
    font-size: 0.8125rem;
    color: var(--dark-500);
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--dark-100);
}
</style>
@endpush
@endsection
