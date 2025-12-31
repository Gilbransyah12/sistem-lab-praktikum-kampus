<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\JadwalSesi;
use App\Models\PendaftaranPraktikum;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalSesi::with(['jadwal.praktikum', 'jadwal.kelas', 'jadwal.instruktur']);

        if ($request->has('jadwal_id') && $request->jadwal_id != '') {
            $query->where('jadwal_id', $request->jadwal_id);
        }

        $sesi = $query->latest()->paginate(10);
        $jadwal = Jadwal::with(['praktikum', 'kelas'])->get();

        return view('admin.absensi.index', compact('sesi', 'jadwal'));
    }

    public function show(JadwalSesi $sesi)
    {
        $sesi->load(['jadwal.praktikum', 'jadwal.kelas', 'jadwal.instruktur']);
        
        // Get all pendaftaran for this jadwal
        $pendaftaran = PendaftaranPraktikum::with('peserta')
            ->where('kelas_id', $sesi->jadwal->kelas_id)
            ->where('praktikum_id', $sesi->jadwal->praktikum_id)
            ->where('status', 'diterima')
            ->get();

        // Get existing absensi for this sesi
        $absensi = Absensi::where('sesi_id', $sesi->id)
            ->pluck('status', 'pendaftaran_id')
            ->toArray();

        return view('admin.absensi.show', compact('sesi', 'pendaftaran', 'absensi'));
    }

    public function laporan(Request $request)
    {
        $jadwal = Jadwal::with(['praktikum', 'kelas', 'instruktur'])->get();
        
        $data = [];
        if ($request->has('jadwal_id') && $request->jadwal_id != '') {
            $selectedJadwal = Jadwal::with(['sesi', 'praktikum', 'kelas'])->find($request->jadwal_id);
            
            $pendaftaran = PendaftaranPraktikum::with(['peserta'])
                ->where('kelas_id', $selectedJadwal->kelas_id)
                ->where('praktikum_id', $selectedJadwal->praktikum_id)
                ->where('status', 'diterima')
                ->get();

            foreach ($pendaftaran as $p) {
                $absensi = Absensi::where('pendaftaran_id', $p->id)
                    ->whereIn('sesi_id', $selectedJadwal->sesi->pluck('id'))
                    ->get()
                    ->keyBy('sesi_id');

                $data[] = [
                    'peserta' => $p->peserta,
                    'absensi' => $absensi,
                    'total_hadir' => $absensi->where('status', 'Hadir')->count(),
                ];
            }
        }

        return view('admin.absensi.laporan', compact('jadwal', 'data', 'request'));
    }

    public function export(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id'
        ]);

        $selectedJadwal = Jadwal::with(['sesi', 'praktikum', 'kelas', 'instruktur'])->find($request->jadwal_id);
        
        $pendaftaran = PendaftaranPraktikum::with(['peserta'])
            ->where('kelas_id', $selectedJadwal->kelas_id)
            ->where('praktikum_id', $selectedJadwal->praktikum_id)
            ->where('status', 'diterima')
            ->get();

        $totalSesi = $selectedJadwal->sesi->count();
        $filename = "Laporan_Absensi_" . str_replace(' ', '_', $selectedJadwal->praktikum->nama_praktikum ?? 'Data') . "_" . str_replace(' ', '_', $selectedJadwal->kelas->nama_kelas ?? 'Kelas') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($pendaftaran, $selectedJadwal, $totalSesi) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM for Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header Info
            fputcsv($file, ['LAPORAN REKAP ABSENSI PRAKTIKUM']);
            fputcsv($file, ['Praktikum:', $selectedJadwal->praktikum->nama_praktikum ?? '-']);
            fputcsv($file, ['Kelas:', $selectedJadwal->kelas->nama_kelas ?? '-']);
            fputcsv($file, ['Instruktur:', $selectedJadwal->instruktur->nama ?? '-']);
            fputcsv($file, ['Total Sesi:', $totalSesi]);
            fputcsv($file, []); // Empty line

            // Table Header
            fputcsv($file, ['No', 'NIM', 'Nama Peserta', 'Total Hadir', 'Total Sesi', 'Persentase (%)']);

            foreach ($pendaftaran as $index => $p) {
                $totalHadir = Absensi::where('pendaftaran_id', $p->id)
                    ->whereIn('sesi_id', $selectedJadwal->sesi->pluck('id'))
                    ->where('status', 'Hadir')
                    ->count();

                $percentage = $totalSesi > 0 ? round(($totalHadir / $totalSesi) * 100) : 0;

                fputcsv($file, [
                    $index + 1,
                    $p->peserta->nim ?? '-',
                    $p->peserta->nama ?? '-',
                    $totalHadir,
                    $totalSesi,
                    $percentage . '%'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function pdf(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id'
        ]);

        $selectedJadwal = Jadwal::with(['sesi', 'praktikum', 'kelas', 'instruktur'])->find($request->jadwal_id);
        
        $pendaftaran = PendaftaranPraktikum::with(['peserta'])
            ->where('kelas_id', $selectedJadwal->kelas_id)
            ->where('praktikum_id', $selectedJadwal->praktikum_id)
            ->where('status', 'diterima')
            ->get();

        $totalSesi = $selectedJadwal->sesi->count();
        $data = [];

        foreach ($pendaftaran as $p) {
            $absensi = Absensi::where('pendaftaran_id', $p->id)
                ->whereIn('sesi_id', $selectedJadwal->sesi->pluck('id'))
                ->get();

            $totalHadir = $absensi->where('status', 'Hadir')->count();

            $data[] = [
                'peserta' => $p->peserta,
                'total_hadir' => $totalHadir,
                'percentage' => $totalSesi > 0 ? round(($totalHadir / $totalSesi) * 100) : 0
            ];
        }

        $pdf = Pdf::loadView('admin.absensi.pdf', compact('selectedJadwal', 'data', 'totalSesi'));
        $filename = 'Laporan_Absensi_' . str_replace(' ', '_', $selectedJadwal->praktikum->nama_praktikum ?? 'Data') . '.pdf';
        return $pdf->download($filename);
    }
}
