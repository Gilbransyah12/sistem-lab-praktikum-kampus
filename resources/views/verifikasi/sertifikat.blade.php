<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Sertifikat - Lab UMPAR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
        <!-- Header -->
        <div class="bg-gradient-to-r from-teal-500 to-cyan-500 p-6 text-center">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-check-circle text-3xl text-teal-500"></i>
            </div>
            <h1 class="text-white text-xl font-bold">Sertifikat Valid</h1>
            <p class="text-teal-50 text-sm mt-1">Sertifikat ini terdaftar resmi di sistem</p>
        </div>

        <!-- Verification Warning -->
        <div class="bg-amber-50 border-b border-amber-100 p-4 flex items-start gap-3">
            <i class="fas fa-exclamation-triangle text-amber-500 mt-0.5"></i>
            <p class="text-xs text-amber-700 leading-relaxed">
                <strong>PENTING:</strong> Pastikan data di bawah ini (Nama & Praktikum) <strong>SAMA PERSIS</strong> dengan yang tertulis di dokumen fisik. Jika berbeda, maka dokumen fisik tersebut <strong>PALSU</strong>.
            </p>
        </div>

        <!-- Content -->
        <div class="p-8">
            <div class="space-y-6">
                <!-- Info Item -->
                <div class="border-b border-slate-100 pb-4">
                    <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1 block">Pemilik Sertifikat</label>
                    <div class="text-slate-800 font-bold text-lg">{{ $sertifikat->pendaftaran->peserta->nama }}</div>
                    <div class="text-slate-500 text-sm">{{ $sertifikat->pendaftaran->peserta->nim }}</div>
                </div>

                <div class="border-b border-slate-100 pb-4">
                    <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1 block">Praktikum</label>
                    <div class="text-slate-800 font-bold">{{ $sertifikat->pendaftaran->praktikum->nama_praktikum }}</div>
                    <div class="text-teal-600 text-sm font-medium">{{ $sertifikat->pendaftaran->kelas->nama_kelas }}</div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1 block">Tanggal Terbit</label>
                        <div class="text-slate-700 font-medium">{{ $sertifikat->tanggal_terbit->format('d M Y') }}</div>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1 block">Status</label>
                        @if($sertifikat->status === 'aktif')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                AKTIF
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                DICABUT
                            </span>
                        @endif
                    </div>
                </div>


            </div>
        </div>

        <!-- Footer -->
        <div class="bg-slate-50 p-4 border-t border-slate-100 text-center">
            <p class="text-slate-400 text-xs">
                &copy; {{ date('Y') }} Lab Praktikum UMPAR.<br>Data ini valid dan diambil realtime dari sistem.
            </p>
        </div>
    </div>

</body>
</html>
