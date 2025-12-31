<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Tidak Ditemukan - Lab UMPAR</title>
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
        <div class="bg-red-500 p-8 text-center">
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                <i class="fas fa-times-circle text-4xl text-white"></i>
            </div>
            <h1 class="text-white text-2xl font-bold">Tidak Ditemukan</h1>
            <p class="text-red-100 mt-2">Maaf, data sertifikat tidak ditemukan dalam sistem kami.</p>
        </div>

        <!-- Content -->
        <div class="p-8">
            <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-6">
                <h3 class="text-red-800 font-bold flex items-center gap-2 mb-2">
                    <i class="fas fa-exclamation-triangle"></i> PERINGATAN KEAMANAN
                </h3>
                <p class="text-red-700 text-sm leading-relaxed">
                    Sistem <strong>TIDAK MENGENALI</strong> kode sertifikat ini. Ada kemungkinan:
                    <ul class="list-disc list-inside mt-2 ml-1 space-y-1 text-red-700/90">
                        <li>Dokumen ini <strong>PALSU</strong> atau hasil manipulasi.</li>
                        <li>Kode QR/URL telah dirusak.</li>
                        <li>Sertifikat belum pernah diterbitkan secara resmi.</li>
                    </ul>
                </p>
            </div>

            <p class="text-slate-600 text-sm text-center mb-6 leading-relaxed">
                Jika Anda menerima dokumen fisik dengan QR Code yang mengarah ke halaman ini, mohon untuk <strong>TIDAK MENERIMA</strong> dokumen tersebut sebagai bukti yang sah.
            </p>

            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-slate-800 text-white px-6 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors w-full justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 card-transition">
                <i class="fas fa-shield-alt"></i> Laporkan / Kembali
            </a>
        </div>

        <!-- Footer -->
        <div class="bg-slate-50 p-4 border-t border-slate-100 text-center">
             <p class="text-slate-400 text-xs">
                &copy; {{ date('Y') }} Lab Praktikum UMPAR.
            </p>
        </div>
    </div>

</body>
</html>
