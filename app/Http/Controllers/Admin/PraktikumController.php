<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Praktikum;
use App\Models\PeriodePendaftaran;
use Illuminate\Http\Request;

class PraktikumController extends Controller
{
    public function index(Request $request)
    {
        $query = Praktikum::query();
        
        if ($request->has('praktikum_ke') && $request->praktikum_ke != '') {
            $query->where('praktikum_ke', $request->praktikum_ke);
        }
        
        $praktikum = $query->latest()->paginate(100);

        // Fetch options for filter
        $maxPraktikum = PeriodePendaftaran::max('praktikum_ke');
        $limit = $maxPraktikum ? max($maxPraktikum, 4) : 4;
        
        $romans = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
            11 => 'XI', 12 => 'XII', 13 => 'XIII', 14 => 'XIV', 15 => 'XV'
        ];
        
        $praktikumOptions = [];
        for ($i = 1; $i <= $limit; $i++) {
            $val = $romans[$i] ?? $i;
            $praktikumOptions[$val] = $val;
        }

        return view('admin.praktikum.index', compact('praktikum', 'praktikumOptions'));
    }

    public function create()
    {
        $maxPraktikum = PeriodePendaftaran::max('praktikum_ke');
        $limit = $maxPraktikum ? max($maxPraktikum, 4) : 4; // Default minimal 4
        
        $romans = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
            11 => 'XI', 12 => 'XII', 13 => 'XIII', 14 => 'XIV', 15 => 'XV'
        ];
        
        $praktikumOptions = [];
        for ($i = 1; $i <= $limit; $i++) {
            $val = $romans[$i] ?? $i; // Fallback to number if outside range (unlikely)
            $praktikumOptions[$val] = $val;
        }

        return view('admin.praktikum.create', compact('praktikumOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'praktikum_ke' => 'required|string|max:10',
            'nama_praktikum' => 'required|string|max:255',
        ]);

        Praktikum::create($validated);

        return redirect()->route('admin.praktikum.index')
            ->with('success', 'Praktikum berhasil ditambahkan');
    }

    public function show(Praktikum $praktikum)
    {
        return view('admin.praktikum.show', compact('praktikum'));
    }

    public function edit(Praktikum $praktikum)
    {
        $maxPraktikum = PeriodePendaftaran::max('praktikum_ke');
        $limit = $maxPraktikum ? max($maxPraktikum, 4) : 4;
        
        $romans = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
            11 => 'XI', 12 => 'XII', 13 => 'XIII', 14 => 'XIV', 15 => 'XV'
        ];
        
        $praktikumOptions = [];
        for ($i = 1; $i <= $limit; $i++) {
            $val = $romans[$i] ?? $i;
            $praktikumOptions[$val] = $val;
        }

        return view('admin.praktikum.edit', compact('praktikum', 'praktikumOptions'));
    }

    public function update(Request $request, Praktikum $praktikum)
    {
        $validated = $request->validate([
            'praktikum_ke' => 'required|string|max:10',
            'nama_praktikum' => 'required|string|max:255',
        ]);

        $praktikum->update($validated);

        return redirect()->route('admin.praktikum.index')
            ->with('success', 'Praktikum berhasil diperbarui');
    }

    public function destroy(Praktikum $praktikum)
    {
        $praktikum->delete();

        return redirect()->route('admin.praktikum.index')
            ->with('success', 'Praktikum berhasil dihapus');
    }
}
