<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Praktikum;
use App\Models\Jadwal;
use App\Models\PendaftaranPraktikum;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_peserta' => Peserta::count(),
            'total_instruktur' => User::where('role', 'instruktur')->count(),
            'total_praktikum' => Praktikum::count(),
            'total_pendaftaran' => PendaftaranPraktikum::count(),
            'pendaftaran_terbaru' => PendaftaranPraktikum::with(['peserta', 'praktikum'])
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('admin.dashboard', $data);
    }
}
