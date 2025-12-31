<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\JadwalSesi;
use App\Models\PendaftaranPraktikum;
use Illuminate\Support\Facades\Auth;

class KartuKontrolController extends Controller
{
    /**
     * Display list of Kartu Kontrol for approved registrations
     * Now shows each jadwal (mata kuliah) as a separate kartu kontrol
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get only approved pendaftaran
        $pendaftaranDiterima = PendaftaranPraktikum::with(['praktikum', 'kelas', 'periode'])
            ->where('user_id', $user->id)
            ->where('status', 'diterima')
            ->latest()
            ->get();

        // For each pendaftaran, get all jadwal (mata kuliah)
        $kartuKontrolList = collect();
        
        foreach ($pendaftaranDiterima as $p) {
            // Get ALL jadwal for this pendaftaran's kelas and periode
            $jadwalList = Jadwal::with(['praktikum', 'instruktur', 'ruangan'])
                ->where('kelas_id', $p->kelas_id)
                ->where('periode_id', $p->periode_id)
                ->orderBy('mata_kuliah')
                ->get();

            foreach ($jadwalList as $jadwal) {
                $kartuKontrolList->push([
                    'pendaftaran' => $p,
                    'jadwal' => $jadwal,
                    'mata_kuliah' => $jadwal->mata_kuliah,
                    'praktikum' => $jadwal->praktikum,
                    'kelas' => $p->kelas,
                    'periode' => $p->periode,
                ]);
            }
        }

        return view('mahasiswa.kartu-kontrol.index', compact('kartuKontrolList', 'pendaftaranDiterima'));
    }

    /**
     * Show the Kartu Kontrol for a specific jadwal
     */
    public function show(PendaftaranPraktikum $pendaftaran, Jadwal $jadwal = null)
    {
        $user = Auth::user();

        // Check ownership
        if ($pendaftaran->user_id != $user->id) {
            abort(403);
        }

        // Check if approved
        if ($pendaftaran->status !== 'diterima') {
            return redirect()->route('mahasiswa.kartu-kontrol.index')
                ->with('error', 'Kartu Kontrol hanya tersedia untuk pendaftaran yang sudah diterima.');
        }

        $pendaftaran->load(['praktikum', 'kelas', 'periode', 'peserta']);

        // If jadwal not specified, get first one
        if (!$jadwal) {
            $jadwal = Jadwal::with(['instruktur', 'ruangan'])
                ->where('kelas_id', $pendaftaran->kelas_id)
                ->where('periode_id', $pendaftaran->periode_id)
                ->first();
        } else {
            $jadwal->load(['instruktur', 'ruangan']);
        }

        // Get sesi for the jadwal (for the table)
        $sesiList = collect();
        if ($jadwal) {
            $sesiList = JadwalSesi::where('jadwal_id', $jadwal->id)
                ->orderBy('pertemuan_ke')
                ->get();
        }

        return view('mahasiswa.kartu-kontrol.show', compact('pendaftaran', 'user', 'jadwal', 'sesiList'));
    }

    /**
     * Export Kartu Kontrol as PDF for a specific jadwal
     */
    public function exportPdf(PendaftaranPraktikum $pendaftaran, Jadwal $jadwal = null)
    {
        $user = Auth::user();

        // Check ownership
        if ($pendaftaran->user_id != $user->id) {
            abort(403);
        }

        // Check if approved
        if ($pendaftaran->status !== 'diterima') {
            return redirect()->route('mahasiswa.kartu-kontrol.index')
                ->with('error', 'Kartu Kontrol hanya tersedia untuk pendaftaran yang sudah diterima.');
        }

        $pendaftaran->load(['praktikum', 'kelas', 'periode', 'peserta']);

        // If jadwal not specified, get first one
        if (!$jadwal) {
            $jadwal = Jadwal::with(['instruktur', 'ruangan'])
                ->where('kelas_id', $pendaftaran->kelas_id)
                ->where('periode_id', $pendaftaran->periode_id)
                ->first();
        } else {
            $jadwal->load(['instruktur', 'ruangan']);
        }

        // Get sesi for the jadwal
        $sesiList = collect();
        if ($jadwal) {
            $sesiList = JadwalSesi::where('jadwal_id', $jadwal->id)
                ->orderBy('pertemuan_ke')
                ->get();
        }

        return view('mahasiswa.kartu-kontrol.pdf', compact('pendaftaran', 'user', 'jadwal', 'sesiList'));
    }
}
