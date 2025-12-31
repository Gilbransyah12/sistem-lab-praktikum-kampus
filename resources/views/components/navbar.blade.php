@props(['title' => 'Dashboard', 'role' => 'admin'])

@php
    $user = Auth::user();
    $userName = $user->nama ?? 'User';
    $userInitial = strtoupper(substr($userName, 0, 1));
    
    $roleLabels = [
        'admin' => 'Administrator',
        'instruktur' => 'Instruktur',
        'peserta' => 'Peserta',
    ];
    $roleLabel = $roleLabels[$role] ?? ucfirst($role);
@endphp

<header class="navbar">
    <div class="navbar-left">
        <div class="page-title">
            <h1>{{ $title }}</h1>
            <nav class="breadcrumb">
                <a href="{{ route($role . '.dashboard') }}">
                    <i class="fas fa-home"></i>
                </a>
                <span class="separator"><i class="fas fa-chevron-right"></i></span>
                <span class="current">{{ $title }}</span>
            </nav>
        </div>
    </div>
    
    <div class="navbar-right">
        <!-- Desktop Only Items -->
        <div class="desktop-only">
            <!-- Notification Bell (Placeholder) -->
            <button class="navbar-icon-btn" title="Notifikasi">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </button>
            
            <!-- User Profile -->
            <div class="user-profile">
                <div class="user-avatar">
                    {{ $userInitial }}
                </div>
                <div class="user-info">
                    <span class="user-name">{{ $userName }}</span>
                    <span class="user-role">{{ $roleLabel }}</span>
                </div>
            </div>
            
            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
        
        <!-- Mobile Menu Toggle (Right Side) -->
        <button id="menuToggle" class="menu-toggle" aria-label="Toggle sidebar">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</header>

<style>
/* =====================================================
   PREMIUM NAVBAR STYLES
   ===================================================== */
.navbar {
    height: var(--navbar-height);
    background: var(--navbar-bg);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 1.5rem;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

/* Navbar Left */
.navbar-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.page-title h1 {
    font-size: 1.375rem;
    font-weight: 700;
    color: var(--dark-800);
    margin: 0;
    line-height: 1.2;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.25rem;
}

.breadcrumb a {
    color: var(--primary-600);
    text-decoration: none;
    font-size: 0.8125rem;
    transition: color var(--transition-fast);
}

.breadcrumb a:hover {
    color: var(--primary-700);
}

.breadcrumb .separator {
    color: var(--dark-300);
    font-size: 0.625rem;
}

.breadcrumb .current {
    color: var(--dark-500);
    font-size: 0.8125rem;
}

/* Navbar Right */
.navbar-right {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.desktop-only {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

/* Menu Toggle - Hidden on Desktop, Shown on Mobile (Right Side) */
.menu-toggle {
    display: none;
    width: 40px;
    height: 40px;
    border: none;
    background: transparent;
    color: var(--dark-600);
    font-size: 1.25rem;
    cursor: pointer;
    border-radius: 0.5rem;
    transition: all var(--transition-base);
}

.menu-toggle:hover {
    background: var(--dark-100);
    color: var(--primary-600);
}

.navbar-icon-btn {
    position: relative;
    width: 42px;
    height: 42px;
    border: none;
    background: transparent;
    color: var(--dark-500);
    font-size: 1.125rem;
    cursor: pointer;
    border-radius: 0.625rem;
    transition: all var(--transition-base);
}

.navbar-icon-btn:hover {
    background: var(--primary-50);
    color: var(--primary-600);
}

.notification-badge {
    position: absolute;
    top: 6px;
    right: 6px;
    min-width: 18px;
    height: 18px;
    background: var(--gradient-primary);
    color: white;
    font-size: 0.6875rem;
    font-weight: 600;
    border-radius: 9999px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 4px;
    box-shadow: 0 2px 4px rgba(20, 184, 166, 0.3);
}

/* User Profile */
.user-profile {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 1rem;
    background: white;
    border: 1px solid var(--dark-100);
    border-radius: 9999px;
    transition: all var(--transition-base);
}

.user-profile:hover {
    border-color: var(--primary-200);
    box-shadow: var(--shadow-sm);
}

.user-avatar {
    width: 36px;
    height: 36px;
    background: var(--gradient-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9375rem;
    font-weight: 600;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.15);
}

.user-info {
    display: flex;
    flex-direction: column;
    line-height: 1.3;
}

.user-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--dark-800);
}

.user-role {
    font-size: 0.75rem;
    color: var(--dark-500);
}

/* Logout Button */
.logout-form {
    display: inline-flex;
}

.logout-btn {
    width: 42px;
    height: 42px;
    border: 1px solid var(--dark-200);
    background: white;
    color: var(--dark-500);
    font-size: 1rem;
    cursor: pointer;
    border-radius: 0.625rem;
    transition: all var(--transition-base);
    display: flex;
    align-items: center;
    justify-content: center;
}

.logout-btn:hover {
    background: #fef2f2;
    border-color: #fecaca;
    color: #dc2626;
}

/* Responsive - Mobile */
@media (max-width: 1024px) {
    /* Show hamburger menu on right */
    .menu-toggle {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Hide all desktop items (notification, profile, logout) on mobile */
    .desktop-only {
        display: none;
    }
    
    .navbar {
        padding: 0 1rem;
    }
    
    .breadcrumb {
        display: none;
    }
    
    .page-title h1 {
        font-size: 1.125rem;
    }
}
</style>
