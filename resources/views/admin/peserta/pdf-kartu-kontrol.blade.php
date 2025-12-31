<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Kartu Kontrol - PDF Export</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            color: #000;
            line-height: 1.3;
        }

        .kartu-kontrol {
            width: 100%;
            padding: 10mm;
            page-break-after: always;
        }

        .kartu-kontrol:last-child {
            page-break-after: auto;
        }

        /* Header */
        .kartu-header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }

        .kartu-title {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
            letter-spacing: 1.5px;
        }

        .lab-name {
            font-size: 9pt;
            font-weight: bold;
            margin: 3px 0;
        }

        .univ-name {
            font-size: 8pt;
            font-weight: bold;
            margin: 0;
        }

        .mata-kuliah {
            font-size: 10pt;
            font-weight: bold;
            margin: 5px 0 0;
            text-transform: uppercase;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        /* Student Info */
        .student-info-section {
            margin: 12px 0;
            width: 100%;
        }

        .info-table {
            border-collapse: collapse;
            width: 100%;
        }

        .info-table td {
            padding: 2px 5px;
            font-size: 9pt;
            vertical-align: top;
        }

        .info-table .label {
            width: 80px;
            font-weight: normal;
        }

        .info-table .separator {
            width: 15px;
            text-align: center;
        }

        .info-table .value {
            font-weight: bold;
        }

        .photo-cell {
            width: 70px;
            text-align: right;
            vertical-align: top;
        }

        .student-photo {
            width: 65px;
            height: 85px;
            border: 1px solid #333;
            display: inline-block;
            text-align: center;
            line-height: 85px;
            font-size: 7pt;
            color: #999;
        }

        .photo-img {
            width: 65px;
            height: 85px;
            object-fit: cover;
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
            padding: 4px 5px;
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
            height: 20px;
        }

        /* Footer Signature */
        .kartu-footer {
            margin-top: 15px;
            text-align: right;
        }

        .signature-section {
            display: inline-block;
            text-align: center;
            min-width: 150px;
        }

        .signature-section p {
            margin: 0;
            font-size: 8pt;
        }

        .signature-space {
            height: 40px;
        }
    </style>
</head>
<body>
    @foreach($allKartuKontrol as $kartu)
    <div class="kartu-kontrol">
        {{-- Header --}}
        <div class="kartu-header">
            <h1 class="kartu-title">KARTU KONTROL</h1>
            <h2 class="lab-name">LABORATORIUM TEKNIK INFORMATIKA</h2>
            <h3 class="univ-name">UNIVERSITAS MUHAMMADIYAH PAREPARE</h3>
            <h2 class="mata-kuliah">{{ $kartu['jadwal']->mata_kuliah ?? 'PRAKTIKUM' }}</h2>
        </div>

        {{-- Student Info --}}
        <div class="student-info-section">
            <table class="info-table">
                <tr>
                    <td class="label">NIM</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $kartu['user']->nim ?? '-' }}</td>
                    <td class="photo-cell" rowspan="4">
                        @if($kartu['pendaftaran']->kartu_kontrol_path)
                            <img src="{{ public_path('storage/' . $kartu['pendaftaran']->kartu_kontrol_path) }}" class="photo-img">
                        @else
                            <div class="student-photo">FOTO 3x4</div>
                        @endif
                    </td>
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
                <p>Kepala LAB TI,</p>
                <div class="signature-space"></div>
                <p style="font-weight: bold; text-decoration: underline;">Ir. Untung Suwardoyo, S.Kom., M.T., I.P.P.</p>
                <p>NBM. 1288 973</p>
            </div>
        </div>
    </div>
    @endforeach
</body>
</html>
