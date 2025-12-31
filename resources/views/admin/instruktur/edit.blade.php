@extends('layouts.admin')

@section('title', 'Edit Instruktur')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <h3 class="card-title">Edit Data Instruktur</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.instruktur.update', $instruktur) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Username <span style="color: #ef4444;">*</span></label>
                <input type="text" name="username" class="form-control" 
                       value="{{ old('username', $instruktur->username) }}" placeholder="Username untuk login" required>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Lengkap <span style="color: #ef4444;">*</span></label>
                <input type="text" name="nama" class="form-control" 
                       value="{{ old('nama', $instruktur->nama) }}" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email <span style="color: #ef4444;">*</span></label>
                <input type="email" name="email" class="form-control" 
                       value="{{ old('email', $instruktur->email) }}" placeholder="email@example.com" required>
            </div>

            <div class="form-group">
                <label class="form-label">No. HP/WhatsApp</label>
                <input type="text" name="no_hp_wa" class="form-control" 
                       value="{{ old('no_hp_wa', $instruktur->no_hp_wa) }}" placeholder="Contoh: 081234567890">
            </div>

            <div class="form-group">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control" 
                       placeholder="Kosongkan jika tidak ingin mengubah">
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control" 
                       placeholder="Ulangi password baru">
            </div>

            <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.instruktur.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
