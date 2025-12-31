<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\JadwalSesi;
use App\Models\PendaftaranPraktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $data = [
            'jadwal_aktif' => Jadwal::with(['praktikum', 'kelas', 'ruangan'])
                ->where('instruktur_id', $user->id)
                ->count(),
            'total_peserta' => PendaftaranPraktikum::whereHas('jadwal', function($q) use ($user) {
                    $q->where('instruktur_id', $user->id);
                })
                ->where('status', 'diterima')
                ->count(),
            'jadwal' => Jadwal::with(['praktikum', 'kelas', 'ruangan', 'periode'])
                ->where('instruktur_id', $user->id)
                ->get(),
        ];

        return view('instruktur.dashboard', $data);
    }
}
