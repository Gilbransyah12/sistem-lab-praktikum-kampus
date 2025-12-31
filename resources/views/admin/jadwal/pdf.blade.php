<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Praktikum</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            color: #333;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .badge {
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 0.8em;
            color: white;
            background-color: #666;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Daftar Jadwal Praktikum</h2>
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Waktu</th>
                <th width="10%">Kelas</th>
                <th width="20%">Mata Kuliah</th>
                <th width="20%">Praktikum</th>
                <th width="15%">Instruktur</th>
                <th width="15%">Ruangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jadwal as $index => $j)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $j->hari }}</strong><br>
                    {{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}
                </td>
                <td>{{ $j->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $j->mata_kuliah ?? '-' }}</td>
                <td>
                    {{ $j->praktikum->nama_praktikum ?? '-' }}<br>
                    <small style="color: #666;">Praktikum {{ $j->praktikum->praktikum_ke ?? '-' }}</small>
                </td>
                <td>{{ $j->instruktur->nama ?? '-' }}</td>
                <td>{{ $j->ruangan->nama_ruangan ?? '-' }} ({{ $j->ruangan->kode_ruangan ?? '-' }})</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
