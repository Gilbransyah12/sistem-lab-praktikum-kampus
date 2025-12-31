<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\PendaftaranPraktikum;
use App\Models\PeriodePendaftaran;
use App\Models\Praktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $peserta = $user->peserta;

        if (!$peserta) {
             return redirect()->route('peserta.dashboard')->with('error', 'Data peserta tidak ditemukan.');
        }
        
        $pendaftaran = PendaftaranPraktikum::with(['praktikum', 'kelas', 'periode'])
            ->where('peserta_id', $peserta->id)
            ->latest()
            ->paginate(10);

        return view('peserta.pendaftaran.index', compact('pendaftaran'));
    }

    public function create()
    {
        $periodeAktif = PeriodePendaftaran::where('is_aktif', true)->first();

        if (!$periodeAktif) {
            return redirect()->route('peserta.pendaftaran.index')
                ->with('error', 'Tidak ada periode pendaftaran yang aktif saat ini');
        }

        $praktikum = Praktikum::all();
        $kelas = Kelas::all();

        return view('peserta.pendaftaran.create', compact('periodeAktif', 'praktikum', 'kelas'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $peserta = $user->peserta;
        
        if (!$peserta) {
             return redirect()->route('peserta.dashboard')->with('error', 'Data peserta tidak ditemukan.');
        }
        $periodeAktif = PeriodePendaftaran::where('is_aktif', true)->first();

        if (!$periodeAktif) {
            return redirect()->route('peserta.pendaftaran.index')
                ->with('error', 'Tidak ada periode pendaftaran yang aktif');
        }

        $validated = $request->validate([
            'praktikum_id' => 'required|exists:praktikum,id',
            'kelas_id' => 'required|exists:kelas,id',
            'berkas' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Check if already registered for this praktikum in this period
        $existing = PendaftaranPraktikum::where('peserta_id', $peserta->id)
            ->where('praktikum_id', $validated['praktikum_id'])
            ->where('periode_id', $periodeAktif->id)
            ->exists();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Anda sudah mendaftar untuk praktikum ini pada periode ini');
        }

        $data = [
            'peserta_id' => $peserta->id,
            'praktikum_id' => $validated['praktikum_id'],
            'kelas_id' => $validated['kelas_id'],
            'periode_id' => $periodeAktif->id,
            'tanggal_daftar' => now()->toDateString(),
            'status' => 'pending',
        ];

        if ($request->hasFile('berkas')) {
            $data['berkas_path'] = $request->file('berkas')->store('berkas', 'public');
        }

        PendaftaranPraktikum::create($data);

        return redirect()->route('peserta.pendaftaran.index')
            ->with('success', 'Pendaftaran praktikum berhasil dikirim');
    }

    public function show(PendaftaranPraktikum $pendaftaran)
    {
        $user = Auth::user();
        $peserta = $user->peserta;

        if (!$peserta) {
            abort(403, 'Data peserta tidak ditemukan.');
        }

        if ($pendaftaran->peserta_id != $peserta->id) {
            abort(403);
        }

        $pendaftaran->load(['praktikum', 'kelas', 'periode']);

        return view('peserta.pendaftaran.show', compact('pendaftaran'));
    }
}
