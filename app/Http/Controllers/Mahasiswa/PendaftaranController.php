<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\PendaftaranPraktikum;
use App\Models\PeriodePendaftaran;
use App\Models\Praktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $pendaftaran = PendaftaranPraktikum::with(['praktikum', 'kelas', 'periode'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('mahasiswa.pendaftaran.index', compact('pendaftaran'));
    }

    public function create()
    {
        // Ambil SEMUA periode yang aktif
        $activePeriods = PeriodePendaftaran::where('is_aktif', true)->get();

        if ($activePeriods->isEmpty()) {
            return redirect()->route('mahasiswa.pendaftaran.index')
                ->with('error', 'Tidak ada periode pendaftaran yang aktif saat ini');
        }

        $kelas = Kelas::all();

        return view('mahasiswa.pendaftaran.create', compact('activePeriods', 'kelas'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'periode_id' => 'required|exists:periode_pendaftaran,id', // User memilih Periode (Praktikum Ke-X)
            'kelas_id' => 'required|exists:kelas,id',
            'kartu_kontrol' => 'required|image|max:2048', // Pas Foto
            'krs' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // KRS
            'berkas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Bukti Pembayaran
        ]);

        $periode = PeriodePendaftaran::findOrFail($validated['periode_id']);

        if (!$periode->is_aktif) {
            return redirect()->back()->with('error', 'Periode yang dipilih sudah tidak aktif.');
        }

        // AUTO-RESOLVE Praktikum ID based on Periode's praktikum_ke
        $mapRomawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
            6 => 'VI', 7 => 'VII', 8 => 'VIII'
        ];
        $romawi = $mapRomawi[$periode->praktikum_ke] ?? (string)$periode->praktikum_ke;

        // Cari Praktikum yang sesuai dengan sequence tersebut
        // Asumsi: 1 Sequence = 1 Mata Kuliah Praktikum (atau ambil yang pertama ketemu)
        $praktikum = Praktikum::where('praktikum_ke', $romawi)->first();

        // Jika praktikum tidak ditemukan, tetap simpan pendaftaran dengan praktikum_id NULL
        // Admin akan melengkapi nanti saat membuat jadwal/modul
        $praktikumId = $praktikum ? $praktikum->id : null;

        // Check if already registered for this period (regardless of praktikum)
        // Jika belum ada praktikum_id, kita cek berdasarkan user dan periode saja
        $existing = PendaftaranPraktikum::where('user_id', $user->id)
            ->where('periode_id', $periode->id)
            ->when($praktikumId, function($query) use ($praktikumId) {
                return $query->where('praktikum_id', $praktikumId);
            })
            ->exists();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Anda sudah mengajukan pendaftaran untuk periode ini.');
        }

        $data = [
            'user_id' => $user->id,
            'peserta_id' => null, // Will be set when approved by admin
            'praktikum_id' => $praktikumId, // Bisa NULL jika admin belum input praktikum
            'kelas_id' => $validated['kelas_id'],
            'periode_id' => $periode->id,
            'tanggal_daftar' => now()->toDateString(),
            'status' => 'pending',
        ];

        if ($request->hasFile('kartu_kontrol')) {
            $data['kartu_kontrol_path'] = $request->file('kartu_kontrol')->store('pendaftaran/foto', 'public');
        }

        if ($request->hasFile('krs')) {
            $data['krs_path'] = $request->file('krs')->store('pendaftaran/krs', 'public');
        }

        if ($request->hasFile('berkas')) {
            $data['berkas_path'] = $request->file('berkas')->store('pendaftaran/pembayaran', 'public');
        }

        PendaftaranPraktikum::create($data);

        return redirect()->route('mahasiswa.pendaftaran.index')
            ->with('success', 'Pendaftaran Berhasil Dikirim!');
    }

    public function show(PendaftaranPraktikum $pendaftaran)
    {
        $user = Auth::user();

        if ($pendaftaran->user_id != $user->id) {
            abort(403);
        }

        $pendaftaran->load(['praktikum', 'kelas', 'periode']);

        return view('mahasiswa.pendaftaran.show', compact('pendaftaran'));
    }
}
