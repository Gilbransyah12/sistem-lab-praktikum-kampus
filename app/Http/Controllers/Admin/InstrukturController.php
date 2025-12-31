<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InstrukturController extends Controller
{
    public function index()
    {
        $instruktur = User::where('role', 'instruktur')->latest()->paginate(10);
        return view('admin.instruktur.index', compact('instruktur'));
    }

    public function create()
    {
        return view('admin.instruktur.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:users,username',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp_wa' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'instruktur';

        User::create($validated);

        return redirect()->route('admin.instruktur.index')
            ->with('success', 'Instruktur berhasil ditambahkan');
    }

    public function show(User $instruktur)
    {
        return view('admin.instruktur.show', compact('instruktur'));
    }

    public function edit(User $instruktur)
    {
        return view('admin.instruktur.edit', compact('instruktur'));
    }

    public function update(Request $request, User $instruktur)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:users,username,' . $instruktur->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $instruktur->id,
            'no_hp_wa' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $instruktur->update($validated);

        return redirect()->route('admin.instruktur.index')
            ->with('success', 'Instruktur berhasil diperbarui');
    }

    public function destroy(User $instruktur)
    {
        $instruktur->delete();

        return redirect()->route('admin.instruktur.index')
            ->with('success', 'Instruktur berhasil dihapus');
    }
}
