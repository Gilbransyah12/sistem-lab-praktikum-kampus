@extends('layouts.instruktur')

@section('title', 'Modul ' . $jadwal->praktikum->nama_praktikum)

@section('content')
{{-- Page Header --}}
<div class="page-header">
    <div class="header-content">
        <div class="header-left">
            <a href="{{ route('instruktur.modul.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="header-info">
                <h2 class="header-title">
                    <i class="fas fa-book-open"></i>
                    {{ $jadwal->praktikum->nama_praktikum ?? 'Modul' }}
                </h2>
                <p class="header-subtitle">{{ $jadwal->kelas->nama_kelas ?? '-' }} &bull; {{ $jadwal->hari }}, {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('instruktur.modul.create', $jadwal) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <span>Upload Modul</span>
            </a>
        </div>
    </div>
</div>



{{-- Modul List --}}
@if($modul->count() > 0)
<div class="modul-list">
    @foreach($modul as $m)
    <div class="modul-card">
        <div class="modul-icon {{ $m->file_type }}">
            @if(in_array($m->file_type, ['pdf']))
            <i class="fas fa-file-pdf"></i>
            @elseif(in_array($m->file_type, ['doc', 'docx']))
            <i class="fas fa-file-word"></i>
            @elseif(in_array($m->file_type, ['ppt', 'pptx']))
            <i class="fas fa-file-powerpoint"></i>
            @elseif(in_array($m->file_type, ['xls', 'xlsx']))
            <i class="fas fa-file-excel"></i>
            @elseif(in_array($m->file_type, ['zip', 'rar']))
            <i class="fas fa-file-archive"></i>
            @else
            <i class="fas fa-file-alt"></i>
            @endif
        </div>
        <div class="modul-content">
            <div class="modul-info">
                <h3 class="modul-title">{{ $m->judul }}</h3>
                @if($m->pertemuan_ke)
                <span class="modul-pertemuan">Pertemuan {{ $m->pertemuan_ke }}</span>
                @endif
            </div>
            @if($m->deskripsi)
            <p class="modul-desc">{{ $m->deskripsi }}</p>
            @endif
            <div class="modul-meta">
                <span><i class="fas fa-file"></i> {{ strtoupper($m->file_type) }}</span>
                <span><i class="fas fa-hdd"></i> {{ $m->formatted_file_size }}</span>
                <span><i class="fas fa-calendar"></i> {{ $m->created_at->format('d M Y, H:i') }}</span>
            </div>
        </div>
        <div class="modul-actions">
            <a href="{{ route('instruktur.modul.download', $m) }}" class="btn btn-secondary btn-sm" title="Download">
                <i class="fas fa-download"></i>
            </a>
            <form action="{{ route('instruktur.modul.destroy', $m) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state-card">
    <div class="empty-icon">
        <i class="fas fa-folder-open"></i>
    </div>
    <h3>Belum Ada Modul</h3>
    <p>Belum ada modul yang diupload untuk jadwal ini.</p>
    <a href="{{ route('instruktur.modul.create', $jadwal) }}" class="btn btn-primary mt-3">
        <i class="fas fa-plus"></i>
        Upload Modul Pertama
    </a>
</div>
@endif
@endsection

@push('styles')
<style>
/* =====================================================
   MODUL SHOW STYLES - CYAN THEME
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
    flex-wrap: wrap;
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

/* Alert */
.alert {
    padding: 1rem 1.25rem;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    font-size: 0.875rem;
}

.alert-success {
    background: #dcfce7;
    color: #15803d;
}

.alert-danger {
    background: #fee2e2;
    color: #dc2626;
}

/* Modul List */
.modul-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.modul-card {
    display: flex;
    align-items: flex-start;
    gap: 1.25rem;
    padding: 1.5rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid transparent;
    transition: all 0.3s ease;
}

.modul-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(6, 182, 212, 0.12);
    border-color: rgba(6, 182, 212, 0.2);
}

.modul-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.modul-icon.pdf {
    background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
    color: white;
}

.modul-icon.doc, .modul-icon.docx {
    background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);
    color: white;
}

.modul-icon.ppt, .modul-icon.pptx {
    background: linear-gradient(135deg, #ea580c 0%, #fb923c 100%);
    color: white;
}

.modul-icon.xls, .modul-icon.xlsx {
    background: linear-gradient(135deg, #16a34a 0%, #4ade80 100%);
    color: white;
}

.modul-icon.zip, .modul-icon.rar {
    background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
    color: white;
}

.modul-icon:not(.pdf):not(.doc):not(.docx):not(.ppt):not(.pptx):not(.xls):not(.xlsx):not(.zip):not(.rar) {
    background: linear-gradient(135deg, #64748b 0%, #94a3b8 100%);
    color: white;
}

.modul-content {
    flex: 1;
    min-width: 0;
}

.modul-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
    margin-bottom: 0.25rem;
}

.modul-title {
    font-size: 1rem;
    font-weight: 600;
    color: #0f172a;
}

.modul-pertemuan {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.625rem;
    background: #ecfeff;
    color: #0891b2;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.modul-desc {
    color: #64748b;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.modul-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    font-size: 0.8125rem;
    color: #64748b;
}

.modul-meta span {
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.modul-meta i {
    color: #0891b2;
    font-size: 0.75rem;
}

.modul-actions {
    display: flex;
    gap: 0.5rem;
    flex-shrink: 0;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
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
    padding: 0.625rem;
    width: 40px;
    height: 40px;
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

.btn-danger {
    background: #fee2e2;
    color: #dc2626;
}

.btn-danger:hover {
    background: #fecaca;
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
    background: linear-gradient(135deg, #ecfeff 0%, #cffafe 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.empty-icon i {
    font-size: 2.5rem;
    color: #0891b2;
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

.mt-3 {
    margin-top: 1rem;
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .header-actions {
        width: 100%;
    }
    
    .header-actions .btn {
        width: 100%;
        justify-content: center;
    }
    
    .modul-card {
        flex-direction: column;
    }
    
    .modul-actions {
        width: 100%;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
        justify-content: flex-end;
    }
}
</style>
@endpush
