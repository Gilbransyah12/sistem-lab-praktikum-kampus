@props(['role' => 'admin'])

<aside id="sidebar" class="sidebar">
    <!-- Logo Header -->
    <div class="sidebar-header">
        <a href="{{ route($role . '.dashboard') }}" class="sidebar-logo">
            <div class="logo-icon">
                <i class="fas fa-flask"></i>
            </div>
            <div class="logo-text">
                <span class="logo-title">Lab Praktikum</span>
                <span class="logo-subtitle">UMPAR</span>
            </div>
        </a>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="sidebar-nav">
        @if($role === 'admin')
            <div class="nav-section">
                <span class="nav-section-title">Menu Utama</span>
            </div>
            <a href="{{ route('admin.dashboard') }}" 
               class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-home"></i></span>
                <span class="nav-text">Dashboard</span>
            </a>
            
            <div class="nav-section">
                <span class="nav-section-title">Master Data</span>
            </div>
            <a href="{{ route('admin.peserta.index') }}" 
               class="nav-item {{ request()->routeIs('admin.peserta.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-users"></i></span>
                <span class="nav-text">Peserta</span>
            </a>
            <a href="{{ route('admin.instruktur.index') }}" 
               class="nav-item {{ request()->routeIs('admin.instruktur.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-chalkboard-teacher"></i></span>
                <span class="nav-text">Instruktur</span>
            </a>
            <a href="{{ route('admin.praktikum.index') }}" 
               class="nav-item {{ request()->routeIs('admin.praktikum.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-book"></i></span>
                <span class="nav-text">Praktikum</span>
            </a>
            <a href="{{ route('admin.kelas.index') }}" 
               class="nav-item {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-layer-group"></i></span>
                <span class="nav-text">Kelas</span>
            </a>
            <a href="{{ route('admin.ruangan.index') }}" 
               class="nav-item {{ request()->routeIs('admin.ruangan.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-door-open"></i></span>
                <span class="nav-text">Ruangan</span>
            </a>
            
            <div class="nav-section">
                <span class="nav-section-title">Akademik</span>
            </div>
            <a href="{{ route('admin.periode.index') }}" 
               class="nav-item {{ request()->routeIs('admin.periode.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-calendar-alt"></i></span>
                <span class="nav-text">Periode</span>
            </a>
            <a href="{{ route('admin.jadwal.index') }}" 
               class="nav-item {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-clock"></i></span>
                <span class="nav-text">Jadwal</span>
            </a>
            <a href="{{ route('admin.pendaftaran.index') }}" 
               class="nav-item {{ request()->routeIs('admin.pendaftaran.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-file-alt"></i></span>
                <span class="nav-text" style="flex: 1;">Pendaftaran</span>
                @if(isset($pendingCount) && $pendingCount > 0)
                    <span class="nav-badge">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.absensi.index') }}" 
               class="nav-item {{ request()->routeIs('admin.absensi.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-clipboard-check"></i></span>
                <span class="nav-text">Absensi</span>
            </a>
            
        @elseif($role === 'instruktur')
            <div class="nav-section">
                <span class="nav-section-title">Menu Utama</span>
            </div>
            <a href="{{ route('instruktur.dashboard') }}" 
               class="nav-item {{ request()->routeIs('instruktur.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-home"></i></span>
                <span class="nav-text">Dashboard</span>
            </a>
            
            <div class="nav-section">
                <span class="nav-section-title">Praktikum</span>
            </div>
            <a href="{{ route('instruktur.absensi.index') }}" 
               class="nav-item {{ request()->routeIs('instruktur.absensi.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-clipboard-check"></i></span>
                <span class="nav-text">Absensi</span>
            </a>
            <a href="{{ route('instruktur.nilai.index') }}" 
               class="nav-item {{ request()->routeIs('instruktur.nilai.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-star"></i></span>
                <span class="nav-text">Nilai</span>
            </a>
            <a href="{{ route('instruktur.modul.index') }}" 
               class="nav-item {{ request()->routeIs('instruktur.modul.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-book-open"></i></span>
                <span class="nav-text">Tambah Modul</span>
            </a>
            
        @elseif($role === 'peserta')
            <div class="nav-section">
                <span class="nav-section-title">Menu Utama</span>
            </div>
            <a href="{{ route('peserta.dashboard') }}" 
               class="nav-item {{ request()->routeIs('peserta.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-home"></i></span>
                <span class="nav-text">Dashboard</span>
            </a>
            
            <div class="nav-section">
                <span class="nav-section-title">Praktikum</span>
            </div>
            <a href="{{ route('peserta.pendaftaran.index') }}" 
               class="nav-item {{ request()->routeIs('peserta.pendaftaran.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-file-alt"></i></span>
                <span class="nav-text">Pendaftaran</span>
            </a>
            <a href="{{ route('peserta.jadwal.index') }}" 
               class="nav-item {{ request()->routeIs('peserta.jadwal.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-calendar-alt"></i></span>
                <span class="nav-text">Jadwal</span>
            </a>
            
        @elseif($role === 'mahasiswa')
            <div class="nav-section">
                <span class="nav-section-title">Menu Utama</span>
            </div>
            <a href="{{ route('mahasiswa.dashboard') }}" 
               class="nav-item {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-home"></i></span>
                <span class="nav-text">Dashboard</span>
            </a>
            
            <div class="nav-section">
                <span class="nav-section-title">Praktikum</span>
            </div>
            <a href="{{ route('mahasiswa.pendaftaran.index') }}" 
               class="nav-item {{ request()->routeIs('mahasiswa.pendaftaran.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-file-alt"></i></span>
                <span class="nav-text">Pendaftaran</span>
            </a>
            <a href="{{ route('mahasiswa.jadwal.index') }}" 
               class="nav-item {{ request()->routeIs('mahasiswa.jadwal.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-calendar-alt"></i></span>
                <span class="nav-text">Jadwal Saya</span>
            </a>
            <a href="{{ route('mahasiswa.sertifikat.index') }}" 
               class="nav-item {{ request()->routeIs('mahasiswa.sertifikat.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-certificate"></i></span>
                <span class="nav-text">Sertifikat</span>
            </a>
        @endif
    </nav>
    
    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        {{-- Logout Button --}}
        <form action="{{ route('logout') }}" method="POST" class="sidebar-logout-form">
            @csrf
            <button type="submit" class="sidebar-logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
        <div class="version-badge">
            <i class="fas fa-code-branch"></i>
            <span>v1.0.0</span>
        </div>
    </div>
</aside>

<style>
/* =====================================================
   PREMIUM SIDEBAR STYLES
   ===================================================== */
.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: var(--sidebar-width);
    height: 100vh;
    background: var(--sidebar-bg);
    z-index: 1000;
    display: flex;
    flex-direction: column;
    transition: transform var(--transition-slow);
    box-shadow: 4px 0 24px rgba(0, 0, 0, 0.15);
}

/* Sidebar Header */
.sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--sidebar-border);
}

.sidebar-logo {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    text-decoration: none;
    color: white;
}

.logo-icon {
    width: 48px;
    height: 48px;
    background: var(--gradient-primary);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.375rem;
    color: white;
    box-shadow: var(--shadow-glow);
    transition: all var(--transition-base);
}

.sidebar-logo:hover .logo-icon {
    transform: scale(1.05);
    box-shadow: var(--shadow-glow-lg);
}

.logo-text {
    display: flex;
    flex-direction: column;
}

.logo-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: white;
    line-height: 1.2;
}

.logo-subtitle {
    font-size: 0.75rem;
    color: var(--cyan-400);
    font-weight: 500;
    letter-spacing: 0.05em;
}

/* Navigation */
.sidebar-nav {
    flex: 1;
    padding: 1rem 0;
    overflow-y: auto;
}

.sidebar-nav::-webkit-scrollbar {
    width: 4px;
}

.sidebar-nav::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 2px;
}

.nav-section {
    padding: 1rem 1.5rem 0.5rem;
}

.nav-section-title {
    font-size: 0.6875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--dark-500);
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    padding: 0.75rem 1.5rem;
    color: var(--dark-400);
    text-decoration: none;
    transition: all var(--transition-base);
    position: relative;
    margin: 0.125rem 0;
}

.nav-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 0;
    background: var(--gradient-primary);
    border-radius: 0 4px 4px 0;
    transition: height var(--transition-base);
}

.nav-item:hover {
    color: white;
    background: rgba(255, 255, 255, 0.05);
}

.nav-item:hover::before {
    height: 60%;
}

.nav-item.active {
    color: white;
    background: linear-gradient(90deg, rgba(20, 184, 166, 0.15) 0%, transparent 100%);
}

.nav-item.active::before {
    height: 100%;
    box-shadow: 0 0 12px rgba(20, 184, 166, 0.5);
}

.nav-icon {
    width: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    transition: transform var(--transition-base);
}

.nav-item:hover .nav-icon {
    transform: scale(1.1);
}

.nav-item.active .nav-icon {
    color: var(--primary-400);
}

.nav-text {
    font-size: 0.9375rem;
    font-weight: 500;
}

/* Sidebar Footer */
.sidebar-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--sidebar-border);
}

.version-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem 0.75rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 9999px;
    font-size: 0.75rem;
    color: var(--dark-500);
}

/* Sidebar Logout Button */
.sidebar-logout-form {
    width: 100%;
    margin-bottom: 0.75rem;
}

.sidebar-logout-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
    border: none;
    border-radius: 10px;
    color: white;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.sidebar-logout-btn:hover {
    background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
}

/* Mobile Responsive */
@media (max-width: 1024px) {
    .sidebar {
        transform: translateX(-100%);
    }
    
    .sidebar.active {
        transform: translateX(0);
    }
}

.nav-badge {
    background: #ef4444;
    color: white;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0.15rem 0.5rem;
    border-radius: 9999px;
    min-width: 20px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(239, 68, 68, 0.4);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}
</style>
