<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\JadwalSesi;
use App\Models\PendaftaranPraktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $query = Jadwal::with(['praktikum', 'kelas', 'ruangan', 'sesi'])
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

        return view('instruktur.absensi.index', compact('jadwal', 'kelasList', 'praktikumList'));
    }

    public function sesi(Jadwal $jadwal)
    {
        // Pastikan jadwal milik instruktur ini
        if ($jadwal->instruktur_id != Auth::id()) {
            abort(403);
        }

        $jadwal->load(['praktikum', 'kelas', 'sesi']);
        
        return view('instruktur.absensi.sesi', compact('jadwal'));
    }

    public function createSesi(Jadwal $jadwal)
    {
        if ($jadwal->instruktur_id != Auth::id()) {
            abort(403);
        }

        $lastPertemuan = JadwalSesi::where('jadwal_id', $jadwal->id)->max('pertemuan_ke') ?? 0;

        return view('instruktur.absensi.create-sesi', [
            'jadwal' => $jadwal,
            'nextPertemuan' => $lastPertemuan + 1,
        ]);
    }

    public function storeSesi(Request $request, Jadwal $jadwal)
    {
        if ($jadwal->instruktur_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'pertemuan_ke' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'materi' => 'nullable|string|max:255',
        ]);

        $validated['jadwal_id'] = $jadwal->id;

        JadwalSesi::create($validated);

        return redirect()->route('instruktur.absensi.sesi', $jadwal)
            ->with('success', 'Sesi pertemuan berhasil ditambahkan');
    }

    public function absen(JadwalSesi $sesi)
    {
        $sesi->load('jadwal');
        
        if ($sesi->jadwal->instruktur_id != Auth::id()) {
            abort(403);
        }

        // Get all approved pendaftaran for this class and praktikum
        $pendaftaran = PendaftaranPraktikum::with('peserta')
            ->where('kelas_id', $sesi->jadwal->kelas_id)
            ->where('praktikum_id', $sesi->jadwal->praktikum_id)
            ->where('status', 'diterima')
            ->get();

        // Get existing absensi
        $absensi = Absensi::where('sesi_id', $sesi->id)
            ->pluck('status', 'pendaftaran_id')
            ->toArray();

        return view('instruktur.absensi.absen', compact('sesi', 'pendaftaran', 'absensi'));
    }

    public function storeAbsen(Request $request, JadwalSesi $sesi)
    {
        $sesi->load('jadwal');
        
        if ($sesi->jadwal->instruktur_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'absensi' => 'required|array',
            'absensi.*.pendaftaran_id' => 'required|exists:pendaftaran_praktikum,id',
            'absensi.*.status' => 'required|in:Hadir,Izin,Sakit,Alfa',
            'absensi.*.keterangan' => 'nullable|string',
        ]);

        foreach ($validated['absensi'] as $item) {
            Absensi::updateOrCreate(
                [
                    'sesi_id' => $sesi->id,
                    'pendaftaran_id' => $item['pendaftaran_id'],
                ],
                [
                    'status' => $item['status'],
                    'keterangan' => $item['keterangan'] ?? null,
                    'waktu_absen' => now(),
                ]
            );
        }

        return redirect()->route('instruktur.absensi.sesi', $sesi->jadwal)
            ->with('success', 'Absensi berhasil disimpan');
    }
    public function statistik(Jadwal $jadwal)
    {
        // 1. Verify Access
        if ($jadwal->instruktur_id != Auth::id()) {
            abort(403);
        }

        $jadwal->load(['praktikum', 'kelas']);

        // 2. Get accepted students
        $students = PendaftaranPraktikum::with(['peserta.user'])
            ->where('kelas_id', $jadwal->kelas_id)
            ->where('praktikum_id', $jadwal->praktikum_id)
            ->where('status', 'diterima')
            ->get();

        // 3. Get all sessions for this schedule
        $sessions = JadwalSesi::where('jadwal_id', $jadwal->id)->get();
        $totalSessions = $sessions->count();

        // 4. Get all attendance records for these sessions
        $attendance = Absensi::whereIn('sesi_id', $sessions->pluck('id'))->get();

        // 5. Calculate Stats per Student
        $statistik = $students->map(function ($student) use ($totalSessions, $attendance) {
            $studentAttendance = $attendance->where('pendaftaran_id', $student->id);
            
            $hadir = $studentAttendance->where('status', 'Hadir')->count();
            $izin = $studentAttendance->where('status', 'Izin')->count();
            $sakit = $studentAttendance->where('status', 'Sakit')->count();
            $alfa = $studentAttendance->where('status', 'Alfa')->count();

            // Calculate Percentage (Hadir / Total Sessions)
            // If total sessions is 0, percentage is 0
            $percentage = $totalSessions > 0 ? round(($hadir / $totalSessions) * 100) : 0;

            return [
                'student' => $student,
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alfa' => $alfa,
                'percentage' => $percentage
            ];
        });

        return view('instruktur.absensi.statistik', compact('jadwal', 'statistik', 'totalSessions'));
    }
}
