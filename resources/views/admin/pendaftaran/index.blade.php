@extends('layouts.admin')

@section('title', 'Pendaftaran Praktikum')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-file-alt"></i>
            Daftar Pendaftaran Praktikum
        </h3>
    </div>
    
    {{-- Filter Section --}}
    <div class="card-filter">
        <form action="{{ route('admin.pendaftaran.index') }}" method="GET" class="filter-form">
            <div class="filter-grid">
                {{-- Search Filter --}}
                <div class="filter-group search-group">
                    <label for="search"><i class="fas fa-search"></i> Cari Pesiserta</label>
                    <div class="search-input-wrapper">
                        <input type="text" name="search" id="search" class="filter-input" 
                               placeholder="Cari Nama atau NIM..." value="{{ request('search') }}">
                    </div>
                </div>

                {{-- Status Filter --}}
                <div class="filter-group">
                    <label for="status"><i class="fas fa-filter"></i> Status</label>
                    <select name="status" id="status" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                {{-- Periode Filter --}}
                <div class="filter-group">
                    <label for="periode_id"><i class="fas fa-calendar-alt"></i> Periode</label>
                    <select name="periode_id" id="periode_id" class="filter-select" onchange="this.form.submit()">
                        <option value="">Semua Periode</option>
                        @foreach($periode as $p)
                            <option value="{{ $p->id }}" {{ request('periode_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->tahun_akademik }} - {{ $p->semester }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                 <button type="submit" class="search-btn" style="height: 42px; align-self: flex-end; border-radius: 10px;">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
            
            @if(request('search') || request('status') || request('periode_id'))
            <div class="filter-reset">
                <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-times"></i> Reset Filter
                </a>
            </div>
            @endif
        </form>
    </div>

    <div class="card-body">
        <div class="table-container">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th width="15%">Tanggal Daftar</th>
                        <th width="20%">Peserta</th>
                        <th width="20%">Praktikum</th>
                        <th width="15%">Kelas</th>
                        <th width="10%">Status</th>
                        <th class="text-center" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftaran as $index => $p)
                    <tr>
                        <td class="text-center">{{ $pendaftaran->firstItem() + $index }}</td>
                        <td>
                            <div class="date-badge">
                                <div class="date-main">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $p->tanggal_daftar->format('d/m/Y') }}
                                </div>
                                <div class="date-sub">
                                    <i class="far fa-clock"></i>
                                    {{ $p->created_at->format('H:i') }} WITA
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="user-info text-start">
                                <div class="avatar-circle">{{ substr($p->peserta->nama ?? $p->user->nama ?? 'U', 0, 1) }}</div>
                                <div>
                                    <span class="user-name">{{ $p->peserta->nama ?? $p->user->nama ?? '-' }}</span>
                                    <span class="user-sub">{{ $p->peserta->nim ?? $p->user->nim ?? '-' }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                             @php
                                $romans = [1=>'I', 2=>'II', 3=>'III', 4=>'IV', 5=>'V', 6=>'VI', 7=>'VII', 8=>'VIII'];
                            @endphp
                            <span class="praktikum-name">
                                @if($p->praktikum)
                                    {{ $romans[$p->praktikum->praktikum_ke] ?? $p->praktikum->praktikum_ke }} - {{ $p->praktikum->nama_praktikum }}
                                @else
                                    Belum Ditentukan
                                @endif
                            </span>
                        </td>
                        <td>
                             <span class="class-badge">{{ $p->kelas->nama_kelas ?? '-' }}</span>
                        </td>
                        <td>
                            @switch($p->status)
                                @case('pending')
                                    <span class="status-badge pending">Pending</span>
                                    @break
                                @case('diterima')
                                    <span class="status-badge success">Diterima</span>
                                    @break
                                @case('ditolak')
                                    <span class="status-badge danger">Ditolak</span>
                                    @break
                            @endswitch
                        </td>
                        <td class="text-center">
                            @php
                                $modalData = [
                                    "nama" => $p->peserta->nama ?? $p->user->nama ?? "-",
                                    "nim" => $p->peserta->nim ?? $p->user->nim ?? "-",
                                    "praktikum" => $p->praktikum ? 
                                        (($romans[$p->praktikum->praktikum_ke] ?? $p->praktikum->praktikum_ke) . " - " . $p->praktikum->nama_praktikum) 
                                        : "Belum Ditentukan",
                                    "kelas" => $p->kelas->nama_kelas ?? "-",
                                    "periode" => ($p->periode->tahun_akademik ?? "-") . " - " . ($p->periode->semester ?? "-"),
                                    "tanggal" => $p->tanggal_daftar->format("d F Y") . " " . $p->created_at->format("H:i"),
                                    "foto" => $p->kartu_kontrol_path ? asset("storage/" . $p->kartu_kontrol_path) : null,
                                    "krs" => $p->krs_path ? asset("storage/" . $p->krs_path) : null,
                                    "berkas" => $p->berkas_path ? asset("storage/" . $p->berkas_path) : null,
                                    "id" => $p->id
                                ];
                            @endphp
                            <div class="action-cell justify-content-center">
                                <button type="button" class="btn-action view" title="Detail" 
                                    data-detail="{{ json_encode($modalData) }}"
                                    onclick="openDetailModal(this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                <form action="{{ route('admin.pendaftaran.destroy', $p->id) }}" method="POST" 
                                      onsubmit="return confirm('Yakin hapus pendaftaran ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <p>Tidak ada data pendaftaran ditemukan</p>
                            @if(request('search') || request('status') || request('periode_id'))
                                <small>Coba reset filter pencarian Anda</small>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($pendaftaran->hasPages())
        <div class="pagination-wrapper">
            {{ $pendaftaran->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Detail Modal --}}
<div id="detailModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-info-circle"></i> Detail Pendaftaran</h3>
            <button type="button" class="close-btn" onclick="closeDetailModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="detail-profile">
                <div class="detail-avatar" id="modalValidAvatar">M</div>
                <div class="detail-info">
                    <h4 id="modalNama">Mahasiswa</h4>
                    <span id="modalNim">NIM: -</span>
                </div>
            </div>
            
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="label">Praktikum</span>
                    <span class="value" id="modalPraktikum">-</span>
                </div>
                <div class="detail-item">
                    <span class="label">Kelas</span>
                    <span class="value" id="modalKelas">-</span>
                </div>
                <div class="detail-item">
                    <span class="label">Periode</span>
                    <span class="value" id="modalPeriode">-</span>
                </div>
                <div class="detail-item">
                    <span class="label">Waktu Daftar</span>
                    <span class="value" id="modalTanggal">-</span>
                </div>
            </div>

            <div class="detail-files">
                <h5>Berkas Upload</h5>
                <div class="file-list">
                    <div class="file-item">
                        <i class="fas fa-user-circle file-icon"></i>
                        <div class="file-meta">
                            <span>Pas Foto</span>
                        </div>
                        <a href="#" target="_blank" id="btnFoto" class="btn-view disabled">Lihat</a>
                    </div>
                    <div class="file-item">
                        <i class="fas fa-file-alt file-icon"></i>
                        <div class="file-meta">
                            <span>KRS</span>
                        </div>
                        <a href="#" target="_blank" id="btnKrs" class="btn-view disabled">Lihat</a>
                    </div>
                    <div class="file-item">
                        <i class="fas fa-file-invoice-dollar file-icon"></i>
                        <div class="file-meta">
                            <span>Bukti Bayar</span>
                        </div>
                        <a href="#" target="_blank" id="btnBerkas" class="btn-view disabled">Lihat</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <form id="statusForm" method="POST" style="display: flex; gap: 0.5rem; width: 100%; justify-content: flex-end;">
                @csrf
                @method('PATCH')
                <button type="button" class="btn-secondary" onclick="closeDetailModal()">Tutup</button>
                <button type="button" onclick="confirmStatus('ditolak')" class="btn-action delete" style="width: auto; padding: 0.5rem 1rem;">
                    <i class="fas fa-times" style="margin-right: 0.5rem;"></i> Tolak
                </button>
                <button type="button" onclick="confirmStatus('diterima')" class="btn-action view" style="width: auto; padding: 0.5rem 1rem;">
                    <i class="fas fa-check" style="margin-right: 0.5rem;"></i> Terima
                </button>
                <input type="hidden" name="status" id="statusInput">
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmStatus(status) {
        const title = status === 'diterima' ? 'Terima Pendaftaran?' : 'Tolak Pendaftaran?';
        const text = status === 'diterima' 
            ? 'Mahasiswa akan resmi terdaftar di praktikum ini.' 
            : 'Pendaftaran mahasiswa ini akan ditolak.';
        const icon = status === 'diterima' ? 'question' : 'warning';
        const confirmColor = status === 'diterima' ? '#10b981' : '#ef4444';

        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: confirmColor,
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('statusInput').value = status;
                document.getElementById('statusForm').submit();
            }
        });
    }

    function openDetailModal(btn) {
        const data = JSON.parse(btn.dataset.detail);

        document.getElementById('modalNama').textContent = data.nama;
        document.getElementById('modalNim').textContent = 'NIM: ' + data.nim;
        document.getElementById('modalValidAvatar').textContent = data.nama.charAt(0).toUpperCase();
        document.getElementById('modalPraktikum').textContent = data.praktikum;
        document.getElementById('modalKelas').textContent = data.kelas;
        document.getElementById('modalPeriode').textContent = data.periode;
        document.getElementById('modalTanggal').textContent = data.tanggal;

        // Files
        setupFileBtn('btnFoto', data.foto);
        setupFileBtn('btnKrs', data.krs);
        setupFileBtn('btnBerkas', data.berkas);

        // Update Form Action
        const form = document.getElementById('statusForm');
        form.action = `/admin/pendaftaran/${data.id}/status`;

        const modal = document.getElementById('detailModal');
        modal.style.display = 'flex';
        setTimeout(() => modal.classList.add('active'), 10);
    }

    function setupFileBtn(id, url) {
        const btn = document.getElementById(id);
        if (url) {
            btn.href = url;
            btn.classList.remove('disabled');
        } else {
            btn.href = '#';
            btn.classList.add('disabled');
        }
    }

    function closeDetailModal() {
        const modal = document.getElementById('detailModal');
        modal.classList.remove('active');
        setTimeout(() => modal.style.display = 'none', 300);
    }

    // Close on click outside
    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) closeDetailModal();
    });
</script>
@endpush

@push('styles')
<style>
/* =====================================================
   PENDAFTARAN INDEX STYLES - TEAL THEME
   ===================================================== */

/* Card Header */
.card-header {
    background: white;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-title i {
    color: #0f766e;
    background: #f0fdfa;
    padding: 10px;
    border-radius: 12px;
}

/* Filter Section */
.card-filter {
    background: #f8fafc;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.filter-form {
    flex: 1;
    display: flex;
    align-items: flex-end;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-grid {
    display: flex;
    gap: 1.25rem;
    align-items: center;
    flex: 1;
    flex-wrap: wrap;
}

.filter-group {
    flex: 1;
    min-width: 200px;
}

.filter-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.filter-group label i {
    color: #0f766e;
    margin-right: 0.25rem;
}

.filter-input, .filter-select {
    width: 100%;
    padding: 0.625rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.875rem;
    color: #334155;
    background: white;
    transition: all 0.2s;
    height: 42px;
}

.filter-input:focus, .filter-select:focus {
    border-color: #14b8a6;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
    outline: none;
}

.search-input-wrapper {
    display: flex;
}

.search-btn {
    padding: 0 1.25rem;
    background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
    color: white;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.search-btn:hover {
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
}

.filter-reset {
    margin-left: auto;
}

/* Premium Table */
.table-container {
    overflow-x: auto;
}

.premium-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.premium-table th {
    background: #f8fafc;
    padding: 1rem 1.5rem;
    font-size: 0.75rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 2px solid #e2e8f0;
}

.premium-table td {
    padding: 1.25rem 1.5rem;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
}

.premium-table tbody tr {
    transition: all 0.2s;
}

.premium-table tbody tr:hover {
    background: #fcfcfc;
}

/* Specific Badges */
.date-badge {
    color: #64748b;
    font-size: 0.875rem;
    font-weight: 500;
}

.date-badge i {
    margin-right: 0.25rem;
    color: #94a3b8;
}

.user-info {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    justify-content: flex-start !important;
    gap: 1rem; /* Sedikit diperlebar agar rapi */
}

.avatar-circle {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: #475569;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.user-name {
    display: block;
    font-weight: 600;
    color: #334155;
    font-size: 0.9375rem;
}

.user-sub {
    display: block;
    font-size: 0.75rem;
    color: #94a3b8;
}

.praktikum-name {
    font-weight: 600;
    color: #475569;
}

.class-badge {
    background: #e0f2fe;
    color: #0284c7;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.status-badge {
    display: inline-flex;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-badge.pending { background: #fff7ed; color: #c2410c; }
.status-badge.success { background: #dcfce7; color: #16a34a; }
.status-badge.danger { background: #fee2e2; color: #b91c1c; }

/* Action Buttons */
.action-cell {
    display: flex;
    gap: 0.5rem;
}

.btn-action {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.875rem;
}

.btn-action.view { background: #dcfce7; color: #16a34a; }
.btn-action.view:hover { background: #bbf7d0; transform: translateY(-2px); }

.btn-action.delete { background: #fee2e2; color: #b91c1c; }
.btn-action.delete:hover { background: #fecaca; transform: translateY(-2px); }

.btn-secondary {
    background: white;
    color: #64748b;
    border: 1px solid #e2e8f0;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.8125rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-secondary:hover {
    background: #f1f5f9;
    color: #334155;
}

.empty-state {
    padding: 4rem 2rem !important;
    text-align: center;
}

.empty-icon {
    font-size: 3rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
}

.justify-content-center { justify-content: center; }

.pagination-wrapper {
    padding: 1.5rem 2rem;
    border-top: 1px solid #f1f5f9;
}

/* Responsive */
@media (max-width: 768px) {
    .card-filter {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    
    .filter-form {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-group {
        max-width: 100%;
        min-width: 100%;
    }
    
    .filter-reset {
        margin-left: 0;
        text-align: center;
    }
    
    .premium-table td, .premium-table th {
        padding: 1rem;
    }
}
.date-badge { text-align: left; }
.date-main { font-weight: 600; color: #334155; display: flex; align-items: center; gap: 0.35rem; }
.date-sub { font-size: 0.75rem; color: #94a3b8; display: flex; align-items: center; gap: 0.35rem; margin-top: 0.2rem; }
.user-info.text-start { justify-content: flex-start; text-align: left; }

/* Modal Styles */
.modal-overlay {
    position: fixed; 
    top: 0; 
    left: 0; 
    right: 0; 
    bottom: 0;
    background: rgba(15, 23, 42, 0.6); 
    backdrop-filter: blur(4px);
    z-index: 10000; /* Extremely high z-index to cover navbar */
    display: none; 
    align-items: flex-start; /* Align to top */
    justify-content: center;
    opacity: 0; 
    transition: opacity 0.3s ease;
    padding: 0.5rem 1rem 1rem 1rem; /* Minimal top padding */
}
.modal-overlay.active { display: flex; opacity: 1; }
.modal-content {
    background: white; 
    width: 100%; 
    max-width: 500px; 
    border-radius: 16px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    transform: translateY(20px); 
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    overflow: hidden; 
    max-height: calc(100vh - 2rem); 
    display: flex; 
    flex-direction: column;
    margin: 0 auto; 
}
.modal-overlay.active .modal-content { transform: translateY(0); }
.modal-header {
    background: #f8fafc; padding: 1rem 1.25rem; /* Compact header */
    border-bottom: 1px solid #e2e8f0;
    display: flex; justify-content: space-between; align-items: center;
    flex-shrink: 0; 
}
.modal-header h3 { font-size: 1rem; font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem; }
.modal-header h3 i { color: #0f766e; }
.close-btn { background: none; border: none; font-size: 1.25rem; color: #94a3b8; cursor: pointer; transition: color 0.2s; }
.close-btn:hover { color: #ef4444; }
.modal-body { 
    padding: 1rem 1.25rem; /* Compact body */
    overflow-y: auto; 
}
.detail-profile { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f1f5f9; }
.detail-avatar {
    width: 48px; height: 48px; /* Smaller avatar */
    background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
    border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; font-weight: 700; box-shadow: 0 4px 6px rgba(15, 118, 110, 0.2);
}
.detail-info h4 { margin: 0 0 0.15rem 0; color: #1e293b; font-size: 1rem; font-weight: 700; }
.detail-info span { color: #64748b; font-size: 0.8125rem; }
.detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem; }
.detail-item { background: #f8fafc; padding: 0.625rem; border-radius: 8px; border: 1px solid #f1f5f9; }
.detail-item .label { display: block; font-size: 0.6875rem; color: #64748b; margin-bottom: 0.15rem; text-transform: uppercase; font-weight: 600; }
.detail-item .value { font-weight: 600; color: #334155; font-size: 0.875rem; }
.detail-files h5 { font-size: 0.8125rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem; }
.file-list { display: flex; flex-direction: column; gap: 0.5rem; }
.file-item { display: flex; align-items: center; padding: 0.625rem; border: 1px solid #e2e8f0; border-radius: 8px; gap: 0.75rem; }
.file-icon { color: #0d9488; font-size: 1rem; width: 28px; height: 28px; background: #f0fdfa; display: flex; align-items: center; justify-content: center; border-radius: 6px; }
.file-meta { flex: 1; font-weight: 600; color: #334155; font-size: 0.8125rem; }
.btn-view { background: #0f766e; color: white; padding: 0.35rem 0.75rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600; text-decoration: none; transition: all 0.2s; }
.btn-view:hover { background: #0d9488; }
.btn-view.disabled { background: #cbd5e1; cursor: not-allowed; pointer-events: none; }
.modal-footer { padding: 1rem 1.25rem; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; flex-shrink: 0; }
</style>
@endpush
