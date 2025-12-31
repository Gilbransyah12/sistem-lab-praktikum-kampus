<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Modul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ModulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        $query = Jadwal::with(['praktikum', 'kelas'])
            ->where('instruktur_id', $user->id)
            ->withCount('modul');

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

        return view('instruktur.modul.index', compact('jadwal', 'kelasList', 'praktikumList'));
    }

    /**
     * Show modules for a specific jadwal.
     */
    public function show(Jadwal $jadwal)
    {
        if ($jadwal->instruktur_id != Auth::id()) {
            abort(403);
        }

        $jadwal->load(['praktikum', 'kelas']);
        $modul = Modul::where('jadwal_id', $jadwal->id)
            ->orderBy('pertemuan_ke')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('instruktur.modul.show', compact('jadwal', 'modul'));
    }

    /**
     * Show the form for creating a new modul.
     */
    public function create(Jadwal $jadwal)
    {
        if ($jadwal->instruktur_id != Auth::id()) {
            abort(403);
        }

        $jadwal->load(['praktikum', 'kelas']);

        return view('instruktur.modul.create', compact('jadwal'));
    }

    /**
     * Store a newly created modul in storage.
     */
    public function store(Request $request, Jadwal $jadwal)
    {
        if ($jadwal->instruktur_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'pertemuan_ke' => 'nullable|integer|min:1',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar|max:10240', // max 10MB
        ], [
            'file.uploaded' => 'Gagal mengupload file. Kemungkinan ukuran file melebihi batas upload server (upload_max_filesize). Coba upload file yang lebih kecil.',
            'file.max' => 'Ukuran file tidak boleh lebih dari 10MB.',
            'file.mimes' => 'Format file harus berupa PDF, DOC, PPT, XLS, ZIP, atau RAR.',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('modul/' . $jadwal->id, $fileName, 'public');

        Modul::create([
            'jadwal_id' => $jadwal->id,
            'instruktur_id' => Auth::id(),
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'pertemuan_ke' => $validated['pertemuan_ke'],
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
        ]);

        return redirect()->route('instruktur.modul.show', $jadwal)
            ->with('success', 'Modul berhasil diupload');
    }

    /**
     * Download modul file.
     */
    public function download(Modul $modul)
    {
        if ($modul->instruktur_id != Auth::id()) {
            abort(403);
        }

        return Storage::disk('public')->download($modul->file_path, $modul->file_name);
    }

    /**
     * Remove the specified modul from storage.
     */
    public function destroy(Modul $modul)
    {
        if ($modul->instruktur_id != Auth::id()) {
            abort(403);
        }

        // Delete file from storage
        Storage::disk('public')->delete($modul->file_path);

        $jadwal = $modul->jadwal;
        $modul->delete();

        return redirect()->route('instruktur.modul.show', $jadwal)
            ->with('success', 'Modul berhasil dihapus');
    }
}
