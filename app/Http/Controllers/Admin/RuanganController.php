<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::latest()->paginate(10);
        return view('admin.ruangan.index', compact('ruangan'));
    }

    public function create()
    {
        return view('admin.ruangan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_ruangan' => 'required|string|unique:ruangan,kode_ruangan',
            'nama_ruangan' => 'required|string|max:255',
            'kapasitas' => 'nullable|integer|min:1',
            'fasilitas' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Ruangan::create($validated);

        return redirect()->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil ditambahkan');
    }

    public function edit(Ruangan $ruangan)
    {
        return view('admin.ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $validated = $request->validate([
            'kode_ruangan' => 'required|string|unique:ruangan,kode_ruangan,' . $ruangan->id,
            'nama_ruangan' => 'required|string|max:255',
            'kapasitas' => 'nullable|integer|min:1',
            'fasilitas' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $ruangan->update($validated);

        return redirect()->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil diperbarui');
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();

        return redirect()->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil dihapus');
    }
}
