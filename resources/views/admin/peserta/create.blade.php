@extends('layouts.admin')

@section('title', 'Tambah Peserta')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <h3 class="card-title">Tambah Peserta Baru</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.peserta.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">NIM <span style="color: #ef4444;">*</span></label>
                <input type="text" name="nim" class="form-control" 
                       value="{{ old('nim') }}" placeholder="Masukkan NIM" required>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Lengkap <span style="color: #ef4444;">*</span></label>
                <input type="text" name="nama" class="form-control" 
                       value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="form-group">
                <label class="form-label">No. HP/WhatsApp</label>
                <input type="text" name="no_hp_wa" class="form-control" 
                       value="{{ old('no_hp_wa') }}" placeholder="Contoh: 081234567890">
            </div>

            <div class="form-group">
                <label class="form-label">Kelas</label>
                <select name="kelas_id" class="form-control">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.peserta.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
