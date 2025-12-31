<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Praktikum - UMPAR | Sistem Informasi Laboratorium</title>
    <meta name="description" content="Sistem Informasi Laboratorium Praktikum Universitas Muhammadiyah Parepare - Pendaftaran Online, Jadwal, Absensi & Nilai Digital">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Landing Page Specific Styles */
        .landing-body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        /* Animated Gradient Background */
        .hero-gradient {
            background: linear-gradient(-45deg, #0f172a, #134e4a, #0d9488, #0e7490);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating Orbs */
        .floating-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.4;
            animation: float 20s infinite ease-in-out;
        }

        .orb-1 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #14b8a6, #06b6d4);
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #06b6d4, #22d3ee);
            bottom: 10%;
            left: -50px;
            animation-delay: -5s;
        }

        .orb-3 {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #2dd4bf, #14b8a6);
            top: 40%;
            right: 10%;
            animation-delay: -10s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(5deg); }
            50% { transform: translateY(0) rotate(0deg); }
            75% { transform: translateY(20px) rotate(-5deg); }
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15), 0 0 30px rgba(20, 184, 166, 0.1);
        }

        /* Navbar Scroll Effect */
        .navbar {
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        /* Button Glow */
        .btn-glow {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-glow::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: 0.5s;
        }

        .btn-glow:hover::before {
            left: 100%;
        }

        .btn-glow:hover {
            box-shadow: 0 0 30px rgba(20, 184, 166, 0.5);
            transform: translateY(-2px);
        }

        /* Counter Animation */
        .counter {
            font-variant-numeric: tabular-nums;
        }

        /* Feature Icon Gradient */
        .feature-icon {
            background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
            box-shadow: 0 10px 30px rgba(13, 148, 136, 0.3);
        }

        /* Timeline */
        .timeline-line {
            background: linear-gradient(180deg, #0d9488, #06b6d4);
        }

        /* Fade In Animation */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Stagger delay */
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
        .delay-400 { transition-delay: 400ms; }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Stats Section Gradient */
        .stats-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #134e4a 50%, #0d9488 100%);
        }


    </style>
</head>
<body class="landing-body">
    
    <!-- Floating Navbar -->
    <nav class="navbar fixed top-0 left-0 right-0 z-50 px-4 py-4" id="navbar">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <!-- Logo -->
            <a href="#" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-gradient-to-br from-teal-400 to-cyan-400 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-teal-500/30 transition-shadow">
                    <i class="fas fa-flask text-white text-lg"></i>
                </div>
                <span class="text-white font-bold text-xl">Lab<span class="text-teal-400">UMPAR</span></span>
            </a>
            
            <!-- Nav Links - Desktop -->
            <div class="hidden md:flex items-center gap-8">
                <a href="#features" class="text-white/70 hover:text-white transition-colors text-sm font-medium">Fitur</a>
                <a href="#stats" class="text-white/70 hover:text-white transition-colors text-sm font-medium">Statistik</a>
                <a href="#how-it-works" class="text-white/70 hover:text-white transition-colors text-sm font-medium">Cara Kerja</a>
            </div>
            
            <!-- CTA Buttons -->
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ url('/' . Auth::user()->role . '/dashboard') }}" class="btn-glow bg-gradient-to-r from-teal-500 to-cyan-500 text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-lg">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="hidden sm:inline-flex text-white/80 hover:text-white text-sm font-medium transition-colors">
                        Daftar Mahasiswa
                    </a>
                    <a href="{{ route('login') }}" class="btn-glow bg-gradient-to-r from-teal-500 to-cyan-500 text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-lg">
                        Masuk
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient min-h-screen flex items-center justify-center relative overflow-hidden pt-20">
        <!-- Floating Orbs -->
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>
        
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <div class="relative z-10 text-center px-4 max-w-5xl mx-auto">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 glass px-4 py-2 rounded-full mb-8 fade-in">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                <span class="text-white/80 text-sm font-medium">Sistem Terintegrasi & Modern</span>
            </div>
            
            <!-- Main Heading -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-tight fade-in delay-100">
                Lab Praktikum
                <span class="block bg-gradient-to-r from-teal-300 via-cyan-300 to-teal-300 bg-clip-text text-transparent">UMPAR Digital</span>
            </h1>
            
            <!-- Description -->
            <p class="text-lg sm:text-xl text-white/70 max-w-2xl mx-auto mb-10 leading-relaxed fade-in delay-200">
                Sistem Informasi Laboratorium Praktikum Universitas Muhammadiyah Parepare. 
                Kelola pendaftaran, jadwal, absensi, dan nilai praktikum dalam satu platform terintegrasi.
            </p>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 fade-in delay-300">
                @auth
                    <a href="{{ url('/' . Auth::user()->role . '/dashboard') }}" class="btn-glow w-full sm:w-auto bg-white text-slate-800 px-8 py-4 rounded-2xl font-bold text-lg shadow-xl hover:shadow-2xl flex items-center justify-center gap-3 group">
                        <i class="fas fa-tachometer-alt text-teal-600 group-hover:scale-110 transition-transform"></i>
                        <span>Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-glow w-full sm:w-auto bg-white text-slate-800 px-8 py-4 rounded-2xl font-bold text-lg shadow-xl hover:shadow-2xl flex items-center justify-center gap-3 group">
                        <i class="fas fa-user-graduate text-teal-600 group-hover:scale-110 transition-transform"></i>
                        <span>Daftar Mahasiswa</span>
                    </a>
                    <a href="{{ route('login') }}" class="btn-glow w-full sm:w-auto glass text-white px-8 py-4 rounded-2xl font-bold text-lg flex items-center justify-center gap-3 group hover:bg-white/20">
                        <i class="fas fa-user-shield group-hover:scale-110 transition-transform"></i>
                        <span>Login</span>
                    </a>
                @endauth
            </div>
            

        </div>
        

    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-slate-100">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span class="inline-block bg-gradient-to-r from-teal-500 to-cyan-500 text-white px-4 py-1.5 rounded-full text-sm font-semibold mb-4 fade-in">
                    FITUR UNGGULAN
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-800 mb-4 fade-in delay-100">
                    Semua Yang Anda Butuhkan
                </h2>
                <p class="text-slate-600 max-w-2xl mx-auto fade-in delay-200">
                    Kelola seluruh aktivitas praktikum dengan fitur lengkap yang mudah digunakan
                </p>
            </div>
            
            <!-- Features Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Feature 1 -->
                <div class="glass-card rounded-2xl p-6 fade-in">
                    <div class="feature-icon w-14 h-14 rounded-xl flex items-center justify-center mb-5">
                        <i class="fas fa-clipboard-list text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Pendaftaran Online</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Daftar praktikum secara online kapan saja dan dimana saja dengan mudah dan cepat.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="glass-card rounded-2xl p-6 fade-in delay-100">
                    <div class="feature-icon w-14 h-14 rounded-xl flex items-center justify-center mb-5">
                        <i class="fas fa-calendar-alt text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Jadwal Praktikum</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Lihat jadwal praktikum secara real-time dengan informasi ruangan dan instruktur.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="glass-card rounded-2xl p-6 fade-in delay-200">
                    <div class="feature-icon w-14 h-14 rounded-xl flex items-center justify-center mb-5">
                        <i class="fas fa-user-check text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Absensi Digital</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Sistem absensi digital terintegrasi dengan tracking kehadiran per sesi praktikum.
                    </p>
                </div>
                
                <!-- Feature 4 -->
                <div class="glass-card rounded-2xl p-6 fade-in delay-300">
                    <div class="feature-icon w-14 h-14 rounded-xl flex items-center justify-center mb-5">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Nilai Realtime</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Pantau nilai praktikum secara real-time dengan sistem penilaian yang transparan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section id="stats" class="stats-gradient py-24 relative overflow-hidden">
        <!-- Floating Elements -->
        <div class="absolute top-10 left-10 w-20 h-20 border border-white/10 rounded-2xl rotate-12"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 border border-white/10 rounded-full"></div>
        
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4 fade-in">
                    Dipercaya oleh Banyak Pengguna
                </h2>
                <p class="text-white/70 max-w-xl mx-auto fade-in delay-100">
                    Bergabung bersama ribuan mahasiswa dan instruktur di UMPAR
                </p>
            </div>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Stat 1 -->
                <div class="text-center fade-in">
                    <div class="glass rounded-2xl p-6 mb-4">
                        <i class="fas fa-users text-4xl text-teal-300 mb-4"></i>
                        <div class="text-4xl sm:text-5xl font-extrabold text-white counter" data-target="500">500+</div>
                    </div>
                    <p class="text-white/70 font-medium">Mahasiswa Terdaftar</p>
                </div>
                
                <!-- Stat 2 -->
                <div class="text-center fade-in delay-100">
                    <div class="glass rounded-2xl p-6 mb-4">
                        <i class="fas fa-flask text-4xl text-cyan-300 mb-4"></i>
                        <div class="text-4xl sm:text-5xl font-extrabold text-white counter" data-target="20">20+</div>
                    </div>
                    <p class="text-white/70 font-medium">Mata Praktikum</p>
                </div>
                
                <!-- Stat 3 -->
                <div class="text-center fade-in delay-200">
                    <div class="glass rounded-2xl p-6 mb-4">
                        <i class="fas fa-chalkboard-teacher text-4xl text-teal-300 mb-4"></i>
                        <div class="text-4xl sm:text-5xl font-extrabold text-white counter" data-target="30">30+</div>
                    </div>
                    <p class="text-white/70 font-medium">Instruktur Ahli</p>
                </div>
                
                <!-- Stat 4 -->
                <div class="text-center fade-in delay-300">
                    <div class="glass rounded-2xl p-6 mb-4">
                        <i class="fas fa-desktop text-4xl text-cyan-300 mb-4"></i>
                        <div class="text-4xl sm:text-5xl font-extrabold text-white counter" data-target="10">10+</div>
                    </div>
                    <p class="text-white/70 font-medium">Laboratorium</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <span class="inline-block bg-gradient-to-r from-teal-500 to-cyan-500 text-white px-4 py-1.5 rounded-full text-sm font-semibold mb-4 fade-in">
                    CARA KERJA
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-800 mb-4 fade-in delay-100">
                    Mudah & Cepat
                </h2>
                <p class="text-slate-600 max-w-2xl mx-auto fade-in delay-200">
                    Hanya dalam beberapa langkah sederhana untuk memulai praktikum
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 relative">
                <!-- Connecting Line (Desktop) -->
                <div class="hidden md:block absolute top-16 left-1/6 right-1/6 h-0.5 bg-gradient-to-r from-teal-200 via-teal-400 to-teal-200"></div>
                
                <!-- Step 1 -->
                <div class="text-center relative fade-in">
                    <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-teal-500/30 relative z-10">
                        <span class="text-2xl font-bold text-white">1</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Daftar Akun</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Buat akun peserta dengan NIM dan data diri Anda untuk mulai mengakses sistem.
                    </p>
                </div>
                
                <!-- Step 2 -->
                <div class="text-center relative fade-in delay-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-teal-500/30 relative z-10">
                        <span class="text-2xl font-bold text-white">2</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Pilih Praktikum</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Lihat daftar praktikum tersedia dan daftar sesuai periode pendaftaran aktif.
                    </p>
                </div>
                
                <!-- Step 3 -->
                <div class="text-center relative fade-in delay-200">
                    <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-teal-500/30 relative z-10">
                        <span class="text-2xl font-bold text-white">3</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Mulai Praktikum</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Ikuti jadwal praktikum, absensi digital, dan pantau nilai Anda secara real-time.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;20&quot; height=&quot;20&quot; viewBox=&quot;0 0 20 20&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot; fill-rule=&quot;evenodd&quot;%3E%3Ccircle cx=&quot;3&quot; cy=&quot;3&quot; r=&quot;1&quot;/%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6 fade-in">
                Siap Memulai Praktikum?
            </h2>
            <p class="text-slate-400 text-lg mb-10 max-w-2xl mx-auto fade-in delay-100">
                Bergabung sekarang dan nikmati kemudahan mengelola praktikum secara digital bersama Lab UMPAR.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 fade-in delay-200">
                <a href="{{ route('register') }}" class="btn-glow w-full sm:w-auto bg-gradient-to-r from-teal-500 to-cyan-500 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-xl">
                    <i class="fas fa-rocket mr-2"></i> Daftar Sekarang
                </a>
                <a href="#features" class="w-full sm:w-auto text-white/70 hover:text-white px-8 py-4 rounded-xl font-semibold text-lg transition-colors">
                    Pelajari Lebih Lanjut <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8 mb-12">
                <!-- Brand -->
                <div class="md:col-span-2">
                    <a href="#" class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-teal-400 to-cyan-400 rounded-xl flex items-center justify-center">
                            <i class="fas fa-flask text-white text-lg"></i>
                        </div>
                        <span class="text-white font-bold text-xl">Lab<span class="text-teal-400">UMPAR</span></span>
                    </a>
                    <p class="text-slate-400 mb-6 max-w-sm">
                        Sistem Informasi Laboratorium Praktikum Universitas Muhammadiyah Parepare - Solusi digital untuk pengelolaan praktikum modern.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-teal-500 rounded-lg flex items-center justify-center text-slate-400 hover:text-white transition-all">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-teal-500 rounded-lg flex items-center justify-center text-slate-400 hover:text-white transition-all">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-teal-500 rounded-lg flex items-center justify-center text-slate-400 hover:text-white transition-all">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="#features" class="text-slate-400 hover:text-teal-400 transition-colors text-sm">Fitur</a></li>
                        <li><a href="#stats" class="text-slate-400 hover:text-teal-400 transition-colors text-sm">Statistik</a></li>
                        <li><a href="#how-it-works" class="text-slate-400 hover:text-teal-400 transition-colors text-sm">Cara Kerja</a></li>
                    </ul>
                </div>
                
                <!-- Login -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Akses</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('login') }}" class="text-slate-400 hover:text-teal-400 transition-colors text-sm">Login Admin</a></li>
                        <li><a href="{{ route('login') }}" class="text-slate-400 hover:text-teal-400 transition-colors text-sm">Login Instruktur</a></li>
                        <li><a href="{{ route('register') }}" class="text-slate-400 hover:text-teal-400 transition-colors text-sm">Daftar Mahasiswa</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-slate-500 text-sm">
                    &copy; {{ date('Y') }} Universitas Muhammadiyah Parepare. All rights reserved.
                </p>
                <p class="text-slate-600 text-xs">
                    Made with <i class="fas fa-heart text-red-500"></i> for UMPAR
                </p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Navbar Scroll Effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Fade In Animation on Scroll
        const fadeElements = document.querySelectorAll('.fade-in');
        
        const fadeInObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        fadeElements.forEach(el => fadeInObserver.observe(el));

        // Counter Animation
        const counters = document.querySelectorAll('.counter');
        
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.getAttribute('data-target'));
                    let count = 0;
                    const duration = 2000;
                    const increment = target / (duration / 16);
                    
                    const updateCounter = () => {
                        count += increment;
                        if (count < target) {
                            counter.textContent = Math.floor(count) + '+';
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.textContent = target + '+';
                        }
                    };
                    
                    updateCounter();
                    counterObserver.unobserve(counter);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => counterObserver.observe(counter));
    </script>
</body>
</html>
