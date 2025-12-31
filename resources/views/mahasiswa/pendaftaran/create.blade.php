@extends('layouts.mahasiswa')

@section('title', 'Daftar Praktikum')

@section('content')
<div class="page-header">
    <div class="header-content">
        <h1 class="page-title">Pendaftaran Praktikum</h1>
        <p class="page-subtitle">Ajukan pendaftaran untuk periode praktikum yang aktif</p>
    </div>
    <div class="header-breadcrumb">
        <a href="{{ route('mahasiswa.dashboard') }}">Dashboard</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('mahasiswa.pendaftaran.index') }}">Pendaftaran</a>
        <i class="fas fa-chevron-right"></i>
        <span>Baru</span>
    </div>
</div>

<div class="form-container">
    {{-- Info Card --}}
    <div class="info-card">
        <div class="info-icon">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="info-details">
            <span class="info-label">Informasi Pendaftaran</span>
            <p class="mb-0 text-white">Silakan pilih <strong>Periode / Praktikum Ke-Berapa</strong> yang ingin Anda ikuti pada formulir di bawah ini.</p>
        </div>
    </div>

    {{-- Main Form --}}
    <form action="{{ route('mahasiswa.pendaftaran.store') }}" method="POST" enctype="multipart/form-data" class="premium-form" id="pendaftaranForm">
        @csrf
        
        <div class="form-card">
            <div class="card-header">
                <h3><i class="fas fa-edit"></i> Form Pendaftaran</h3>
            </div>
            
            <div class="card-body">
                {{-- Periode Selection (Praktikum Ke) --}}
                <div class="form-group">
                    <label for="periode_id" class="form-label">Pilih Praktikum / Periode <span class="required">*</span></label>
                    <div class="select-wrapper">
                        <select name="periode_id" id="periode_id" class="form-select @error('periode_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Praktikum Ke-Berapa --</option>
                            @foreach($activePeriods as $periode)
                                <option value="{{ $periode->id }}" {{ old('periode_id') == $periode->id ? 'selected' : '' }}>
                                    Praktikum Ke-{{ $periode->praktikum_ke }} ({{ $periode->nama_periode ?? $periode->tahun_akademik }} - {{ ucfirst($periode->semester) }})
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                    <small class="form-text text-muted">Sistem akan otomatis menentukan Mata Kuliah Praktikum berdasarkan pilihan ini.</small>
                    @error('periode_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kelas Selection --}}
                <div class="form-group">
                    <label for="kelas_id" class="form-label">Kelas <span class="required">*</span></label>
                    <div class="select-wrapper">
                        <select name="kelas_id" id="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                    <small class="form-text text-muted">Pilih kelas yang Anda inginkan.</small>
                    @error('kelas_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-divider"></div>
                <h4 class="form-section-title"><i class="fas fa-file-upload"></i> Upload Berkas Peserta</h4>

                {{-- 1. Pas Foto (Kartu Kontrol Path) --}}
                <div class="form-group">
                    <label for="kartu_kontrol" class="form-label">Upload Pas Foto <span class="required">*</span></label>
                    <div class="file-upload-wrapper" id="wrapper_kartu_kontrol">
                        <input type="file" name="kartu_kontrol" id="kartu_kontrol" class="file-input" accept="image/*" required>
                        <div class="file-upload-content">
                            <div class="upload-icon">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <span class="upload-text">Upload Pas Foto</span>
                            <span class="upload-hint">Format: JPG, PNG (Max. 2MB)</span>
                            <span class="upload-filename" id="filename_kartu_kontrol"></span>
                        </div>
                    </div>
                    @error('kartu_kontrol')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 2. KRS (KRS Path) --}}
                <div class="form-group">
                    <label for="krs" class="form-label">Upload KRS <span class="required">*</span></label>
                    <div class="file-upload-wrapper" id="wrapper_krs">
                        <input type="file" name="krs" id="krs" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                        <div class="file-upload-content">
                            <div class="upload-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <span class="upload-text">Upload File KRS</span>
                            <span class="upload-hint">Format: PDF, JPG, PNG (Max. 2MB)</span>
                            <span class="upload-filename" id="filename_krs"></span>
                        </div>
                    </div>
                    @error('krs')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 3. Bukti Pembayaran (Berkas Path) --}}
                <div class="form-group">
                    <label for="berkas" class="form-label">Upload Bukti Pembayaran <span class="required">*</span></label>
                    <div class="file-upload-wrapper" id="wrapper_berkas">
                        <input type="file" name="berkas" id="berkas" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                        <div class="file-upload-content">
                            <div class="upload-icon">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <span class="upload-text">Upload Bukti Pay</span>
                            <span class="upload-hint">Format: PDF, JPG, PNG (Max. 2MB)</span>
                            <span class="upload-filename" id="filename_berkas"></span>
                        </div>
                    </div>
                    @error('berkas')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="card-footer">
                <a href="{{ route('mahasiswa.pendaftaran.index') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Kirim Pendaftaran
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
/* Same CSS as before */
.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
.page-title { font-size: 1.75rem; font-weight: 800; color: #1e293b; margin-bottom: 0.25rem; }
.page-subtitle { color: #64748b; font-size: 0.9375rem; }
.header-breadcrumb { display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #64748b; background: white; padding: 0.5rem 1rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
.header-breadcrumb a { color: #64748b; text-decoration: none; font-weight: 500; transition: color 0.2s; }
.header-breadcrumb a:hover { color: #0f766e; }
.header-breadcrumb i { font-size: 0.75rem; color: #cbd5e1; }
.info-card { background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%); border-radius: 16px; padding: 1.5rem; display: flex; align-items: center; gap: 1.25rem; color: white; margin-bottom: 2rem; box-shadow: 0 10px 25px rgba(15, 118, 110, 0.2); }
.info-icon { width: 60px; height: 60px; background: rgba(255, 255, 255, 0.2); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; backdrop-filter: blur(10px); }
.info-details { flex: 1; }
.info-label { display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; opacity: 0.9; margin-bottom: 0.25rem; }
.info-value { font-size: 1.25rem; font-weight: 700; margin-bottom: 0.25rem; }
.form-container { max-width: 800px; margin: 0 auto; }
.form-card { background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); overflow: hidden; }
.card-header { background: #f8fafc; padding: 1.25rem 2rem; border-bottom: 1px solid #e2e8f0; }
.card-header h3 { font-size: 1.125rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 0.75rem; margin: 0; }
.card-header h3 i { color: #0f766e; }
.card-body { padding: 2rem; }
.form-group { margin-bottom: 1.5rem; }
.form-label { display: block; font-weight: 600; color: #334155; margin-bottom: 0.5rem; font-size: 0.9375rem; }
.required { color: #ef4444; }
.form-divider { height: 1px; background: #e2e8f0; margin: 2rem 0 1.5rem; }
.form-section-title { font-size: 1rem; font-weight: 700; color: #0f172a; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem; }
.form-section-title i { color: #0d9488; }
.select-wrapper { position: relative; }
.form-select { width: 100%; padding: 0.75rem 1rem; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.9375rem; appearance: none; background: white; transition: all 0.2s; }
.form-select:focus { outline: none; border-color: #0d9488; box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1); }
.select-icon { position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }
.file-upload-wrapper { position: relative; border: 2px dashed #e2e8f0; border-radius: 12px; transition: all 0.2s; background: #f8fafc; cursor: pointer; }
.file-upload-wrapper:hover { border-color: #0d9488; background: #f0fdfa; }
.file-input { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10; }
.file-upload-content { padding: 1.5rem; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.5rem; }
.upload-icon { width: 44px; height: 44px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: #0d9488; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 0.25rem; }
.upload-text { font-weight: 600; color: #334155; font-size: 0.9375rem; }
.upload-hint { font-size: 0.75rem; color: #94a3b8; }
.upload-filename { margin-top: 0.5rem; font-size: 0.8125rem; color: #0f766e; font-weight: 600; background: #f0fdfa; padding: 0.2rem 0.6rem; border-radius: 999px; border: 1px solid #ccfbf1; display: none; }
.invalid-feedback { color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; }
.is-invalid { border-color: #ef4444 !important; }
.card-footer { padding: 1.5rem 2rem; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 1rem; }
.btn-submit { background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(15, 118, 110, 0.25); }
.btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(15, 118, 110, 0.35); }
.btn-cancel { background: white; color: #64748b; border: 1px solid #e2e8f0; padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; transition: all 0.2s; }
.btn-cancel:hover { background: #e2e8f0; }
@media (max-width: 640px) { .card-footer { flex-direction: column-reverse; } .btn-submit, .btn-cancel { width: 100%; justify-content: center; } }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function setupFileInput(inputId, wrapperId, filenameId) {
            const input = document.getElementById(inputId);
            const wrapper = document.getElementById(wrapperId);
            const filename = document.getElementById(filenameId);
            if(!input) return;

            input.addEventListener('change', function(e) {
                const name = e.target.files[0]?.name;
                if (name) {
                    filename.textContent = name; filename.style.display = 'inline-block';
                    wrapper.style.borderColor = '#0d9488'; wrapper.style.backgroundColor = '#f0fdfa';
                } else {
                    filename.style.display = 'none'; wrapper.style.borderColor = '#e2e8f0'; wrapper.style.backgroundColor = '#f8fafc';
                }
            });
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => wrapper.addEventListener(eventName, e => {e.preventDefault(); e.stopPropagation()}, false));
            ['dragenter', 'dragover'].forEach(ev => wrapper.addEventListener(ev, () => { wrapper.style.borderColor = '#0d9488'; wrapper.style.backgroundColor = '#e6fffa'; }, false));
            ['dragleave', 'drop'].forEach(ev => wrapper.addEventListener(ev, () => { wrapper.style.borderColor = '#e2e8f0'; wrapper.style.backgroundColor = '#f8fafc'; }, false));
        }

        setupFileInput('kartu_kontrol', 'wrapper_kartu_kontrol', 'filename_kartu_kontrol');
        setupFileInput('krs', 'wrapper_krs', 'filename_krs');
        setupFileInput('berkas', 'wrapper_berkas', 'filename_berkas');
    });
</script>
@endpush
