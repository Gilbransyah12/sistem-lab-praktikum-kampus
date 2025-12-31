<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Praktikum - {{ $user->nim }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; padding: 0; color: #0f766e; }
        .header p { margin: 5px 0 0; color: #64748b; }
        
        .student-info { margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; }
        .student-info table { width: 100%; border: none; }
        .student-info td { padding: 4px 0; }
        .label { font-weight: bold; width: 100px; color: #475569; }
        
        table.jadwal { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.jadwal th, table.jadwal td { border: 1px solid #cbd5e1; padding: 8px 10px; text-align: left; }
        table.jadwal th { background-color: #f1f5f9; color: #0f172a; font-weight: bold; }
        table.jadwal tr:nth-child(even) { background-color: #f8fafc; }
        
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="header">
        <h2>JADWAL PRAKTIKUM</h2>
        <p>LABORATORIUM KOMPUTER UNIVERSITAS MUHAMMADIYAH PAREPARE</p>
    </div>

    <div class="student-info">
        <table>
            <tr>
                <td class="label">Nama</td>
                <td>: {{ $user->nama }}</td>
            </tr>
            <tr>
                <td class="label">NIM</td>
                <td>: {{ $user->nim }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Cetak</td>
                <td>: {{ now()->format('d F Y, H:i') }}</td>
            </tr>
        </table>
    </div>

    <table class="jadwal">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Praktikum</th>
                <th width="20%">Mata Kuliah</th>
                <th width="10%">Kelas</th>
                <th width="20%">Waktu</th>
                <th width="10%">Ruangan</th>
                <th width="15%">Instruktur</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jadwal as $index => $j)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td>PRAKTIKUM {{ $j->praktikum->praktikum_ke ?? '-' }}</td>
                <td>{{ $j->mata_kuliah ?? '-' }}</td>
                <td style="text-align: center;">{{ $j->kelas->nama_kelas ?? '-' }}</td>
                <td>
                    {{ $j->hari }}<br>
                    <small>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</small>
                </td>
                <td>{{ $j->ruangan->nama_ruangan ?? '-' }}</td>
                <td>{{ $j->instruktur->nama ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px;">
                    Tidak ada jadwal praktikum.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak secara otomatis melalui Sistem Informasi Laboratorium</p>
    </div>
</body>
</html>
