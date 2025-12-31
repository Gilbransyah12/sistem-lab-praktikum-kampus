<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranPraktikum;
use App\Models\Jadwal;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $peserta = $user->peserta;

        if (!$peserta) {
            return redirect()->route('home')->with('error', 'Akun anda belum terdaftar sebagai peserta.');
        }
        
        $pendaftaran = PendaftaranPraktikum::with(['praktikum', 'kelas', 'periode'])
            ->where('peserta_id', $peserta->id)
            ->get();

        $pendaftaranAktif = $pendaftaran->where('status', 'diterima');

        $data = [
            'total_pendaftaran' => $pendaftaran->count(),
            'pendaftaran_diterima' => $pendaftaranAktif->count(),
            'pendaftaran_terbaru' => $pendaftaran->sortByDesc('created_at')->take(5),
        ];

        return view('peserta.dashboard', $data);
    }
}
