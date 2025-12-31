@extends('layouts.admin')

@section('title', 'Edit Praktikum')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <h3 class="card-title">Edit Data Praktikum</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.praktikum.update', $praktikum) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Praktikum Ke <span style="color: #ef4444;">*</span></label>
                <select name="praktikum_ke" class="form-control" required>
                    <option value="">Pilih...</option>
                    @foreach($praktikumOptions as $key => $label)
                        <option value="{{ $key }}" {{ old('praktikum_ke', $praktikum->praktikum_ke) == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Praktikum <span style="color: #ef4444;">*</span></label>
                <input type="text" name="nama_praktikum" class="form-control" 
                       value="{{ old('nama_praktikum', $praktikum->nama_praktikum) }}" placeholder="Contoh: Praktikum Pemrograman Web" required>
            </div>

            <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.praktikum.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
