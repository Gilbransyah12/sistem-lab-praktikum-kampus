<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Semua Kartu Kontrol</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
            color: #000;
            background: #f5f5f5;
            line-height: 1.3;
        }

        .print-header {
            background: #0f766e;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .print-header h1 {
            font-size: 16px;
            font-family: Arial, sans-serif;
        }

        .print-actions {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            font-family: Arial, sans-serif;
        }

        .btn-print {
            background: white;
            color: #0f766e;
        }

        .btn-back {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        .content-wrapper {
            margin-top: 70px;
            padding: 20px;
        }

        .kartu-kontrol {
            width: 180mm;
            margin: 0 auto 20px;
            padding: 12mm;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            page-break-inside: avoid;
            page-break-after: always;
        }

        .kartu-kontrol:last-child {
            page-break-after: auto;
        }

        /* Header */
        .kartu-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .logo-placeholder {
            width: 40px;
            height: 40px;
            border: 1px solid #333;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 7pt;
        }

        .header-center {
            flex: 1;
            text-align: center;
        }

        .kartu-title {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
            letter-spacing: 1.5px;
        }

        .header-line {
            height: 1px;
            background: #000;
            margin: 2px 15px;
        }

        .header-line.thick {
            height: 2px;
            margin: 4px 15px;
        }

        .lab-name {
            font-size: 9pt;
            font-weight: bold;
            margin: 2px 0;
        }

        .univ-name {
            font-size: 8pt;
            font-weight: bold;
            margin: 0;
        }

        .mata-kuliah {
            font-size: 10pt;
            font-weight: bold;
            margin: 4px 0 0;
            text-transform: uppercase;
        }

        /* Student Info */
        .student-info-section {
            display: flex;
            justify-content: space-between;
            margin: 12px 0;
        }

        .student-data {
            flex: 1;
        }

        .info-table {
            border-collapse: collapse;
        }

        .info-table td {
            padding: 2px 0;
            font-size: 9pt;
            vertical-align: top;
        }

        .info-table .label {
            width: 70px;
        }

        .info-table .separator {
            width: 10px;
            text-align: center;
        }

        .info-table .value {
            font-weight: bold;
        }

        .student-photo {
            width: 70px;
            height: 90px;
            border: 1px solid #333;
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
            font-size: 7pt;
            color: #999;
            text-align: center;
        }

        /* Attendance Table */
        .attendance-section {
            margin: 10px 0;
        }

        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }

        .attendance-table th,
        .attendance-table td {
            border: 1px solid #333;
            padding: 4px 6px;
        }

        .attendance-table th {
            background: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .attendance-table .col-no {
            width: 25px;
            text-align: center;
        }

        .attendance-table .col-tanggal {
            width: 70px;
            text-align: center;
        }

        .attendance-table .col-paraf {
            width: 50px;
            text-align: center;
        }

        .attendance-table tbody td {
            height: 22px;
        }

        /* Footer Signature */
        .kartu-footer {
            margin-top: 15px;
            display: flex;
            justify-content: flex-end;
        }

        .signature-section {
            text-align: center;
            min-width: 150px;
        }

        .signature-section p {
            margin: 0;
            font-size: 9pt;
        }

        .signature-section .title {
            margin-bottom: 40px;
        }

        /* Info count */
        .info-count {
            background: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .info-count h2 {
            color: #0f766e;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .info-count p {
            color: #666;
            font-size: 14px;
        }

        @media print {
            .print-header {
                display: none !important;
            }

            .content-wrapper {
                margin-top: 0;
                padding: 0;
            }

            .info-count {
                display: none !important;
            }

            body {
                background: white;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .kartu-kontrol {
                box-shadow: none;
                margin: 0 auto;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    {{-- Print Header --}}
    <div class="print-header">
        <h1><i class="fas fa-print"></i> Cetak Semua Kartu Kontrol ({{ $allKartuKontrol->count() }} kartu)</h1>
        <div class="print-actions">
            <a href="{{ route('admin.peserta.index') }}" class="btn-action btn-back">← Kembali</a>
            <button onclick="window.print()" class="btn-action btn-print">🖨️ Cetak Sekarang</button>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="info-count">
            <h2>Total: {{ $allKartuKontrol->count() }} Kartu Kontrol</h2>
            <p>Klik tombol "Cetak Sekarang" untuk mencetak semua kartu kontrol</p>
        </div>

        @foreach($allKartuKontrol as $kartu)
        <div class="kartu-kontrol">
            {{-- Header --}}
            <div class="kartu-header">
                <div class="logo-placeholder">UMPAR</div>
                <div class="header-center">
                    <h1 class="kartu-title">KARTU KONTROL</h1>
                    <div class="header-line"></div>
                    <h2 class="lab-name">LABORATORIUM TEKNIK INFORMATIKA</h2>
                    <h3 class="univ-name">UNIVERSITAS MUHAMMADIYAH PAREPARE</h3>
                    <div class="header-line thick"></div>
                    <h2 class="mata-kuliah">{{ $kartu['jadwal']->mata_kuliah ?? 'PRAKTIKUM' }}</h2>
                </div>
                <div class="logo-placeholder">LOGO</div>
            </div>

            {{-- Student Info --}}
            <div class="student-info-section">
                <div class="student-data">
                    <table class="info-table">
                        <tr>
                            <td class="label">NIM</td>
                            <td class="separator">:</td>
                            <td class="value">{{ $kartu['user']->nim ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Nama</td>
                            <td class="separator">:</td>
                            <td class="value">{{ $kartu['user']->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Kelas</td>
                            <td class="separator">:</td>
                            <td class="value">{{ $kartu['pendaftaran']->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Praktikum Ke</td>
                            <td class="separator">:</td>
                            <td class="value">{{ $kartu['pendaftaran']->periode->praktikum_ke_romawi ?? $kartu['pendaftaran']->periode->praktikum_ke }}</td>
                        </tr>
                    </table>
                </div>
                <div class="student-photo">
                    @if($kartu['pendaftaran']->kartu_kontrol_path)
                        <img src="{{ asset('storage/' . $kartu['pendaftaran']->kartu_kontrol_path) }}" alt="Foto" class="photo-img">
                    @else
                        <div class="photo-placeholder">PAS<br>FOTO<br>3x4</div>
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
                            <th>Uraian Materi</th>
                            <th class="col-paraf">Paraf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 10; $i++)
                            @php
                                $sesi = $kartu['sesiList']->where('pertemuan_ke', $i)->first();
                            @endphp
                            <tr>
                                <td class="col-no">{{ $i }}.</td>
                                <td class="col-tanggal">{{ $sesi && $sesi->tanggal ? $sesi->tanggal->format('d/m/Y') : '' }}</td>
                                <td>{{ $sesi->materi ?? '' }}</td>
                                <td class="col-paraf"></td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            {{-- Footer --}}
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
        @endforeach
    </div>
</body>
</html>
