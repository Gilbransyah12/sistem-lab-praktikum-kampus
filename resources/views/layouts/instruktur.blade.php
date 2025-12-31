@extends('layouts.app')

@section('body')
    <!-- Overlay for mobile -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar Component -->
    <x-sidebar role="instruktur" />

    <!-- Main Content -->
    <main class="main-content">
        <!-- Navbar Component -->
        <x-navbar :title="View::getSection('title', 'Dashboard')" role="instruktur" />

        <!-- Content -->
        <div class="content">
            @yield('content')
        </div>

        <!-- Footer Component -->
        <x-footer />
    </main>

    <script>
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
    </script>
@endsection

@push('styles')
<style>
    :root {
        --sidebar-width: 260px;
    }

    .main-content {
        margin-left: var(--sidebar-width);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .content {
        padding: 1.5rem;
        flex: 1;
    }

    .overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 999;
    }

    .overlay.active {
        display: block;
    }

    @media (max-width: 768px) {
        .main-content {
            margin-left: 0;
        }
    }
</style>
@endpush
