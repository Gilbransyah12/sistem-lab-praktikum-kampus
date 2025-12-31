<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Kontrol - {{ $user->nama ?? 'Mahasiswa' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4;
            margin: 15mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
            background: white;
            line-height: 1.4;
        }

        .kartu-kontrol {
            width: 100%;
            max-width: 180mm;
            margin: 0 auto;
            padding: 0;
        }

        /* Header */
        .kartu-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .logo-left, .logo-right {
            width: 60px;
            flex-shrink: 0;
        }

        .logo-img {
            width: 50px;
            height: auto;
        }

        .logo-placeholder {
            width: 50px;
            height: 50px;
            border: 1px solid #333;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8pt;
        }

        .header-center {
            flex: 1;
            text-align: center;
        }

        .kartu-title {
            font-size: 16pt;
            font-weight: bold;
            margin: 0;
            letter-spacing: 2px;
        }

        .header-line {
            height: 1px;
            background: #000;
            margin: 3px 20px;
        }

        .header-line.thick {
            height: 2px;
            margin: 6px 20px;
        }

        .lab-name {
            font-size: 10pt;
            font-weight: bold;
            margin: 3px 0;
            letter-spacing: 0.5px;
        }

        .univ-name {
            font-size: 9pt;
            font-weight: bold;
            margin: 0;
        }

        .mata-kuliah {
            font-size: 11pt;
            font-weight: bold;
            margin: 6px 0 0;
            text-transform: uppercase;
        }

        /* Student Info */
        .student-info-section {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
        }

        .student-data {
            flex: 1;
        }

        .info-table {
            border-collapse: collapse;
        }

        .info-table td {
            padding: 3px 0;
            font-size: 10pt;
            vertical-align: top;
        }

        .info-table .label {
            width: 80px;
        }

        .info-table .separator {
            width: 12px;
            text-align: center;
        }

        .info-table .value {
            font-weight: bold;
        }

        .student-photo {
            width: 80px;
            height: 105px;
            border: 1.5px solid #333;
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
            font-size: 8pt;
            color: #999;
            text-align: center;
        }

        /* Attendance Table */
        .attendance-section {
            margin: 15px 0;
        }

        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }

        .attendance-table th,
        .attendance-table td {
            border: 1px solid #333;
            padding: 6px 8px;
        }

        .attendance-table th {
            background: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .attendance-table .col-no {
            width: 30px;
            text-align: center;
        }

        .attendance-table .col-tanggal {
            width: 80px;
            text-align: center;
        }

        .attendance-table .col-paraf {
            width: 60px;
            text-align: center;
        }

        .attendance-table tbody td {
            height: 28px;
        }

        /* Footer Signature */
        .kartu-footer {
            margin-top: 25px;
            display: flex;
            justify-content: flex-end;
        }

        .signature-section {
            text-align: center;
            min-width: 180px;
        }

        .signature-section p {
            margin: 0;
            font-size: 10pt;
        }

        .signature-section .title {
            margin-bottom: 50px;
        }

        /* Print Button */
        .print-actions {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 1000;
        }

        .btn-action {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: Arial, sans-serif;
        }

        .btn-print {
            background: #0f766e;
            color: white;
        }

        .btn-print:hover {
            background: #0d9488;
        }

        .btn-back {
            background: #64748b;
            color: white;
        }

        .btn-back:hover {
            background: #475569;
        }

        @media print {
            .print-actions {
                display: none !important;
            }
            
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    {{-- Print Actions --}}
    <div class="print-actions">
        <a href="{{ route('mahasiswa.kartu-kontrol.index') }}" class="btn-action btn-back">
            ← Kembali
        </a>
        <button onclick="window.print()" class="btn-action btn-print">
            🖨️ Cetak
        </button>
    </div>

    <div class="kartu-kontrol">
        {{-- Header with Logos --}}
        <div class="kartu-header">
            <div class="logo-left">
                <div class="logo-placeholder">UMPAR</div>
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
                <div class="logo-placeholder">LOGO</div>
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
                        PAS<br>FOTO<br>3x4
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
                <p>Parepare, _____________</p>
                <p class="title">Kepala LAB TI,</p>
                <p class="signature-line">&nbsp;</p>
                <p class="name-bold">Ir. Untung Suwardoyo, S.Kom., M.T., I.P.P.</p>
                <p>NBM. 1288 973</p>
            </div>
        </div>
    </div>
</body>
</html>
