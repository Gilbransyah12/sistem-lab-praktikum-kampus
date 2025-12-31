@extends('layouts.app')

@section('body')
    <!-- Overlay for mobile -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar Component -->
    <x-sidebar role="peserta" />

    <!-- Main Content -->
    <main class="main-content">
        <!-- Premium Header/Navbar -->
        @php
            $peserta = Auth::guard('peserta')->user();
        @endphp
        <header class="header">
            <div class="header-left">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="page-info">
                    <h1 class="page-title">@yield('title', 'Dashboard')</h1>
                    <nav class="breadcrumb">
                        <a href="{{ route('peserta.dashboard') }}">
                            <i class="fas fa-home"></i>
                        </a>
                        @yield('breadcrumb')
                    </nav>
                </div>
            </div>
            <div class="header-right">
                <!-- Welcome Badge -->
                <div class="welcome-badge">
                    <i class="fas fa-hand-sparkles"></i>
                    <span>Selamat Datang!</span>
                </div>
                
                <!-- User Menu -->
                <div class="user-menu">
                    <div class="user-avatar">
                        <span>{{ strtoupper(substr($peserta->nama ?? 'P', 0, 1)) }}</span>
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ $peserta->nama ?? 'Peserta' }}</div>
                        <div class="user-role">NIM: {{ $peserta->nim ?? '' }}</div>
                    </div>
                    <div class="user-dropdown">
                        <button class="dropdown-toggle" id="userDropdownToggle">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" id="userDropdownMenu">
                            <a href="{{ route('peserta.dashboard') }}" class="dropdown-item">
                                <i class="fas fa-user"></i> Profil Saya
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item logout">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="content">
            @if(session('success'))
                <x-alert type="success">{{ session('success') }}</x-alert>
            @endif

            @if(session('error'))
                <x-alert type="error">{{ session('error') }}</x-alert>
            @endif

            @if($errors->any())
                <x-alert type="error">
                    <ul style="margin: 0; padding-left: 1rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            @yield('content')
        </div>

        <!-- Premium Footer -->
        <footer class="dashboard-footer">
            <div class="footer-content">
                <div class="footer-left">
                    <span>&copy; {{ date('Y') }} Lab Praktikum UMPAR. All rights reserved.</span>
                </div>
                <div class="footer-right">
                    <span class="footer-version">
                        <i class="fas fa-code-branch"></i> v1.0.0
                    </span>
                </div>
            </div>
        </footer>
    </main>

    <script>
        // Menu Toggle for Mobile
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        }

        // User Dropdown
        const dropdownToggle = document.getElementById('userDropdownToggle');
        const dropdownMenu = document.getElementById('userDropdownMenu');

        if (dropdownToggle) {
            dropdownToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdownMenu.classList.toggle('show');
            });

            document.addEventListener('click', () => {
                dropdownMenu.classList.remove('show');
            });
        }
    </script>
@endsection

@push('styles')
<style>
    :root {
        --sidebar-width: 260px;
        --header-height: 70px;
        --primary-gradient: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
    }

    .main-content {
        margin-left: var(--sidebar-width);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background: linear-gradient(135deg, #f0fdfa 0%, #f1f5f9 100%);
    }

    .content {
        padding: 1.5rem;
        flex: 1;
    }

    /* Premium Header */
    .header {
        height: var(--header-height);
        background: white;
        border-bottom: 1px solid rgba(20, 184, 166, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 1.5rem;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .menu-toggle {
        display: none;
        background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
        border: 1px solid rgba(20, 184, 166, 0.2);
        width: 40px;
        height: 40px;
        border-radius: 10px;
        font-size: 1.125rem;
        color: #0d9488;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .menu-toggle:hover {
        background: #0d9488;
        color: white;
    }

    .page-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .page-title {
        font-size: 1.375rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8125rem;
        color: #64748b;
    }

    .breadcrumb a {
        color: #0d9488;
        text-decoration: none;
        transition: color 0.2s;
    }

    .breadcrumb a:hover {
        color: #0f766e;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    /* Welcome Badge */
    .welcome-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
        border: 1px solid rgba(20, 184, 166, 0.2);
        border-radius: 9999px;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #0d9488;
    }

    .welcome-badge i {
        color: #f59e0b;
    }

    /* User Menu */
    .user-menu {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 0.75rem 0.5rem 0.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 50px;
        position: relative;
        transition: all 0.3s ease;
    }

    .user-menu:hover {
        border-color: rgba(20, 184, 166, 0.3);
        box-shadow: 0 4px 12px rgba(20, 184, 166, 0.1);
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        background: var(--primary-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.3);
    }

    .user-info {
        text-align: left;
    }

    .user-name {
        font-weight: 600;
        font-size: 0.875rem;
        color: #0f172a;
        line-height: 1.2;
    }

    .user-role {
        font-size: 0.75rem;
        color: #64748b;
    }

    .dropdown-toggle {
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 0.25rem;
        transition: color 0.2s;
    }

    .dropdown-toggle:hover {
        color: #0d9488;
    }

    .user-dropdown {
        position: relative;
    }

    .dropdown-menu {
        position: absolute;
        top: calc(100% + 0.5rem);
        right: 0;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        min-width: 200px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        z-index: 1000;
        overflow: hidden;
    }

    .dropdown-menu.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: #475569;
        text-decoration: none;
        font-size: 0.875rem;
        transition: all 0.2s;
        border: none;
        background: none;
        width: 100%;
        cursor: pointer;
    }

    .dropdown-item:hover {
        background: #f0fdfa;
        color: #0d9488;
    }

    .dropdown-item.logout {
        color: #dc2626;
    }

    .dropdown-item.logout:hover {
        background: #fef2f2;
        color: #dc2626;
    }

    .dropdown-divider {
        height: 1px;
        background: #e2e8f0;
        margin: 0.25rem 0;
    }

    /* Overlay */
    .overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(4px);
        z-index: 999;
        transition: all 0.3s ease;
    }

    .overlay.active {
        display: block;
    }

    /* Premium Footer */
    .dashboard-footer {
        background: white;
        border-top: 1px solid rgba(20, 184, 166, 0.1);
        padding: 1rem 1.5rem;
        margin-top: auto;
    }

    .footer-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .footer-left {
        font-size: 0.8125rem;
        color: #64748b;
    }

    .footer-right {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .footer-version {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.75rem;
        color: #94a3b8;
        padding: 0.25rem 0.75rem;
        background: #f1f5f9;
        border-radius: 9999px;
    }

    /* Mobile Responsive */
    @media (max-width: 1024px) {
        .main-content {
            margin-left: 0;
        }

        .menu-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-badge {
            display: none;
        }

        .user-info {
            display: none;
        }

        .footer-content {
            flex-direction: column;
            gap: 0.5rem;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .header {
            padding: 0 1rem;
        }

        .page-title {
            font-size: 1.125rem;
        }

        .breadcrumb {
            display: none;
        }

        .content {
            padding: 1rem;
        }
    }
</style>
@endpush
