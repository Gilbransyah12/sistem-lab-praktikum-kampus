<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\PendaftaranPraktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $peserta = $user->peserta;

        if (!$peserta) {
            return redirect()->route('peserta.dashboard')->with('error', 'Data peserta tidak ditemukan.');
        }

        // Get jadwal from approved pendaftaran
        $pendaftaran = PendaftaranPraktikum::with(['praktikum', 'kelas'])
            ->where('peserta_id', $peserta->id)
            ->where('status', 'diterima')
            ->get();

        $jadwal = collect();

        foreach ($pendaftaran as $p) {
            $jadwalPraktikum = Jadwal::with(['praktikum', 'kelas', 'ruangan', 'instruktur'])
                ->where('kelas_id', $p->kelas_id)
                ->where('praktikum_id', $p->praktikum_id)
                ->get();
            
            $jadwal = $jadwal->merge($jadwalPraktikum);
        }

        return view('peserta.jadwal.index', compact('jadwal'));
    }

    public function show(Jadwal $jadwal)
    {
        $user = Auth::user();
        $peserta = $user->peserta;

        if (!$peserta) {
             return redirect()->route('peserta.dashboard')->with('error', 'Data peserta tidak ditemukan.');
        }

        // Verify peserta has access to this jadwal
        $hasAccess = PendaftaranPraktikum::where('peserta_id', $peserta->id)
            ->where('kelas_id', $jadwal->kelas_id)
            ->where('praktikum_id', $jadwal->praktikum_id)
            ->where('status', 'diterima')
            ->exists();

        if (!$hasAccess) {
            abort(403);
        }

        $jadwal->load(['praktikum', 'kelas', 'ruangan', 'instruktur', 'sesi']);

        // Get absensi for this peserta
        $pendaftaran = PendaftaranPraktikum::where('peserta_id', $peserta->id)
            ->where('kelas_id', $jadwal->kelas_id)
            ->where('praktikum_id', $jadwal->praktikum_id)
            ->first();

        $absensi = Absensi::where('pendaftaran_id', $pendaftaran->id)
            ->whereIn('sesi_id', $jadwal->sesi->pluck('id'))
            ->pluck('status', 'sesi_id')
            ->toArray();

        return view('peserta.jadwal.show', compact('jadwal', 'absensi'));
    }
}
