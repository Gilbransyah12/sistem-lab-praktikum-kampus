@extends('layouts.instruktur')

@section('title', 'Daftar Nilai')

@section('content')
{{-- Page Header --}}
<div class="page-header">
    <div class="header-card">
        <div class="header-icon">
            <i class="fas fa-star"></i>
        </div>
        <div class="header-info">
            <h2>{{ $jadwal->praktikum->nama_praktikum ?? '-' }}</h2>
            <p>{{ $jadwal->kelas->nama_kelas ?? '-' }}</p>
        </div>
        <a href="{{ route('instruktur.nilai.edit', $jadwal) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i>
            Edit Nilai
        </a>
    </div>
</div>

{{-- Nilai Table --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-list"></i>
            Daftar Nilai ({{ $pendaftaran->count() }} Mahasiswa)
        </h3>
    </div>
    <div class="card-body">
        @if($pendaftaran->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Nilai Akhir</th>
                        <th>Grade</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftaran as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $p->peserta->nim ?? '-' }}</td>
                        <td>
                            <div class="student-info">
                                <div class="student-avatar">
                                    {{ strtoupper(substr($p->peserta->nama ?? 'P', 0, 1)) }}
                                </div>
                                <span>{{ $p->peserta->nama ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="nilai-value">
                                {{ $p->nilai->nilai_akhir ?? '-' }}
                            </span>
                        </td>
                        <td>
                            @if($p->nilai && $p->nilai->nilai_akhir)
                                @php
                                    $nilai = $p->nilai->nilai_akhir;
                                    $grade = $nilai >= 85 ? 'A' : ($nilai >= 70 ? 'B' : ($nilai >= 55 ? 'C' : ($nilai >= 40 ? 'D' : 'E')));
                                    $gradeClass = $nilai >= 70 ? 'success' : ($nilai >= 55 ? 'warning' : 'danger');
                                @endphp
                                <span class="grade-badge {{ $gradeClass }}">{{ $grade }}</span>
                            @else
                                <span class="grade-badge pending">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="catatan-text">{{ $p->nilai->catatan ?? '-' }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
    <a href="{{ route('instruktur.nilai.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>
</div>
@endsection

@push('styles')
<style>
/* =====================================================
   NILAI SHOW STYLES
   ===================================================== */

.page-header {
    margin-bottom: 1.5rem;
}

.header-card {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
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

.header-info {
    flex: 1;
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

.header-card .btn-primary {
    background: white;
    color: #f59e0b;
    box-shadow: none;
}

.header-card .btn-primary:hover {
    background: #fffbeb;
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
    color: #f59e0b;
}

.card-body {
    padding: 0;
}

/* Table */
.table-container {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background: #f8fafc;
}

th {
    padding: 1rem 1.5rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #64748b;
    border-bottom: 1px solid #e2e8f0;
}

td {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

tbody tr:hover {
    background: #f8fafc;
}

tbody tr:last-child td {
    border-bottom: none;
}

.student-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.student-avatar {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 0.875rem;
}

.nilai-value {
    font-size: 1.125rem;
    font-weight: 700;
    color: #0f172a;
}

.grade-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 700;
}

.grade-badge.success {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.grade-badge.warning {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.grade-badge.danger {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.grade-badge.pending {
    background: rgba(100, 116, 139, 0.1);
    color: #64748b;
}

.catatan-text {
    font-size: 0.8125rem;
    color: #64748b;
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
    justify-content: flex-start;
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
@media (max-width: 768px) {
    .header-card {
        flex-direction: column;
        text-align: center;
    }
    
    th, td {
        padding: 0.75rem 1rem;
    }
}
</style>
@endpush

