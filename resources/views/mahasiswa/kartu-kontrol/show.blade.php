@extends('layouts.mahasiswa')

@section('title', 'Kartu Kontrol - ' . ($pendaftaran->praktikum->nama_praktikum ?? 'Praktikum'))

@section('breadcrumb')
    <span>/</span>
    <a href="{{ route('mahasiswa.kartu-kontrol.index') }}">Kartu Kontrol</a>
    <span>/</span>
    <span>Detail</span>
@endsection

@section('content')
<div class="kartu-view-container">
    {{-- Action Bar --}}
    <div class="action-bar">
        <a href="{{ route('mahasiswa.kartu-kontrol.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <div class="action-buttons">
            <a href="{{ route('mahasiswa.kartu-kontrol.pdf', $pendaftaran->id) }}" class="btn-print" target="_blank">
                <i class="fas fa-print"></i> Cetak PDF
            </a>
        </div>
    </div>

    {{-- Kartu Kontrol Template --}}
    <div class="kartu-kontrol-wrapper">
        <div class="kartu-kontrol" id="kartuKontrol">
            {{-- Header with Logos --}}
            <div class="kartu-header">
                <div class="logo-left">
                    {{-- Logo UMPAR (Left) --}}
                    <img src="{{ asset('images/logo-umpar.png') }}" alt="Logo UMPAR" class="logo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="logo-placeholder" style="display:none;">
                        <i class="fas fa-university"></i>
                    </div>
                </div>
                <div class="header-center">
                    <h1 class="kartu-title">KARTU KONTROL</h1>
                    <div class="header-line"></div>
                    <h2 class="lab-name">LABORATORIUM TEKNIK INFORMATIKA</h2>
                    <h3 class="univ-name">UNIVERSITAS MUHAMMADIYAH PAREPARE</h3>
                    <div class="header-line thick"></div>
                    <h2 class="mata-kuliah">{{ $jadwal->mata_kuliah ?? ($pendaftaran->praktikum->nama_praktikum ?? 'PRAKTIKUM') }}</h2>
                </div>
                <div class="logo-right">
                    {{-- Logo Kampus Merdeka (Right) --}}
                    <img src="{{ asset('images/logo-kampus-merdeka.png') }}" alt="Logo" class="logo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="logo-placeholder" style="display:none;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                </div>
            </div>

            {{-- Student Info Section --}}
            <div class="student-info-section">
                <div class="student-data">
                    <table class="info-table">
                        <tr>
                            <td class="label">NIM</td>
                            <td class="separator">:</td>
                            <td class="value">{{ $user->nim ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Nama</td>
                            <td class="separator">:</td>
                            <td class="value">{{ $user->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Kelas</td>
                            <td class="separator">:</td>
                            <td class="value">{{ $pendaftaran->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Praktikum Ke</td>
                            <td class="separator">:</td>
                            <td class="value">{{ $pendaftaran->periode->praktikum_ke_romawi ?? $pendaftaran->periode->praktikum_ke }} ({{ ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan'][$pendaftaran->periode->praktikum_ke] ?? '' }})</td>
                        </tr>
                    </table>
                </div>
                <div class="student-photo">
                    @if($pendaftaran->kartu_kontrol_path)
                        <img src="{{ asset('storage/' . $pendaftaran->kartu_kontrol_path) }}" alt="Pas Foto" class="photo-img">
                    @else
                        <div class="photo-placeholder">
                            <i class="fas fa-user"></i>
                            <span>3x4</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Attendance Table --}}
            <div class="attendance-section">
                <table class="attendance-table">
                    <thead>
                        <tr>
                            <th class="col-no">No.</th>
                            <th class="col-tanggal">Tanggal</th>
                            <th class="col-materi">Uraian Materi</th>
                            <th class="col-paraf">Paraf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 10; $i++)
                            @php
                                $sesi = $sesiList->where('pertemuan_ke', $i)->first();
                            @endphp
                            <tr>
                                <td class="col-no">{{ $i }}.</td>
                                <td class="col-tanggal">{{ $sesi ? $sesi->tanggal->format('d/m/Y') : '' }}</td>
                                <td class="col-materi">{{ $sesi->materi ?? '' }}</td>
                                <td class="col-paraf"></td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            {{-- Footer with Signature --}}
            <div class="kartu-footer">
                <div class="signature-section">
                    <p class="location">Parepare, _____________</p>
                    <p class="title">Kepala LAB TI,</p>
                    <div class="signature-space"></div>
                    <p class="name-bold">Ir. Untung Suwardoyo, S.Kom., M.T., I.P.P.</p>
                    <p class="nip-line">NBM. 1288 973</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.kartu-view-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Action Bar */
.action-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: white;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.btn-back {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}

.btn-back:hover {
    color: #0f766e;
}

.action-buttons {
    display: flex;
    gap: 0.75rem;
}

.btn-print {
    background: #0f766e;
    color: white;
    padding: 0.625rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.btn-print:hover {
    background: #0d9488;
    transform: translateY(-1px);
}

/* Kartu Kontrol Wrapper */
.kartu-kontrol-wrapper {
    background: #e2e8f0;
    padding: 2rem;
    border-radius: 16px;
    display: flex;
    justify-content: center;
    overflow-x: auto;
}

/* Kartu Kontrol Style */
.kartu-kontrol {
    background: white;
    width: 210mm;
    min-height: 297mm;
    padding: 15mm 20mm;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    font-family: 'Times New Roman', Times, serif;
    color: #000;
}

/* Header */
.kartu-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 20px;
}

.logo-left, .logo-right {
    width: 70px;
    flex-shrink: 0;
}

.logo-img {
    width: 60px;
    height: auto;
}

.logo-placeholder {
    width: 60px;
    height: 60px;
    border: 2px solid #333;
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #333;
}

.header-center {
    flex: 1;
    text-align: center;
}

.kartu-title {
    font-size: 18pt;
    font-weight: bold;
    margin: 0;
    letter-spacing: 2px;
}

.header-line {
    height: 1px;
    background: #000;
    margin: 4px 30px;
}

.header-line.thick {
    height: 3px;
    margin: 8px 30px;
}

.lab-name {
    font-size: 11pt;
    font-weight: bold;
    margin: 4px 0;
    letter-spacing: 1px;
}

.univ-name {
    font-size: 10pt;
    font-weight: bold;
    margin: 0;
}

.mata-kuliah {
    font-size: 12pt;
    font-weight: bold;
    margin: 8px 0 0;
    text-transform: uppercase;
}

/* Student Info */
.student-info-section {
    display: flex;
    justify-content: space-between;
    margin: 20px 0;
    padding-bottom: 15px;
}

.student-data {
    flex: 1;
}

.info-table {
    border-collapse: collapse;
}

.info-table td {
    padding: 4px 0;
    font-size: 11pt;
    vertical-align: top;
}

.info-table .label {
    width: 100px;
}

.info-table .separator {
    width: 15px;
    text-align: center;
}

.info-table .value {
    font-weight: bold;
}

.student-photo {
    width: 90px;
    height: 120px;
    border: 2px solid #333;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f8f8;
    overflow: hidden;
}

.photo-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.photo-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #999;
}

.photo-placeholder i {
    font-size: 2rem;
}

.photo-placeholder span {
    font-size: 0.75rem;
    margin-top: 4px;
}

/* Attendance Table */
.attendance-section {
    margin: 20px 0;
}

.attendance-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 10pt;
}

.attendance-table th,
.attendance-table td {
    border: 1px solid #333;
    padding: 8px 12px;
}

.attendance-table th {
    background: #f5f5f5;
    font-weight: bold;
    text-align: center;
}

.attendance-table .col-no {
    width: 40px;
    text-align: center;
}

.attendance-table .col-tanggal {
    width: 100px;
    text-align: center;
}

.attendance-table .col-materi {
    /* Flexible width */
}

.attendance-table .col-paraf {
    width: 70px;
    text-align: center;
}

.attendance-table tbody td {
    height: 35px;
}

/* Footer Signature */
.kartu-footer {
    margin-top: 30px;
    display: flex;
    justify-content: flex-end;
}

.signature-section {
    text-align: center;
    min-width: 200px;
}

.signature-section p {
    margin: 0;
    font-size: 11pt;
}

.signature-section .location {
    margin-bottom: 4px;
}

.signature-section .title {
    margin-bottom: 60px;
}

.signature-section .name-line {
    margin-top: 0;
}

.signature-section .nip-line {
    font-size: 10pt;
}

/* Print Styles */
@media print {
    .action-bar {
        display: none !important;
    }
    
    .kartu-kontrol-wrapper {
        background: none;
        padding: 0;
    }
    
    .kartu-kontrol {
        box-shadow: none;
        padding: 0;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .kartu-kontrol-wrapper {
        padding: 1rem;
    }
    
    .kartu-kontrol {
        width: 100%;
        min-height: auto;
        padding: 1rem;
        font-size: 12px;
    }
    
    .kartu-header {
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }
    
    .logo-left, .logo-right {
        display: none;
    }
    
    .student-info-section {
        flex-direction: column;
        gap: 1rem;
    }
    
    .student-photo {
        width: 80px;
        height: 100px;
        align-self: center;
    }
}
</style>
@endpush
