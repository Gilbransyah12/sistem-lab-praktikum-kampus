<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\PendaftaranPraktikum;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $peserta = $user->peserta;

        // Only show jadwal if user is already a peserta
        if (!$peserta) {
            return view('mahasiswa.jadwal.index', [
                'jadwal' => collect(),
                'is_peserta' => false,
            ]);
        }

        // Get approved registrations
        $pendaftaranDiterima = PendaftaranPraktikum::where('user_id', $user->id)
            ->where('status', 'diterima')
            ->get();

        // Strict filter: Get jadwal matching accepted (praktikum_id, kelas_id) pairs
        $jadwal = Jadwal::with(['praktikum', 'kelas', 'ruangan', 'instruktur', 'sesi'])
            ->whereIn('praktikum_id', $pendaftaranDiterima->pluck('praktikum_id'))
            ->whereIn('kelas_id', $pendaftaranDiterima->pluck('kelas_id'))
            ->get()
            ->filter(function ($j) use ($pendaftaranDiterima) {
                return $pendaftaranDiterima->where('praktikum_id', $j->praktikum_id)
                                           ->where('kelas_id', $j->kelas_id)
                                           ->isNotEmpty();
            });

        return view('mahasiswa.jadwal.index', [
            'jadwal' => $jadwal,
            'is_peserta' => true,
        ]);
    }

    public function show(Jadwal $jadwal)
    {
        $user = Auth::user();
        $peserta = $user->peserta;

        if (!$peserta) {
            abort(403, 'Anda belum terdaftar sebagai peserta');
        }

        // Check if user has access to this jadwal
        $hasAccess = PendaftaranPraktikum::where('user_id', $user->id)
            ->where('kelas_id', $jadwal->kelas_id)
            ->where('status', 'diterima')
            ->exists();

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke jadwal ini');
        }

        // Get Pendaftaran ID for this user and class
        $pendaftaran = PendaftaranPraktikum::where('user_id', $user->id)
            ->where('kelas_id', $jadwal->kelas_id)
            ->where('status', 'diterima')
            ->first();

        // Get Attendance Data
        $absensi = \App\Models\Absensi::where('pendaftaran_id', $pendaftaran->id)
            ->pluck('status', 'sesi_id')
            ->toArray();

        $jadwal->load(['praktikum', 'kelas', 'ruangan', 'instruktur', 'sesi', 'modul']);

        return view('mahasiswa.jadwal.show', compact('jadwal', 'peserta', 'absensi'));
    }

    public function exportPdf()
    {
        $user = Auth::user();
        
        // Get approved registrations
        $pendaftaranDiterima = PendaftaranPraktikum::where('user_id', $user->id)
            ->where('status', 'diterima')
            ->get();

        // Strict filter: Get jadwal matching accepted (praktikum_id, kelas_id) pairs
        $jadwal = Jadwal::with(['praktikum', 'kelas', 'ruangan', 'instruktur'])
            ->whereIn('praktikum_id', $pendaftaranDiterima->pluck('praktikum_id'))
            ->whereIn('kelas_id', $pendaftaranDiterima->pluck('kelas_id'))
            ->get()
            ->filter(function ($j) use ($pendaftaranDiterima) {
                return $pendaftaranDiterima->where('praktikum_id', $j->praktikum_id)
                                           ->where('kelas_id', $j->kelas_id)
                                           ->isNotEmpty();
            });

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('mahasiswa.jadwal.pdf', [
            'jadwal' => $jadwal,
            'user' => $user
        ]);

        return $pdf->download('jadwal-praktikum-' . $user->nim . '.pdf');
    }
}
