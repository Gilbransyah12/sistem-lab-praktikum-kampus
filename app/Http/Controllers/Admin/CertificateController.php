<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranPraktikum;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateController extends Controller
{
    public function generate(Request $request, $pendaftaranId)
    {
        $pendaftaran = PendaftaranPraktikum::findOrFail($pendaftaranId);
        
        // Cek apakah sudah ada sertifikat
        $sertifikat = Sertifikat::where('pendaftaran_id', $pendaftaran->id)->first();
        
        if (!$sertifikat) {
            $sertifikat = Sertifikat::create([
                'pendaftaran_id' => $pendaftaran->id,
                'kode_unik' => (string) Str::uuid(),
                'tanggal_terbit' => now(),
                'status' => 'aktif',
            ]);
            
            return back()->with('success', 'Sertifikat berhasil digenerate!');
        }
        
        return back()->with('warning', 'Sertifikat sudah ada.');
    }

    public function print($id)
    {
        $sertifikat = Sertifikat::with(['pendaftaran.peserta', 'pendaftaran.praktikum'])->findOrFail($id);
        
        // Generate QR Code content (URL Verifikasi)
        $url = route('verifikasi.check', $sertifikat->kode_unik);
        $qrcode = QrCode::size(150)->generate($url);
        
        return view('admin.sertifikat.print', compact('sertifikat', 'qrcode'));
    }
}
