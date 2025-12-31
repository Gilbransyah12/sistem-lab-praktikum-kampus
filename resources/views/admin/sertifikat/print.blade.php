<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Sertifikat</title>
    <style>
        @page { size: A4 landscape; margin: 0; }
        body { margin: 0; font-family: 'Times New Roman', serif; background: #fff; }
        .certificate-container {
            width: 297mm;
            height: 210mm;
            padding: 20mm;
            box-sizing: border-box;
            position: relative;
            background-image: url('https://raw.githubusercontent.com/public-assets/bg-cert.png'); /* Placeholder BG */
            background-size: cover;
            border: 10px solid #0f766e;
        }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { width: 80px; height: 80px; margin-bottom: 20px; }
        .univ-name { font-size: 24px; font-weight: bold; text-transform: uppercase; color: #333; }
        .title { font-size: 48px; font-weight: bold; color: #0f766e; margin: 20px 0; letter-spacing: 2px; text-transform: uppercase; }
        .subtitle { font-size: 18px; color: #666; margin-bottom: 10px; }
        
        .content { text-align: center; margin-top: 20px; }
        .name { font-size: 36px; font-weight: bold; border-bottom: 2px solid #ccc; display: inline-block; padding: 0 40px 10px; margin: 20px 0; color: #000; }
        .text { font-size: 20px; line-height: 1.6; color: #444; max-width: 800px; margin: 0 auto; }
        .highlight { font-weight: bold; color: #0f766e; }

        .footer { position: absolute; bottom: 40px; left: 40px; right: 40px; display: flex; justify-content: space-between; align-items: flex-end; }
        .signature { text-align: center; }
        .sign-line { border-bottom: 1px solid #000; width: 200px; margin-bottom: 5px; }
        .qr-section { text-align: center; }
        .qr-code { margin-bottom: 10px; }
        .qr-text { font-size: 10px; color: #666; }
        
        @media print {
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="certificate-container">
        <div class="header">
            <!-- Logo Placeholder -->
            <div style="width: 80px; height: 80px; background: #0f766e; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: white; font-weight: bold; font-family: sans-serif;">UP</div>
            <div class="univ-name">Universitas Muhammadiyah Parepare</div>
            <div class="subtitle">Laboratorium Praktikum Terpadu</div>
        </div>

        <div class="content">
            <div class="title">Sertifikat Praktikum</div>
            <div class="text">Diberikan kepada:</div>
            
            <div class="name">{{ $sertifikat->pendaftaran->peserta->nama }}</div>
            
            <div class="text">
                Atas kelulusannya dalam mengikuti kegiatan praktikum <br>
                <span class="highlight">{{ $sertifikat->pendaftaran->praktikum->nama_praktikum }}</span>
            </div>
            
            <div class="text" style="margin-top: 20px;">
                Diselenggarakan pada Periode <span class="highlight">{{ $sertifikat->pendaftaran->periode->nama_periode }}</span>
            </div>
        </div>

        <div class="footer">
            <div class="qr-section">
                <!-- QR Code SVG -->
                <div class="qr-code">
                    {!! $qrcode !!}
                </div>
                <div class="qr-text">Scan untuk verifikasi keaslian</div>
            </div>

            <div class="signature">
                <div style="margin-bottom: 60px;">Parepare, {{ $sertifikat->tanggal_terbit->format('d F Y') }}</div>
                <div class="sign-line"></div>
                <div>Kepala Laboratorium</div>
            </div>
        </div>
    </div>

</body>
</html>
