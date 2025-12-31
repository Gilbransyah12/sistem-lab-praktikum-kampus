@extends('layouts.admin')

@section('title', 'Tambah Ruangan')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <h3 class="card-title">Tambah Ruangan Baru</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.ruangan.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Kode Ruangan <span style="color: #ef4444;">*</span></label>
                <input type="text" name="kode_ruangan" class="form-control" 
                       value="{{ old('kode_ruangan') }}" placeholder="Contoh: LAB-01" required>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Ruangan <span style="color: #ef4444;">*</span></label>
                <input type="text" name="nama_ruangan" class="form-control" 
                       value="{{ old('nama_ruangan') }}" placeholder="Contoh: Laboratorium Komputer 1" required>
            </div>

            <div class="form-group">
                <label class="form-label">Kapasitas</label>
                <input type="number" name="kapasitas" class="form-control" 
                       value="{{ old('kapasitas') }}" placeholder="Jumlah orang" min="1">
            </div>

            <div class="form-group">
                <label class="form-label">Fasilitas</label>
                <textarea name="fasilitas" class="form-control" rows="3" 
                          placeholder="Deskripsi fasilitas ruangan">{{ old('fasilitas') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Status <span style="color: #ef4444;">*</span></label>
                <select name="status" class="form-control" required>
                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.ruangan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
