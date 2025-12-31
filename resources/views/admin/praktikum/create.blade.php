@extends('layouts.admin')

@section('title', 'Tambah Praktikum')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <h3 class="card-title">Tambah Praktikum Baru</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.praktikum.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Praktikum Ke <span style="color: #ef4444;">*</span></label>
                <select name="praktikum_ke" class="form-control" required>
                    <option value="">Pilih...</option>
                    @foreach($praktikumOptions as $value => $label)
                        <option value="{{ $value }}" {{ old('praktikum_ke') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Praktikum <span style="color: #ef4444;">*</span></label>
                <input type="text" name="nama_praktikum" class="form-control" 
                       value="{{ old('nama_praktikum') }}" placeholder="Contoh: Praktikum ..?" required>
            </div>

            <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.praktikum.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
