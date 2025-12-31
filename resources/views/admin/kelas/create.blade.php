@extends('layouts.admin')

@section('title', 'Tambah Kelas')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <h3 class="card-title">Tambah Kelas Baru</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.kelas.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Kode Kelas <span style="color: #ef4444;">*</span></label>
                <input type="text" name="kode_kelas" class="form-control" 
                       value="{{ old('kode_kelas') }}" placeholder="Contoh: A, B, C" required>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Kelas <span style="color: #ef4444;">*</span></label>
                <input type="text" name="nama_kelas" class="form-control" 
                       value="{{ old('nama_kelas') }}" placeholder="Contoh: Kelas A Pagi" required>
            </div>

            <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
