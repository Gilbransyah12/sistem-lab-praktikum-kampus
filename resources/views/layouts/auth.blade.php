<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') - Lab Praktikum UMPAR</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
        }

        /* Animated Gradient Background - Matching Landing Page */
        .bg-gradient {
            position: fixed;
            inset: 0;
            background: linear-gradient(-45deg, #0f172a, #134e4a, #0d9488, #0e7490);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            z-index: -3;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating Orbs */
        .floating-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            animation: float 20s infinite ease-in-out;
            z-index: -2;
        }

        .orb-1 {
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #14b8a6, #06b6d4);
            top: -150px;
            right: -150px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #06b6d4, #22d3ee);
            bottom: -100px;
            left: -100px;
            animation-delay: -7s;
        }

        .orb-3 {
            width: 250px;
            height: 250px;
            background: linear-gradient(135deg, #2dd4bf, #14b8a6);
            top: 50%;
            left: 10%;
            animation-delay: -14s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-30px) rotate(5deg); }
            50% { transform: translateY(0) rotate(0deg); }
            75% { transform: translateY(30px) rotate(-5deg); }
        }

        /* Grid Pattern Overlay */
        .grid-pattern {
            position: fixed;
            inset: 0;
            opacity: 0.03;
            background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
            z-index: -1;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 10;
        }

        /* Back to Home Link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: white;
            transform: translateX(-4px);
        }

        /* Glassmorphism Card */
        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 1.5rem;
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            animation: cardSlideUp 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes cardSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-header {
            padding: 2.5rem 2rem 1.5rem;
            text-align: center;
            background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
            border-bottom: 1px solid rgba(20, 184, 166, 0.1);
            position: relative;
            overflow: hidden;
        }

        .auth-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #0d9488, #06b6d4, #0d9488);
            background-size: 200% 100%;
            animation: shimmer 2s infinite linear;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .auth-logo {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
            border-radius: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            box-shadow: 
                0 10px 30px rgba(13, 148, 136, 0.3),
                0 0 0 4px rgba(20, 184, 166, 0.1);
            position: relative;
        }

        .auth-logo::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 1.5rem;
            border: 2px solid transparent;
            background: linear-gradient(135deg, rgba(20, 184, 166, 0.4), rgba(6, 182, 212, 0.4)) border-box;
            -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }

        .auth-logo i {
            font-size: 2rem;
            color: white;
        }

        .auth-header h1 {
            font-size: 1.625rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.375rem;
            letter-spacing: -0.025em;
        }

        .auth-header p {
            color: #64748b;
            font-size: 0.9375rem;
        }

        .auth-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.625rem;
            font-weight: 600;
            font-size: 0.875rem;
            color: #334155;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            transition: color 0.3s ease;
            font-size: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 0.9375rem 1rem 0.9375rem 3rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
            background: white;
            color: #0f172a;
        }

        .form-control:focus {
            outline: none;
            border-color: #14b8a6;
            box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.1);
        }

        .form-control:focus + i,
        .input-group:focus-within i {
            color: #0d9488;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            width: 100%;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: inherit;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 10px 25px rgba(13, 148, 136, 0.4),
                0 0 30px rgba(20, 184, 166, 0.2);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .auth-footer {
            padding: 1.25rem 2rem;
            text-align: center;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .auth-footer p {
            color: #64748b;
            font-size: 0.8125rem;
        }

        .auth-footer a {
            color: #0d9488;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .auth-footer a:hover {
            color: #0f766e;
            text-decoration: underline;
        }

        /* Alert Styles */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            animation: alertShake 0.5s ease;
        }

        @keyframes alertShake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-4px); }
            20%, 40%, 60%, 80% { transform: translateX(4px); }
        }

        .alert-danger {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .alert-danger i {
            font-size: 1.125rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        /* Tab Styles */
        .tabs {
            display: flex;
            margin-bottom: 1.75rem;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            padding: 0.375rem;
            gap: 0.25rem;
        }

        .tab {
            flex: 1;
            padding: 0.75rem 1rem;
            text-align: center;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #64748b;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .tab.active {
            background: white;
            color: #0d9488;
            box-shadow: 
                0 4px 12px rgba(0, 0, 0, 0.08),
                0 0 0 1px rgba(20, 184, 166, 0.1);
        }

        .tab:not(.active):hover {
            color: #0f172a;
            background: rgba(255, 255, 255, 0.5);
        }

        /* Remember Me Checkbox */
        .form-check {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            margin-bottom: 1.5rem;
        }

        .form-check input[type="checkbox"] {
            width: 1.125rem;
            height: 1.125rem;
            accent-color: #0d9488;
            cursor: pointer;
        }

        .form-check label {
            font-size: 0.875rem;
            color: #475569;
            cursor: pointer;
            user-select: none;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .auth-container {
                max-width: 100%;
            }

            .auth-card {
                border-radius: 1.25rem;
            }

            .auth-header {
                padding: 2rem 1.5rem 1.25rem;
            }

            .auth-body {
                padding: 1.5rem;
            }

            .auth-logo {
                width: 64px;
                height: 64px;
            }

            .auth-logo i {
                font-size: 1.75rem;
            }

            .auth-header h1 {
                font-size: 1.375rem;
            }
        }
        /* Floating Label Styles */
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-control {
            height: 3.5rem;
            padding: 1.25rem 1rem 0.5rem 3rem; /* Extra top padding for label space */
        }

        .input-group i {
            z-index: 2; /* Ensure icon stays on top */
        }

        .floating-label {
            position: absolute;
            left: 3rem; /* Align with text start (after icon) */
            top: 1rem;
            color: #64748b;
            font-size: 1rem;
            pointer-events: none;
            transition: all 0.2s ease-out;
            transform-origin: left top;
            background: transparent;
        }

        /* Float when focused or has value */
        .form-control:focus ~ .floating-label,
        .form-control:not(:placeholder-shown) ~ .floating-label {
            transform: translateY(-0.6rem) scale(0.85);
            color: #0d9488;
            font-weight: 600;
        }

        /* Error state adjustment */
        .form-control.is-invalid ~ .floating-label {
            color: #dc2626;
        }

        /* Remove default placeholders since we use labels */
        .form-control::placeholder {
            color: transparent;
        }
    </style>
</head>
<body>
    <!-- Background Elements -->
    <div class="bg-gradient"></div>
    <div class="floating-orb orb-1"></div>
    <div class="floating-orb orb-2"></div>
    <div class="floating-orb orb-3"></div>
    <div class="grid-pattern"></div>
    
    <div class="auth-container">
        <!-- Back to Home Link -->
        <a href="{{ route('home') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Beranda</span>
        </a>
        
        @yield('content')
    </div>
</body>
</html>
