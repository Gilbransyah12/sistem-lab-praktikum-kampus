<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Data Peserta - PDF Export</title>
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
            padding: 10mm;
        }

        /* Header */
        .pdf-header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #0f766e;
            padding-bottom: 10px;
        }

        .pdf-header h1 {
            font-size: 14pt;
            font-weight: bold;
            color: #0f766e;
            margin-bottom: 3px;
        }

        .pdf-header h2 {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .pdf-header p {
            font-size: 8pt;
            color: #666;
        }

        /* Filter Info */
        .filter-info {
            background: #f0f0f0;
            padding: 8px 12px;
            margin-bottom: 12px;
            border-radius: 4px;
            font-size: 8pt;
        }

        .filter-info strong {
            color: #0f766e;
        }

        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }

        .data-table th {
            background: #0f766e;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #0a5f58;
        }

        .data-table th.center {
            text-align: center;
        }

        .data-table td {
            padding: 6px;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        .data-table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .data-table .col-no {
            width: 25px;
            text-align: center;
        }

        .data-table .col-nim {
            width: 80px;
        }

        .data-table .col-kelas {
            width: 120px;
        }

        .data-table .col-kontak {
            width: 100px;
        }

        .data-table .col-tanggal {
            width: 70px;
            text-align: center;
        }

        .data-table .col-status {
            width: 60px;
            text-align: center;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 7pt;
            font-weight: bold;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        /* Footer */
        .pdf-footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 8pt;
            color: #666;
        }

        .pdf-footer .left {
            float: left;
        }

        .pdf-footer .right {
            float: right;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        /* Summary */
        .summary {
            margin-top: 15px;
            padding: 10px;
            background: #f0fdfa;
            border: 1px solid #0f766e;
            border-radius: 4px;
        }

        .summary h3 {
            font-size: 9pt;
            color: #0f766e;
            margin-bottom: 5px;
        }

        .summary p {
            font-size: 8pt;
        }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="pdf-header">
        <h1>LABORATORIUM TEKNIK INFORMATIKA</h1>
        <h2>UNIVERSITAS MUHAMMADIYAH PAREPARE</h2>
        <p>Daftar Peserta Praktikum</p>
    </div>

    {{-- Filter Info --}}
    @if(!empty($filterInfo))
    <div class="filter-info">
        <strong>Filter:</strong>
        @if(isset($filterInfo['kelas']))
            Kelas: {{ $filterInfo['kelas'] }}
        @endif
        @if(isset($filterInfo['praktikum']))
            @if(isset($filterInfo['kelas'])) | @endif
            Praktikum: {{ $filterInfo['praktikum'] }}
        @endif
    </div>
    @endif

    {{-- Data Table --}}
    <table class="data-table">
        <thead>
            <tr>
                <th class="col-no center">No</th>
                <th class="col-nim">NIM</th>
                <th>Nama Peserta</th>
                <th class="col-kelas">Kelas & Praktikum</th>
                <th class="col-kontak">No. HP/WA</th>
                <th class="col-tanggal center">Tgl Daftar</th>
                <th class="col-status center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peserta as $index => $p)
            <tr>
                <td class="col-no">{{ $index + 1 }}</td>
                <td class="col-nim">{{ $p->nim ?? $p->user->nim ?? '-' }}</td>
                <td>{{ $p->nama ?? $p->user->nama ?? '-' }}</td>
                <td class="col-kelas">
                    {{ $p->kelas->nama_kelas ?? '-' }} - {{ $p->praktikum->nama_praktikum ?? '-' }}
                </td>
                <td class="col-kontak">{{ $p->no_hp_wa ?? $p->user->no_hp_wa ?? '-' }}</td>
                <td class="col-tanggal">{{ $p->tanggal_daftar ? $p->tanggal_daftar->format('d/m/Y') : '-' }}</td>
                <td class="col-status">
                    <span class="badge badge-success">Diterima</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px; color: #999;">
                    Tidak ada data peserta
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Summary --}}
    <div class="summary">
        <h3>Ringkasan</h3>
        <p>Total Peserta: <strong>{{ $peserta->count() }}</strong> orang</p>
    </div>

    {{-- Footer --}}
    <div class="pdf-footer clearfix">
        <div class="left">
            Lab Praktikum UMPAR
        </div>
        <div class="right">
            Dicetak: {{ date('d/m/Y H:i') }}
        </div>
    </div>
</body>
</html>
