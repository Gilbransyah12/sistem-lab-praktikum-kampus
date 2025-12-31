<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\PendaftaranPraktikum;
use App\Models\Praktikum;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $query = PendaftaranPraktikum::with(['user', 'peserta', 'kelas', 'praktikum', 'periode'])
            ->where('status', 'diterima')
            ->latest();

        // Filter by kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter by praktikum
        if ($request->filled('praktikum_id')) {
            $query->where('praktikum_id', $request->praktikum_id);
        }

        // Search by name or NIM
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $peserta = $query->paginate(10)->withQueryString();
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $praktikumList = Praktikum::orderBy('praktikum_ke')->get();

        return view('admin.peserta.index', compact('peserta', 'kelasList', 'praktikumList'));
    }

    public function create()
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        return view('admin.peserta.create', compact('kelasList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string|unique:peserta,nim',
            'nama' => 'required|string|max:255',
            'no_hp_wa' => 'nullable|string|max:20',
            'kelas_id' => 'nullable|exists:kelas,id',
        ]);

        Peserta::create($validated);

        return redirect()->route('admin.peserta.index')
            ->with('success', 'Peserta berhasil ditambahkan');
    }

    public function show(Peserta $peserta)
    {
        $peserta->load('kelas');
        return view('admin.peserta.show', compact('peserta'));
    }

    public function edit(Peserta $peserta)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        return view('admin.peserta.edit', compact('peserta', 'kelasList'));
    }

    public function update(Request $request, Peserta $peserta)
    {
        $validated = $request->validate([
            'nim' => 'required|string|unique:peserta,nim,' . $peserta->id,
            'nama' => 'required|string|max:255',
            'no_hp_wa' => 'nullable|string|max:20',
            'kelas_id' => 'nullable|exists:kelas,id',
        ]);

        $peserta->update($validated);

        return redirect()->route('admin.peserta.index')
            ->with('success', 'Peserta berhasil diperbarui');
    }

    public function destroy(Peserta $peserta)
    {
        $peserta->delete();

        return redirect()->route('admin.peserta.index')
            ->with('success', 'Peserta berhasil dihapus');
    }

    /**
     * Show Kartu Kontrol for a pendaftaran - lists all jadwal or shows specific one
     */
    public function kartuKontrol(PendaftaranPraktikum $pendaftaran, $jadwalId = null)
    {
        $pendaftaran->load(['user', 'praktikum', 'kelas', 'periode', 'peserta']);

        // Get ALL jadwal for this pendaftaran
        $jadwalList = \App\Models\Jadwal::with(['instruktur', 'ruangan', 'praktikum'])
            ->where('kelas_id', $pendaftaran->kelas_id)
            ->where('periode_id', $pendaftaran->periode_id)
            ->orderBy('mata_kuliah')
            ->get();

        // If no specific jadwal requested, show list view
        if (!$jadwalId) {
            $user = $pendaftaran->user;
            return view('admin.peserta.kartu-kontrol-list', compact('pendaftaran', 'user', 'jadwalList'));
        }

        // Show specific jadwal kartu kontrol
        $jadwal = \App\Models\Jadwal::with(['instruktur', 'ruangan'])
            ->findOrFail($jadwalId);

        // Get sesi for the jadwal
        $sesiList = collect([]);
        if ($jadwal) {
            $sesiList = \App\Models\JadwalSesi::where('jadwal_id', $jadwal->id)
                ->orderBy('pertemuan_ke')
                ->get();
        }

        $user = $pendaftaran->user;

        return view('admin.peserta.kartu-kontrol', compact('pendaftaran', 'user', 'jadwal', 'sesiList'));
    }

    /**
     * Print all Kartu Kontrol based on filter
     */
    public function printAllKartuKontrol(Request $request)
    {
        $query = PendaftaranPraktikum::with(['user', 'peserta', 'kelas', 'praktikum', 'periode'])
            ->where('status', 'diterima')
            ->latest();

        // Filter by kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter by praktikum
        if ($request->filled('praktikum_id')) {
            $query->where('praktikum_id', $request->praktikum_id);
        }

        // Search by name or NIM
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $pendaftaranList = $query->get();

        // For each pendaftaran, get all jadwal and build kartu kontrol data
        $allKartuKontrol = collect();
        
        foreach ($pendaftaranList as $pendaftaran) {
            // Get ALL jadwal for this pendaftaran
            $jadwalList = \App\Models\Jadwal::with(['instruktur', 'ruangan', 'praktikum'])
                ->where('kelas_id', $pendaftaran->kelas_id)
                ->where('periode_id', $pendaftaran->periode_id)
                ->orderBy('mata_kuliah')
                ->get();

            foreach ($jadwalList as $jadwal) {
                // Get sesi for each jadwal
                $sesiList = \App\Models\JadwalSesi::where('jadwal_id', $jadwal->id)
                    ->orderBy('pertemuan_ke')
                    ->get();

                $allKartuKontrol->push([
                    'pendaftaran' => $pendaftaran,
                    'user' => $pendaftaran->user,
                    'jadwal' => $jadwal,
                    'sesiList' => $sesiList,
                ]);
            }
        }

        return view('admin.peserta.print-all-kartu-kontrol', compact('allKartuKontrol'));
    }

    /**
     * Export peserta data as PDF
     */
    public function exportPdf(Request $request)
    {
        $query = PendaftaranPraktikum::with(['user', 'peserta', 'kelas', 'praktikum', 'periode'])
            ->where('status', 'diterima')
            ->latest();

        // Filter by kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter by praktikum
        if ($request->filled('praktikum_id')) {
            $query->where('praktikum_id', $request->praktikum_id);
        }

        // Search by name or NIM
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $peserta = $query->get();

        // Get filter info for PDF header
        $filterInfo = [];
        if ($request->filled('kelas_id')) {
            $kelas = Kelas::find($request->kelas_id);
            $filterInfo['kelas'] = $kelas ? $kelas->nama_kelas : '-';
        }
        if ($request->filled('praktikum_id')) {
            $praktikum = Praktikum::find($request->praktikum_id);
            $filterInfo['praktikum'] = $praktikum ? $praktikum->nama_praktikum : '-';
        }

        $pdf = \PDF::loadView('admin.peserta.pdf-peserta', compact('peserta', 'filterInfo'));
        $pdf->setPaper('A4', 'landscape');
        
        $filename = 'Data_Peserta_' . date('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }

    public function export(Request $request)
    {
        $query = PendaftaranPraktikum::with(['user', 'peserta', 'kelas', 'praktikum', 'periode'])
            ->where('status', 'diterima')
            ->latest();

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('praktikum_id')) {
            $query->where('praktikum_id', $request->praktikum_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $peserta = $query->get();
        $filename = "Data_Peserta_" . date('Y-m-d_H-i-s') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($peserta) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

            fputcsv($file, ['DATA PESERTA PRAKTIKUM']);
            fputcsv($file, ['Tanggal Export:', date('d/m/Y H:i')]);
            fputcsv($file, []);

            fputcsv($file, ['No', 'NIM', 'Nama', 'No. HP/WA', 'Kelas', 'Praktikum', 'Tanggal Daftar', 'Kartu Kontrol', 'Berkas']);

            foreach ($peserta as $index => $p) {
                fputcsv($file, [
                    $index + 1,
                    $p->nim ?? $p->user->nim ?? '-',
                    $p->nama ?? $p->user->nama ?? '-',
                    $p->no_hp_wa ?? $p->user->no_hp_wa ?? '-',
                    $p->kelas->nama_kelas ?? '-',
                    $p->praktikum->nama_praktikum ?? '-',
                    $p->tanggal_daftar ? $p->tanggal_daftar->format('d/m/Y') : '-',
                    $p->kartu_kontrol_path ? 'Sudah Upload' : 'Belum Upload',
                    $p->berkas_path ? 'Sudah Upload' : 'Belum Upload'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

