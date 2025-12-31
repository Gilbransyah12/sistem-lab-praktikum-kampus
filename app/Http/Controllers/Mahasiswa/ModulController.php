<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Modul;
use App\Models\PendaftaranPraktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ModulController extends Controller
{
    /**
     * Download module file for enrolled students.
     */
    public function download(Modul $modul)
    {
        $user = Auth::user();
        $peserta = $user->peserta;

        if (!$peserta) {
            abort(403, 'Akses ditolak.');
        }

        // Security Check: Ensure user is enrolled in the class associated with this module
        // The module belongs to a Jadwal, which belongs to a Kelas.
        // We check if the user has an ACCEPTED PendaftaranPraktikum for this Kelas.
        
        $hasAccess = PendaftaranPraktikum::where('user_id', $user->id)
            ->where('kelas_id', $modul->jadwal->kelas_id)
            ->where('status', 'diterima')
            ->exists();

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke modul ini.');
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($modul->file_path)) {
            return back()->with('error', 'File tidak ditemukan di server.');
        }

        return Storage::disk('public')->download($modul->file_path, $modul->file_name);
    }
}
