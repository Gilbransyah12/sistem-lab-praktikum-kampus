<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\PeriodePendaftaran;
use App\Models\Praktikum;
use App\Models\Ruangan;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $query = Jadwal::with(['periode', 'kelas', 'ruangan', 'instruktur', 'praktikum']);

        // Search
        if (request('search')) {
            $search = request('search');
            $query->whereHas('praktikum', function ($q) use ($search) {
                $q->where('nama_praktikum', 'like', "%{$search}%");
            })->orWhereHas('kelas', function ($q) use ($search) {
                $q->where('nama_kelas', 'like', "%{$search}%");
            })->orWhereHas('instruktur', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })->orWhere('mata_kuliah', 'like', "%{$search}%");
        }

        // Filter by Kelas
        if (request('kelas_id')) {
            $query->where('kelas_id', request('kelas_id'));
        }

        // Filter by Praktikum
        if (request('praktikum_id')) {
            $query->where('praktikum_id', request('praktikum_id'));
        }

        $jadwal = $query->latest()->paginate(10);
        $kelas_filter = Kelas::all(); // For dropdown options
        $praktikum_filter = Praktikum::all(); // For dropdown options

        return view('admin.jadwal.index', compact('jadwal', 'kelas_filter', 'praktikum_filter'));
    }

    public function create()
    {
        $data = [
            'periode' => PeriodePendaftaran::latest()->get(),
            'kelas' => Kelas::all(),
            'ruangan' => Ruangan::where('status', 'aktif')->get(),
            'instruktur' => User::where('role', 'instruktur')->get(),
            'praktikum' => Praktikum::all(),
        ];
        return view('admin.jadwal.create', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'periode_id' => 'required|exists:periode_pendaftaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'ruangan_id' => 'required|exists:ruangan,id',
            'instruktur_id' => 'required|exists:users,id',
            'praktikum_id' => 'required|exists:praktikum,id',
            'mata_kuliah' => 'required|string|max:255',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        Jadwal::create($validated);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function show(Jadwal $jadwal)
    {
        $jadwal->load(['periode', 'kelas', 'ruangan', 'instruktur', 'praktikum', 'sesi']);
        
        // Fetch enrolled students with their grades
        $peserta = \App\Models\PendaftaranPraktikum::with(['peserta', 'nilai'])
            ->where('kelas_id', $jadwal->kelas_id)
            ->where('praktikum_id', $jadwal->praktikum_id)
            ->where('status', 'diterima')
            ->get();

        return view('admin.jadwal.show', compact('jadwal', 'peserta'));
    }

    public function edit(Jadwal $jadwal)
    {
        $data = [
            'jadwal' => $jadwal,
            'periode' => PeriodePendaftaran::all(),
            'kelas' => Kelas::all(),
            'ruangan' => Ruangan::all(),
            'instruktur' => User::where('role', 'instruktur')->get(),
            'praktikum' => Praktikum::all(),
        ];
        return view('admin.jadwal.edit', $data);
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $validated = $request->validate([
            'periode_id' => 'required|exists:periode_pendaftaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'ruangan_id' => 'required|exists:ruangan,id',
            'instruktur_id' => 'required|exists:users,id',
            'praktikum_id' => 'required|exists:praktikum,id',
            'mata_kuliah' => 'required|string|max:255',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $jadwal->update($validated);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }

    public function exportPdf(Request $request)
    {
        $query = Jadwal::with(['periode', 'kelas', 'ruangan', 'instruktur', 'praktikum']);

        // Apply same filters as Index
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('praktikum', function ($q) use ($search) {
                $q->where('nama_praktikum', 'like', "%{$search}%");
            })->orWhereHas('kelas', function ($q) use ($search) {
                $q->where('nama_kelas', 'like', "%{$search}%");
            })->orWhereHas('instruktur', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })->orWhere('mata_kuliah', 'like', "%{$search}%");
        }

        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->has('praktikum_id') && $request->praktikum_id != '') {
            $query->where('praktikum_id', $request->praktikum_id);
        }

        $jadwal = $query->latest()->get(); // Get all data

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.jadwal.pdf', compact('jadwal'));
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->stream('jadwal_praktikum.pdf');
    }
}
