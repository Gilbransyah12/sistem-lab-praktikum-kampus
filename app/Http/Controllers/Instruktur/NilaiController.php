<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Nilai;
use App\Models\PendaftaranPraktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $query = Jadwal::with(['praktikum', 'kelas'])
            ->where('instruktur_id', $user->id);

        if (request('kelas_id')) {
            $query->where('kelas_id', request('kelas_id'));
        }

        if (request('praktikum_id')) {
            $query->where('praktikum_id', request('praktikum_id'));
        }

        $jadwal = $query->get();

        // Get filter options from existing jadwal
        $allJadwal = Jadwal::with(['kelas', 'praktikum'])
            ->where('instruktur_id', $user->id)
            ->get();
            
        $kelasList = $allJadwal->pluck('kelas')->unique('id')->sortBy('nama_kelas');
        $praktikumList = $allJadwal->pluck('praktikum')->unique('id')->sortBy('praktikum_ke');

        return view('instruktur.nilai.index', compact('jadwal', 'kelasList', 'praktikumList'));
    }

    public function show(Jadwal $jadwal)
    {
        if ($jadwal->instruktur_id != Auth::id()) {
            abort(403);
        }

        $jadwal->load(['praktikum', 'kelas']);

        $pendaftaran = PendaftaranPraktikum::with(['peserta', 'nilai'])
            ->where('kelas_id', $jadwal->kelas_id)
            ->where('praktikum_id', $jadwal->praktikum_id)
            ->where('status', 'diterima')
            ->get();

        return view('instruktur.nilai.show', compact('jadwal', 'pendaftaran'));
    }

    public function edit(Jadwal $jadwal)
    {
        if ($jadwal->instruktur_id != Auth::id()) {
            abort(403);
        }

        $jadwal->load(['praktikum', 'kelas']);

        $pendaftaran = PendaftaranPraktikum::with(['peserta', 'nilai'])
            ->where('kelas_id', $jadwal->kelas_id)
            ->where('praktikum_id', $jadwal->praktikum_id)
            ->where('status', 'diterima')
            ->get();

        return view('instruktur.nilai.edit', compact('jadwal', 'pendaftaran'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        if ($jadwal->instruktur_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nilai' => 'required|array',
            'nilai.*.pendaftaran_id' => 'required|exists:pendaftaran_praktikum,id',
            'nilai.*.nilai_akhir' => 'nullable|numeric|min:0|max:100',
            'nilai.*.catatan' => 'nullable|string',
        ]);

        foreach ($validated['nilai'] as $item) {
            Nilai::updateOrCreate(
                [
                    'pendaftaran_id' => $item['pendaftaran_id'],
                    'praktikum_id' => $jadwal->praktikum_id,
                ],
                [
                    'nilai_akhir' => $item['nilai_akhir'],
                    'catatan' => $item['catatan'] ?? null,
                ]
            );
        }

        return redirect()->route('instruktur.nilai.show', $jadwal)
            ->with('success', 'Nilai berhasil disimpan');
    }
}
