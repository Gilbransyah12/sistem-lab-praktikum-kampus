@extends('layouts.app')

@section('body')
    <!-- Overlay for mobile -->
    <div class="sidebar-overlay" id="overlay"></div>

    <!-- Sidebar Component -->
    <x-sidebar role="admin" />

    <!-- Main Content -->
    <main class="main-content">
        <!-- Navbar Component -->
        <x-navbar :title="View::getSection('title', 'Dashboard')" role="admin" />

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Alert Messages -->
            @if(session('success'))
                <x-alert type="success">{{ session('success') }}</x-alert>
            @endif

            @if(session('error'))
                <x-alert type="error">{{ session('error') }}</x-alert>
            @endif

            @if($errors->any())
                <x-alert type="error">
                    <ul class="error-list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <!-- Page Content -->
            <div class="page-content animate-fade-in">
                @yield('content')
            </div>
        </div>

        <!-- Footer Component -->
        <x-footer />
    </main>

    <script>
        // Mobile menu toggle functionality
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            });
        }

        // Close sidebar on window resize (desktop)
        window.addEventListener('resize', () => {
            if (window.innerWidth > 1024) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    </script>
@endsection

@push('styles')
<style>
/* =====================================================
   ADMIN LAYOUT STYLES
   ===================================================== */
.main-content {
    margin-left: var(--sidebar-width);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background: var(--dark-100);
    transition: margin-left var(--transition-slow);
}

.content-wrapper {
    flex: 1;
    padding: 1.5rem;
    max-width: 100%;
}

.page-content {
    max-width: 1600px;
}

.error-list {
    margin: 0;
    padding-left: 1.25rem;
    list-style-type: disc;
}

.error-list li {
    margin-bottom: 0.25rem;
}

.error-list li:last-child {
    margin-bottom: 0;
}

/* Sidebar Overlay */
.sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 999;
    opacity: 0;
    transition: opacity var(--transition-base);
}

.sidebar-overlay.active {
    display: block;
    opacity: 1;
}

/* Responsive Layout */
@media (max-width: 1024px) {
    .main-content {
        margin-left: 0;
    }
    
    .content-wrapper {
        padding: 1rem;
    }
}

@media (max-width: 640px) {
    .content-wrapper {
        padding: 0.75rem;
    }
}
</style>
@endpush

{{-- SweetAlert2 Integration --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Success Toast
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end',
                background: '#fff',
                iconColor: '#10b981'
            });
        @endif

        // Error Toast
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                showConfirmButton: true,
                confirmButtonColor: '#ef4444'
            });
        @endif

        // Validation Errors
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Perhatian!',
                html: '<ul style="text-align: left;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#ef4444'
            });
        @endif
    });
</script>
