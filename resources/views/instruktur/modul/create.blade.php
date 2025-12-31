@extends('layouts.instruktur')

@section('title', 'Upload Modul')

@section('content')
{{-- Page Header --}}
<div class="page-header">
    <div class="header-content">
        <div class="header-left">
            <a href="{{ route('instruktur.modul.show', $jadwal) }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="header-info">
                <h2 class="header-title">
                    <i class="fas fa-upload"></i>
                    Upload Modul Baru
                </h2>
                <p class="header-subtitle">{{ $jadwal->praktikum->nama_praktikum ?? '-' }} &bull; {{ $jadwal->kelas->nama_kelas ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Form Card --}}
<div class="form-card">
    <form action="{{ route('instruktur.modul.store', $jadwal) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-info-circle"></i>
                Informasi Modul
            </h3>
            
            <div class="form-group">
                <label for="judul">Judul Modul <span class="required">*</span></label>
                <input type="text" id="judul" name="judul" value="{{ old('judul') }}" 
                       class="form-control @error('judul') is-invalid @enderror" 
                       placeholder="Masukkan judul modul" required>
                @error('judul')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="pertemuan_ke">Pertemuan Ke</label>
                <input type="number" id="pertemuan_ke" name="pertemuan_ke" value="{{ old('pertemuan_ke') }}" 
                       class="form-control @error('pertemuan_ke') is-invalid @enderror" 
                       placeholder="Contoh: 1, 2, 3, ..." min="1">
                @error('pertemuan_ke')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <span class="form-hint">Opsional. Kosongkan jika modul tidak terkait pertemuan tertentu.</span>
            </div>
            
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="3" 
                          class="form-control @error('deskripsi') is-invalid @enderror" 
                          placeholder="Deskripsi singkat tentang modul ini">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-file-upload"></i>
                File Modul
            </h3>
            
            <div class="form-group">
                <label for="file">Upload File <span class="required">*</span></label>
                <div class="file-upload-wrapper">
                    <input type="file" id="file" name="file" 
                           class="file-input @error('file') is-invalid @enderror" 
                           accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.rar" required>
                    <div class="file-upload-box" id="fileUploadBox">
                        <div class="upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="upload-text">
                            <p class="upload-primary">Klik untuk pilih file atau drag & drop</p>
                            <p class="upload-secondary">PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, RAR (Max 10MB)</p>
                        </div>
                    </div>
                    <div class="file-preview" id="filePreview" style="display: none;">
                        <div class="file-preview-icon">
                            <i class="fas fa-file"></i>
                        </div>
                        <div class="file-preview-info">
                            <p class="file-name" id="fileName"></p>
                            <p class="file-size" id="fileSize"></p>
                        </div>
                        <button type="button" class="file-remove" id="fileRemove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                @error('file')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="form-actions">
            <a href="{{ route('instruktur.modul.show', $jadwal) }}" class="btn btn-secondary">
                <i class="fas fa-times"></i>
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-upload"></i>
                Upload Modul
            </button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
/* =====================================================
   MODUL CREATE STYLES - CYAN THEME
   ===================================================== */

.page-header {
    margin-bottom: 1.5rem;
}

.header-content {
    background: white;
    padding: 1.5rem;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.back-btn {
    width: 44px;
    height: 44px;
    background: #f1f5f9;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    text-decoration: none;
    transition: all 0.2s ease;
}

.back-btn:hover {
    background: #0891b2;
    color: white;
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
    color: #0891b2;
}

.header-subtitle {
    color: #64748b;
    font-size: 0.875rem;
}

/* Form Card */
.form-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    padding: 2rem;
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #e2e8f0;
}

.form-section:last-of-type {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1rem;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 1.5rem;
}

.section-title i {
    color: #0891b2;
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-group:last-child {
    margin-bottom: 0;
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
    font-size: 0.875rem;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    background: #f8fafc;
    color: #0f172a;
    transition: all 0.2s ease;
}

.form-control:focus {
    outline: none;
    border-color: #0891b2;
    background: white;
    box-shadow: 0 0 0 3px rgba(8, 145, 178, 0.1);
}

.form-control.is-invalid {
    border-color: #ef4444;
}

.invalid-feedback {
    display: block;
    color: #ef4444;
    font-size: 0.8125rem;
    margin-top: 0.375rem;
}

.form-hint {
    display: block;
    color: #64748b;
    font-size: 0.8125rem;
    margin-top: 0.375rem;
}

textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

/* File Upload */
.file-upload-wrapper {
    position: relative;
}

.file-input {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.file-upload-box {
    border: 2px dashed #e2e8f0;
    border-radius: 12px;
    padding: 2.5rem;
    text-align: center;
    background: #f8fafc;
    transition: all 0.2s ease;
}

.file-upload-box:hover,
.file-upload-wrapper:has(.file-input:focus) .file-upload-box {
    border-color: #0891b2;
    background: #ecfeff;
}

.upload-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 1rem;
    background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.upload-icon i {
    font-size: 1.5rem;
    color: white;
}

.upload-primary {
    font-size: 0.9375rem;
    font-weight: 500;
    color: #0f172a;
    margin-bottom: 0.25rem;
}

.upload-secondary {
    font-size: 0.8125rem;
    color: #64748b;
}

.file-preview {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #ecfeff;
    border-radius: 12px;
    border: 1px solid #a5f3fc;
}

.file-preview-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.file-preview-icon i {
    color: white;
    font-size: 1.25rem;
}

.file-preview-info {
    flex: 1;
}

.file-name {
    font-size: 0.875rem;
    font-weight: 500;
    color: #0f172a;
    word-break: break-all;
}

.file-size {
    font-size: 0.8125rem;
    color: #64748b;
}

.file-remove {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: white;
    border: 1px solid #e2e8f0;
    color: #64748b;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.file-remove:hover {
    background: #fee2e2;
    border-color: #fecaca;
    color: #dc2626;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #e2e8f0;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(6, 182, 212, 0.3);
}

.btn-primary:hover {
    box-shadow: 0 6px 20px rgba(6, 182, 212, 0.4);
    transform: translateY(-2px);
}

.btn-secondary {
    background: #f1f5f9;
    color: #64748b;
}

.btn-secondary:hover {
    background: #e2e8f0;
    color: #475569;
}

/* Responsive */
@media (max-width: 768px) {
    .form-card {
        padding: 1.5rem;
    }
    
    .form-actions {
        flex-direction: column-reverse;
    }
    
    .form-actions .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');
    const fileUploadBox = document.getElementById('fileUploadBox');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const fileRemove = document.getElementById('fileRemove');

    function formatFileSize(bytes) {
        if (bytes >= 1073741824) {
            return (bytes / 1073741824).toFixed(2) + ' GB';
        } else if (bytes >= 1048576) {
            return (bytes / 1048576).toFixed(2) + ' MB';
        } else if (bytes >= 1024) {
            return (bytes / 1024).toFixed(2) + ' KB';
        } else {
            return bytes + ' bytes';
        }
    }

    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            fileUploadBox.style.display = 'none';
            filePreview.style.display = 'flex';
        }
    });

    fileRemove.addEventListener('click', function() {
        fileInput.value = '';
        fileUploadBox.style.display = 'block';
        filePreview.style.display = 'none';
    });
});
</script>
@endpush
