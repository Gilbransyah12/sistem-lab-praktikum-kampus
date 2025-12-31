<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranPraktikum;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $peserta = $user->peserta; // Will be null if not yet approved
        
        // Get pendaftaran for this user
        $pendaftaran = PendaftaranPraktikum::with(['praktikum', 'kelas', 'periode'])
            ->where('user_id', $user->id)
            ->get();

        $pendaftaranDiterima = $pendaftaran->where('status', 'diterima');

        // Get Jadwal based on accepted registrations (same praktikum & same kelas)
        $jadwal = \App\Models\Jadwal::with(['praktikum', 'kelas', 'ruangan', 'instruktur'])
            ->whereIn('praktikum_id', $pendaftaranDiterima->pluck('praktikum_id'))
            ->whereIn('kelas_id', $pendaftaranDiterima->pluck('kelas_id'))
            ->orderBy('hari', 'desc') // Simple ordering
            ->get()
            ->filter(function ($j) use ($pendaftaranDiterima) {
                // strict filter: ensure specific pair matches (praktikum A must be with kelas A that user registered for)
                return $pendaftaranDiterima->where('praktikum_id', $j->praktikum_id)
                                           ->where('kelas_id', $j->kelas_id)
                                           ->isNotEmpty();
            });

        $data = [
            'user' => $user,
            'peserta' => $peserta,
            'is_peserta' => $peserta !== null,
            'total_pendaftaran' => $pendaftaran->count(),
            'pendaftaran_diterima' => $pendaftaranDiterima->count(),
            'pendaftaran_terbaru' => $pendaftaran->sortByDesc('created_at')->take(5),
            'jadwal_saya' => $jadwal,
        ];

        return view('mahasiswa.dashboard', $data);
    }

    public function sertifikat()
    {
        return view('mahasiswa.sertifikat.index');
    }
}
