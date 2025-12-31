<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SertifikatController extends Controller
{
    public function index()
    {
        $peserta = auth()->user()->peserta;
        
        $sertifikats = Sertifikat::whereHas('pendaftaran', function ($query) use ($peserta) {
            $query->where('peserta_id', $peserta->id);
        })->with(['pendaftaran.praktikum', 'pendaftaran.periode'])->get();

        return view('mahasiswa.sertifikat.index', compact('sertifikats'));
    }

    public function print($id)
    {
        $peserta = auth()->user()->peserta;

        // Ensure the certificate belongs to the logged-in user
        $sertifikat = Sertifikat::whereHas('pendaftaran', function ($query) use ($peserta) {
            $query->where('peserta_id', $peserta->id);
        })->with(['pendaftaran.peserta', 'pendaftaran.praktikum'])->findOrFail($id);
        
        // Generate QR Code content (URL Verifikasi)
        $url = route('verifikasi.check', $sertifikat->kode_unik);
        $qrcode = QrCode::size(150)->generate($url);
        
        // Reuse the admin print view
        return view('admin.sertifikat.print', compact('sertifikat', 'qrcode'));
    }
}
