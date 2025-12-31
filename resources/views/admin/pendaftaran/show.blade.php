@extends('layouts.admin')

@section('title', 'Detail Pendaftaran')

@section('content')
<div class="page-header">
    <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali</span>
    </a>
</div>

<!-- Status Update Card -->
<div class="status-card">
    <div class="status-header">
        <span class="status-label">Status Pendaftaran</span>
        @switch($pendaftaran->status)
            @case('pending')
                <span class="badge badge-warning badge-lg">
                    <i class="fas fa-clock"></i> Pending
                </span>
                @break
            @case('diterima')
                <span class="badge badge-success badge-lg">
                    <i class="fas fa-check-circle"></i> Diterima
                </span>
                @break
            @case('ditolak')
                <span class="badge badge-danger badge-lg">
                    <i class="fas fa-times-circle"></i> Ditolak
                </span>
                @break
        @endswitch
    </div>
    <div class="status-actions">
        <form action="{{ route('admin.pendaftaran.status', $pendaftaran->id) }}" method="POST" class="status-form">
            @csrf
            @method('PATCH')
            <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                <option value="">-- Ubah Status --</option>
                <option value="pending" {{ $pendaftaran->status == 'pending' ? 'disabled' : '' }}>Pending</option>
                <option value="diterima" {{ $pendaftaran->status == 'diterima' ? 'disabled' : '' }}>Terima</option>
                <option value="ditolak" {{ $pendaftaran->status == 'ditolak' ? 'disabled' : '' }}>Tolak</option>
            </select>
        </form>
    </div>
</div>

<!-- Info Cards -->
<div class="info-grid">
    <!-- Peserta Info -->
    <div class="info-card">
        <div class="info-card-header">
            <i class="fas fa-user"></i>
            <h4>Data Peserta</h4>
        </div>
        <div class="info-card-body">
            <div class="info-row">
                <span class="info-label">Nama</span>
                <span class="info-value">{{ $pendaftaran->peserta->nama ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">NIM</span>
                <span class="info-value"><code>{{ $pendaftaran->peserta->nim ?? '-' }}</code></span>
            </div>
            <div class="info-row">
                <span class="info-label">No. HP/WA</span>
                <span class="info-value">{{ $pendaftaran->peserta->no_hp_wa ?? '-' }}</span>
            </div>
        </div>
    </div>

    <!-- Praktikum Info -->
    <div class="info-card">
        <div class="info-card-header">
            <i class="fas fa-book"></i>
            <h4>Data Praktikum</h4>
        </div>
        <div class="info-card-body">
            <div class="info-row">
                <span class="info-label">Praktikum</span>
                <span class="info-value">{{ $pendaftaran->praktikum->nama_praktikum ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Kelas</span>
                <span class="info-value">{{ $pendaftaran->kelas->nama_kelas ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Periode</span>
                <span class="info-value">{{ $pendaftaran->periode->tahun_akademik ?? '-' }} / {{ $pendaftaran->periode->semester ?? '-' }}</span>
            </div>
        </div>
    </div>

    <!-- Pendaftaran Info -->
    <div class="info-card">
        <div class="info-card-header">
            <i class="fas fa-file-alt"></i>
            <h4>Data Pendaftaran</h4>
        </div>
        <div class="info-card-body">
            <div class="info-row">
                <span class="info-label">Tanggal Daftar</span>
                <span class="info-value">{{ $pendaftaran->tanggal_daftar->format('d F Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Kartu Kontrol</span>
                <span class="info-value">
                    @if($pendaftaran->kartu_kontrol_path)
                        <a href="{{ asset('storage/' . $pendaftaran->kartu_kontrol_path) }}" target="_blank" class="file-link">
                            <i class="fas fa-file-pdf"></i> Lihat File
                        </a>
                    @else
                        <span class="text-muted">Tidak ada</span>
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Berkas</span>
                <span class="info-value">
                    @if($pendaftaran->berkas_path)
                        <a href="{{ asset('storage/' . $pendaftaran->berkas_path) }}" target="_blank" class="file-link">
                            <i class="fas fa-file-archive"></i> Lihat File
                        </a>
                    @else
                        <span class="text-muted">Tidak ada</span>
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.page-header {
    margin-bottom: 1.5rem;
}

.status-card {
    background: white;
    border-radius: 1rem;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow-md);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.status-header {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.status-label {
    font-weight: 600;
    color: var(--dark-700);
}

.badge-lg {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.status-form {
    min-width: 160px;
}

.form-control-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.info-card {
    background: white;
    border-radius: 1rem;
    box-shadow: var(--shadow-md);
    overflow: hidden;
}

.info-card-header {
    background: linear-gradient(135deg, var(--dark-50) 0%, white 100%);
    padding: 1rem 1.25rem;
    border-bottom: 1px solid var(--dark-100);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.info-card-header i {
    color: var(--primary-500);
    font-size: 1.125rem;
}

.info-card-header h4 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark-800);
}

.info-card-body {
    padding: 1.25rem;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 0.625rem 0;
    border-bottom: 1px solid var(--dark-50);
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-size: 0.875rem;
    color: var(--dark-500);
}

.info-value {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--dark-800);
    text-align: right;
}

code {
    background: var(--dark-100);
    padding: 0.125rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.8125rem;
    color: var(--primary-700);
}

.file-link {
    color: var(--primary-600);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
}

.file-link:hover {
    color: var(--primary-700);
    text-decoration: underline;
}

.text-muted {
    color: var(--dark-400);
    font-style: italic;
}
</style>
@endpush
@endsection
