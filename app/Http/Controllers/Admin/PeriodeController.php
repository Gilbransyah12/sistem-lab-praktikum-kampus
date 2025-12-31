<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodePendaftaran;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periode = PeriodePendaftaran::latest()->paginate(10);
        return view('admin.periode.index', compact('periode'));
    }

    public function create()
    {
        return view('admin.periode.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'praktikum_ke' => 'required|integer|min:1',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after:tanggal_awal',
            'is_aktif' => 'boolean',
        ]);

        $validated['is_aktif'] = $request->has('is_aktif');

        // Jika periode baru diaktifkan, nonaktifkan periode lain
        if ($validated['is_aktif']) {
            PeriodePendaftaran::where('is_aktif', true)->update(['is_aktif' => false]);
        }

        PeriodePendaftaran::create($validated);

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode pendaftaran berhasil ditambahkan');
    }

    public function edit(PeriodePendaftaran $periode)
    {
        return view('admin.periode.edit', compact('periode'));
    }

    public function update(Request $request, PeriodePendaftaran $periode)
    {
        $validated = $request->validate([
            'tahun_akademik' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'praktikum_ke' => 'required|integer|min:1',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after:tanggal_awal',
            'is_aktif' => 'boolean',
        ]);

        $validated['is_aktif'] = $request->has('is_aktif');

        // Jika periode ini diaktifkan, nonaktifkan periode lain
        if ($validated['is_aktif']) {
            PeriodePendaftaran::where('is_aktif', true)
                ->where('id', '!=', $periode->id)
                ->update(['is_aktif' => false]);
        }

        $periode->update($validated);

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode pendaftaran berhasil diperbarui');
    }

    public function destroy(PeriodePendaftaran $periode)
    {
        $periode->delete();

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode pendaftaran berhasil dihapus');
    }
}
