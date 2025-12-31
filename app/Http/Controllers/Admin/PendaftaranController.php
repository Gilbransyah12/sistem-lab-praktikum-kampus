<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\PendaftaranPraktikum;
use App\Models\PeriodePendaftaran;
use App\Models\Peserta;
use App\Models\Praktikum;
use App\Models\User;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $query = PendaftaranPraktikum::with(['user', 'peserta', 'kelas', 'praktikum', 'periode']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        } else {
            // Default: Hide 'diterima' (processed) items
            $query->where('status', '!=', 'diterima');
        }

        // Filter by periode
        if ($request->has('periode_id') && $request->periode_id != '') {
            $query->where('periode_id', $request->periode_id);
        }

        // Search by Nama/NIM
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $pendaftaran = $query->latest()->paginate(10);
        $periode = PeriodePendaftaran::all();

        return view('admin.pendaftaran.index', compact('pendaftaran', 'periode'));
    }

    public function show(PendaftaranPraktikum $pendaftaran)
    {
        $pendaftaran->load(['user', 'peserta', 'kelas', 'praktikum', 'periode']);
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    public function updateStatus(Request $request, PendaftaranPraktikum $pendaftaran)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,diterima,ditolak',
        ]);

        $oldStatus = $pendaftaran->status;
        $newStatus = $validated['status'];

        $pendaftaran->update($validated);

        // Jika status berubah menjadi 'diterima', buat record peserta
        if ($newStatus === 'diterima' && $oldStatus !== 'diterima') {
            $user = $pendaftaran->user;
            
            if ($user && !$user->peserta) {
                // Buat record peserta baru
                $peserta = Peserta::create([
                    'user_id' => $user->id,
                    'nim' => $user->nim,
                    'nama' => $user->nama,
                    'no_hp_wa' => $user->no_hp_wa,
                    'kelas_id' => $pendaftaran->kelas_id,
                ]);

                // Link peserta ke pendaftaran
                $pendaftaran->update(['peserta_id' => $peserta->id]);
            } elseif ($user && $user->peserta) {
                // User sudah punya peserta, link ke pendaftaran
                $pendaftaran->update(['peserta_id' => $user->peserta->id]);
            }
        }

        return redirect()->back()
            ->with('success', 'Status pendaftaran berhasil diperbarui');
    }

    public function destroy(PendaftaranPraktikum $pendaftaran)
    {
        $pendaftaran->delete();

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil dihapus');
    }
}

