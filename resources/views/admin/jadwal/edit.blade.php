@extends('layouts.admin')

@section('title', 'Edit Jadwal')

@section('content')
<div class="page-header">
    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali</span>
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Jadwal</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Periode <span class="required">*</span></label>
                    <select name="periode_id" class="form-control" required>
                        <option value="">-- Pilih Periode --</option>
                        @foreach($periode as $p)
                            <option value="{{ $p->id }}" {{ old('periode_id', $jadwal->periode_id) == $p->id ? 'selected' : '' }}>
                                {{ $p->tahun_akademik }} - {{ $p->semester }}
                            </option>
                        @endforeach
                    </select>
                    @error('periode_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Praktikum <span class="required">*</span></label>
                    <select name="praktikum_id" class="form-control" required>
                        <option value="">-- Pilih Praktikum --</option>
                        @foreach($praktikum as $p)
                            <option value="{{ $p->id }}" {{ old('praktikum_id', $jadwal->praktikum_id) == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_praktikum }}
                            </option>
                        @endforeach
                    </select>
                    @error('praktikum_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Mata Kuliah <span class="required">*</span></label>
                    <input type="text" name="mata_kuliah" class="form-control" value="{{ old('mata_kuliah', $jadwal->mata_kuliah) }}" placeholder="Masukkan Nama Mata Kuliah" required>
                    @error('mata_kuliah')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Kelas <span class="required">*</span></label>
                    <select name="kelas_id" class="form-control" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id', $jadwal->kelas_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Instruktur <span class="required">*</span></label>
                    <select name="instruktur_id" class="form-control" required>
                        <option value="">-- Pilih Instruktur --</option>
                        @foreach($instruktur as $i)
                            <option value="{{ $i->id }}" {{ old('instruktur_id', $jadwal->instruktur_id) == $i->id ? 'selected' : '' }}>
                                {{ $i->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('instruktur_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Ruangan <span class="required">*</span></label>
                    <select name="ruangan_id" class="form-control" required>
                        <option value="">-- Pilih Ruangan --</option>
                        @foreach($ruangan as $r)
                            <option value="{{ $r->id }}" {{ old('ruangan_id', $jadwal->ruangan_id) == $r->id ? 'selected' : '' }}>
                                {{ $r->nama_ruangan }} ({{ $r->kode_ruangan }})
                            </option>
                        @endforeach
                    </select>
                    @error('ruangan_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Hari <span class="required">*</span></label>
                    <select name="hari" class="form-control" required>
                        <option value="">-- Pilih Hari --</option>
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                            <option value="{{ $hari }}" {{ old('hari', $jadwal->hari) == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                        @endforeach
                    </select>
                    @error('hari')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Jam Mulai <span class="required">*</span></label>
                    <input type="time" name="jam_mulai" class="form-control" value="{{ old('jam_mulai', substr($jadwal->jam_mulai, 0, 5)) }}" required>
                    @error('jam_mulai')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Jam Selesai <span class="required">*</span></label>
                    <input type="time" name="jam_selesai" class="form-control" value="{{ old('jam_selesai', substr($jadwal->jam_selesai, 0, 5)) }}" required>
                    @error('jam_selesai')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    <span>Batal</span>
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    <span>Update Jadwal</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.page-header {
    margin-bottom: 1.5rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.25rem;
}

.required {
    color: #dc2626;
}

.form-error {
    display: block;
    margin-top: 0.375rem;
    font-size: 0.8125rem;
    color: #dc2626;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--dark-100);
}
</style>
@endpush
@endsection
