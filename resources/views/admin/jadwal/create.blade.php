@extends('layouts.admin')

@section('title', 'Tambah Jadwal')

@section('content')
<div class="page-header">
    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali</span>
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Jadwal Baru</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.jadwal.store') }}" method="POST">
            @csrf
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Periode <span class="required">*</span></label>
                    <select name="periode_id" class="form-control" required>
                        <option value="">-- Pilih Periode --</option>
                        @foreach($periode as $p)
                            <option value="{{ $p->id }}" 
                                    data-praktikum-ke="{{ $p->praktikum_ke }}" 
                                    {{ old('periode_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->tahun_akademik }} - {{ $p->semester }} (Praktikum {{ $p->praktikum_ke_romawi }})
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
                            <option value="{{ $p->id }}" 
                                    data-praktikum-ke="{{ $p->praktikum_ke }}" 
                                    {{ old('praktikum_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_praktikum }} ({{ $p->praktikum_ke }})
                            </option>
                        @endforeach
                    </select>
                    @error('praktikum_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Mata Kuliah <span class="required">*</span></label>
                    <input type="text" name="mata_kuliah" class="form-control" value="{{ old('mata_kuliah') }}" placeholder="Masukkan Nama Mata Kuliah" required>
                    @error('mata_kuliah')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Kelas <span class="required">*</span></label>
                    <select name="kelas_id" class="form-control" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
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
                            <option value="{{ $i->id }}" {{ old('instruktur_id') == $i->id ? 'selected' : '' }}>
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
                            <option value="{{ $r->id }}" {{ old('ruangan_id') == $r->id ? 'selected' : '' }}>
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
                            <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                        @endforeach
                    </select>
                    @error('hari')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Jam Mulai <span class="required">*</span></label>
                    <input type="time" name="jam_mulai" class="form-control" value="{{ old('jam_mulai') }}" required>
                    @error('jam_mulai')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Jam Selesai <span class="required">*</span></label>
                    <input type="time" name="jam_selesai" class="form-control" value="{{ old('jam_selesai') }}" required>
                    @error('jam_selesai')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="reset" class="btn btn-secondary">
                    <i class="fas fa-undo"></i>
                    <span>Reset</span>
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    <span>Simpan Jadwal</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const periodeSelect = document.querySelector('select[name="periode_id"]');
        const praktikumSelect = document.querySelector('select[name="praktikum_id"]');
        
        function filterPraktikum() {
            const selectedPeriode = periodeSelect.options[periodeSelect.selectedIndex];
            // If no period selected, return
            if (!selectedPeriode || !selectedPeriode.value) return;

            const targetKe = selectedPeriode.getAttribute('data-praktikum-ke');
            
            // Reset selection first
            praktikumSelect.value = '';
            
            let matchFound = false;
            let matches = [];
            let allOptions = Array.from(praktikumSelect.options).filter(opt => opt.value !== '');

            // First pass: Check if any match exists
            allOptions.forEach(opt => {
                const optKe = opt.getAttribute('data-praktikum-ke');
                if (targetKe && targetKe !== '-' && optKe == targetKe) {
                    matches.push(opt);
                }
            });

            // If we have matches, show only them. Otherwise, show all.
            const showAll = matches.length === 0;

            allOptions.forEach(opt => {
                const optKe = opt.getAttribute('data-praktikum-ke');
                
                if (showAll) {
                    opt.style.display = '';
                } else {
                    if (optKe == targetKe) {
                        opt.style.display = '';
                    } else {
                        opt.style.display = 'none';
                    }
                }
            });

            // Auto-select first visible option if not showing all (strict match mode)
            if (!showAll && matches.length > 0) {
                 praktikumSelect.value = matches[0].value;
            } else {
                 praktikumSelect.value = ''; // Reset if showing all
            }
        }

        if(periodeSelect) {
            periodeSelect.addEventListener('change', filterPraktikum);
            // Run once on load if value exists (e.g. failed validation redirect)
            if(periodeSelect.value) filterPraktikum();
        }
    });
</script>
@endpush

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
