<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function check($kode)
    {
        $sertifikat = Sertifikat::with(['pendaftaran.peserta', 'pendaftaran.praktikum', 'pendaftaran.nilai'])
            ->where('kode_unik', $kode)
            ->first();

        if (!$sertifikat) {
            return view('verifikasi.not-found');
        }

        return view('verifikasi.sertifikat', compact('sertifikat'));
    }
}
