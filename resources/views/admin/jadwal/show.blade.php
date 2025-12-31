@extends('layouts.admin')

@section('title', 'Detail Jadwal')

@section('content')
<div class="page-header">
    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali</span>
    </a>
</div>

<!-- Jadwal Info Card -->
<div class="info-card">
    <div class="info-header">
        <div class="info-title">
            <h4 style="margin:0; color:#0f766e; font-size:1.1rem;">{{ $jadwal->mata_kuliah ?? '-' }}</h4>
            <h2>{{ $jadwal->praktikum->nama_praktikum ?? '-' }}</h2>
            <span class="badge badge-info">{{ $jadwal->kelas->nama_kelas ?? '-' }}</span>
        </div>
        <div class="info-actions">
            <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-edit"></i>
                <span>Edit</span>
            </a>
        </div>
    </div>
    <div class="info-grid">
        <div class="info-item">
            <span class="info-label"><i class="fas fa-user-tie"></i> Instruktur</span>
            <span class="info-value">{{ $jadwal->instruktur->nama ?? '-' }}</span>
        </div>
        <div class="info-item">
            <span class="info-label"><i class="fas fa-door-open"></i> Ruangan</span>
            <span class="info-value">{{ $jadwal->ruangan->nama_ruangan ?? '-' }}</span>
        </div>
        <div class="info-item">
            <span class="info-label"><i class="fas fa-calendar-day"></i> Hari</span>
            <span class="info-value">{{ $jadwal->hari }}</span>
        </div>
        <div class="info-item">
            <span class="info-label"><i class="fas fa-clock"></i> Jam</span>
            <span class="info-value">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</span>
        </div>
        <div class="info-item">
            <span class="info-label"><i class="fas fa-calendar-alt"></i> Periode</span>
            <span class="info-value">{{ $jadwal->periode->tahun_akademik ?? '-' }} / {{ $jadwal->periode->semester ?? '-' }}</span>
        </div>
        <div class="info-item">
            <span class="info-label"><i class="fas fa-list-ol"></i> Jumlah Sesi</span>
            <span class="info-value">{{ $jadwal->sesi->count() }} Pertemuan</span>
        </div>
    </div>
</div>

<!-- Sesi List -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pertemuan/Sesi</h3>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Pertemuan</th>
                        <th>Tanggal</th>
                        <th>Materi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwal->sesi as $s)
                    <tr>
                        <td>
                            <span class="badge badge-primary">Pertemuan {{ $s->pertemuan_ke }}</span>
                        </td>
                        <td>{{ $s->tanggal->format('d F Y') }}</td>
                        <td>{{ $s->materi ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="empty-state">
                            <i class="fas fa-clipboard-list"></i>
                            <p>Belum ada sesi/pertemuan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Daftar Nilai Peserta -->
<div class="card" style="margin-top: 1.5rem;">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-users"></i> Daftar Nilai Peserta ({{ $peserta->count() }})
        </h3>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th width="35%">Peserta</th>
                        <th width="20%" class="text-center">Nilai Akhir</th>
                        <th width="15%" class="text-center">Grade</th>
                        <th width="25%">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peserta as $index => $p)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <div class="user-info">
                                <div class="avatar-mini">{{ substr($p->peserta->nama ?? 'U', 0, 1) }}</div>
                                <div>
                                    <span class="d-block fw-bold" style="color: #334155;">{{ $p->peserta->nama ?? '-' }}</span>
                                    <span class="d-block small text-muted">{{ $p->peserta->nim ?? '-' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            @if($p->nilai && isset($p->nilai->nilai_akhir))
                                <span class="badge" style="background: #f1f5f9; color: #1e293b; font-size: 0.9em; padding: 0.4em 0.8em;">
                                    {{ $p->nilai->nilai_akhir }}
                                </span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($p->nilai && isset($p->nilai->nilai_akhir))
                                @php
                                    $n = $p->nilai->nilai_akhir;
                                    $grade = 'E';
                                    if($n >= 85) $grade = 'A';
                                    elseif($n >= 80) $grade = 'A-';
                                    elseif($n >= 75) $grade = 'B+';
                                    elseif($n >= 70) $grade = 'B';
                                    elseif($n >= 65) $grade = 'B-';
                                    elseif($n >= 60) $grade = 'C+';
                                    elseif($n >= 55) $grade = 'C';
                                    elseif($n >= 45) $grade = 'D';
                                    
                                    $color = match($grade) {
                                        'A', 'A-' => '#16a34a',
                                        'B+', 'B', 'B-' => '#2563eb',
                                        'C+', 'C' => '#d97706',
                                        'D' => '#ea580c',
                                        default => '#dc2626'
                                    };
                                @endphp
                                <span style="font-weight: 700; color: {{ $color }};">{{ $grade }}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <span class="text-muted small">{{ $p->nilai->catatan ?? '-' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            <i class="fas fa-users-slash"></i>
                            <p>Belum ada peserta di jadwal ini</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
.page-header {
    margin-bottom: 1.5rem;
}

.info-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow-md);
}

.info-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--dark-100);
}

.info-title h2 {
    font-size: 1.375rem;
    font-weight: 700;
    color: var(--dark-800);
    margin: 0 0 0.5rem 0;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1.25rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
}

.info-label {
    font-size: 0.8125rem;
    color: var(--dark-500);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-label i {
    width: 16px;
    color: var(--primary-500);
}

.info-value {
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark-800);
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem !important;
    color: var(--dark-400);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    display: block;
    color: var(--dark-300);
}

.empty-state p {
    margin: 0;
}
</style>
@endpush
@endsection
