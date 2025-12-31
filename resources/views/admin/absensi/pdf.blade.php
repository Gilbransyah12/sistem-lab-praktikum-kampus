<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi Praktikum</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 5px 0;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
        }
        .info-table td {
            padding: 3px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .footer p {
            margin-bottom: 60px;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            color: white;
            font-size: 10px;
        }
        .bg-primary { background-color: #0d6efd; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LABORATORIUM TEKNIK INFORMATIKA</h2>
        <h3>UNIVERSITAS MUHAMMADIYAH PAREPARE</h3>
        <p>Jl. Jend. Ahmad Yani No. 6, Kota Parepare, Sulawesi Selatan</p>
    </div>

    <div class="info-section">
        <h4 style="text-align: center; text-decoration: underline;">LAPORAN REKAPITULASI ABSENSI</h4>
        <table class="info-table">
            <tr>
                <td style="width: 120px;">Praktikum</td>
                <td style="width: 10px;">:</td>
                <td><strong>{{ $selectedJadwal->praktikum->nama_praktikum ?? '-' }}</strong></td>
                <td style="width: 100px;">Kelas</td>
                <td style="width: 10px;">:</td>
                <td>{{ $selectedJadwal->kelas->nama_kelas ?? '-' }}</td>
            </tr>
            <tr>
                <td>Nama Instruktur</td>
                <td>:</td>
                <td>{{ $selectedJadwal->instruktur->nama ?? '-' }}</td>
                <td>Total Sesi</td>
                <td>:</td>
                <td>{{ $totalSesi }} Pertemuan</td>
            </tr>
            <tr>
                <td>Tanggal Cetak</td>
                <td>:</td>
                <td colspan="4">{{ date('d F Y') }}</td>
            </tr>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 30px;" class="text-center">No</th>
                <th style="width: 100px;">NIM</th>
                <th>Nama Peserta</th>
                <th style="width: 80px;" class="text-center">Hadir</th>
                <th style="width: 80px;" class="text-center">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $d)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td><code>{{ $d['peserta']->nim ?? '-' }}</code></td>
                <td>{{ $d['peserta']->nama ?? '-' }}</td>
                <td class="text-center">{{ $d['total_hadir'] }} / {{ $totalSesi }}</td>
                <td class="text-center">{{ $d['percentage'] }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Parepare, {{ date('d F Y') }}</p>
        <strong>Administrator Laboratorium</strong>
    </div>
</body>
</html>
