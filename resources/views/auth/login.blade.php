<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — AMS Apotek Management System (Glassmo Edition)</title>
    <link rel="icon" type="image/png" href="/logo.png">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root, [data-theme="dark"] {
            --primary-color: #10b981;
            --secondary-color: #34d399;
            --bg-color: #030816;
            --card-bg: rgba(15, 23, 42, 0.65);
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border-color: rgba(255, 255, 255, 0.16);
            --border-specular: rgba(255, 255, 255, 0.35);
            --input-bg: rgba(0, 0, 0, 0.3);
            --input-addon-bg: rgba(0, 0, 0, 0.45);
            --shadow-md: 0 25px 60px rgba(0, 0, 0, 0.65);
            --glass-blur: blur(28px);
        }

        [data-theme="light"] {
            --primary-color: #059669;
            --secondary-color: #10b981;
            --bg-color: #f0fdf4;
            --card-bg: rgba(255, 255, 255, 0.75);
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: rgba(226, 232, 240, 0.85);
            --border-specular: #ffffff;
            --input-bg: rgba(255, 255, 255, 0.7);
            --input-addon-bg: rgba(255, 255, 255, 0.9);
            --shadow-md: 0 25px 60px rgba(16, 185, 129, 0.15);
            --glass-blur: blur(20px);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-color);
            color: var(--text-main);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        /* --- AURORA GLOW BACKGROUND --- */
        .aurora-container {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }
        .aurora-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(85px);
            opacity: 0.55;
            animation: orbFloat 14s ease-in-out infinite alternate;
        }
        .orb-1 {
            width: 650px; height: 650px;
            background: radial-gradient(circle, #10b981 0%, rgba(16, 185, 129, 0) 70%);
            top: -150px; left: -150px;
        }
        .orb-2 {
            width: 550px; height: 550px;
            background: radial-gradient(circle, #06b6d4 0%, rgba(6, 182, 212, 0) 70%);
            top: 35%; right: -150px;
            animation-delay: -5s;
        }
        .orb-3 {
            width: 700px; height: 700px;
            background: radial-gradient(circle, #8b5cf6 0%, rgba(139, 92, 246, 0) 70%);
            bottom: -200px; left: 20%;
            animation-delay: -10s;
        }

        @keyframes orbFloat {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(45px, -45px) scale(1.15); }
            100% { transform: translate(-30px, 30px) scale(0.95); }
        }

        /* --- TOP THEME TOGGLE & HOME BUTTON --- */
        .top-actions {
            position: absolute;
            top: 2rem; right: 2rem;
            display: flex;
            gap: 0.75rem;
            z-index: 10;
        }
        .btn-glass-action {
            width: 44px; height: 44px;
            border-radius: 14px;
            background: var(--card-bg);
            backdrop-filter: var(--glass-blur);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            text-decoration: none;
            transition: all 0.25s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.25);
            cursor: pointer;
        }
        .btn-glass-action:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        /* --- FROSTED GLASS LOGIN CARD --- */
        .login-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 450px;
            padding: 1.5rem;
        }
        .login-card {
            background: var(--card-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--border-color);
            border-top: 1px solid var(--border-specular);
            border-radius: 2rem;
            padding: 3rem 2.5rem;
            box-shadow: var(--shadow-md);
            color: var(--text-main);
            position: relative;
            overflow: hidden;
        }

        .brand-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 0.5rem;
        }
        .brand-logo-icon {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, rgba(52, 211, 153, 0.25), rgba(34, 211, 238, 0.15));
            border: 1px solid rgba(52, 211, 153, 0.5);
            color: #34d399;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            box-shadow: 0 0 25px rgba(52, 211, 153, 0.35);
        }
        .brand-name {
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.5px;
        }
        .brand-subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 2.25rem;
        }

        /* --- GLASS FORM INPUTS --- */
        .form-label {
            font-weight: 600;
            color: var(--text-main);
            font-size: 0.9rem;
        }
        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            background: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-main) !important;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
        }
        .form-control::placeholder {
            color: var(--text-muted);
            opacity: 0.65;
        }
        .input-group-text {
            border-radius: 12px 0 0 12px;
            background: var(--input-addon-bg) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-muted) !important;
        }
        .input-group .form-control {
            border-radius: 0;
            border-left: none;
        }
        .input-group .form-control:not(:last-child) {
            border-radius: 0;
        }
        .input-group .input-group-text:last-child {
            border-radius: 0 12px 12px 0;
            border-left: none;
            background: var(--input-addon-bg) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-muted) !important;
            transition: all 0.2s ease;
        }
        .input-group:focus-within .input-group-text {
            border-color: var(--primary-color) !important;
            color: var(--primary-color) !important;
        }

        /* --- NEON BUTTON --- */
        .btn-login {
            width: 100%;
            padding: 0.9rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            background: linear-gradient(135deg, #10b981, #059669);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.35);
        }
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(16, 185, 129, 0.55);
            background: linear-gradient(135deg, #34d399, #10b981);
            color: #ffffff;
        }

        .footer-text {
            text-align: center;
            margin-top: 2.2rem;
            color: var(--text-muted);
            font-size: 0.82rem;
        }
        .footer-text a {
            color: #34d399;
            text-decoration: none;
            font-weight: 700;
        }
        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- AURORA GLOW BACKGROUND -->
    <div class="aurora-container">
        <div class="aurora-orb orb-1"></div>
        <div class="aurora-orb orb-2"></div>
        <div class="aurora-orb orb-3"></div>
    </div>

    <!-- TOP ACTIONS (HOME & THEME TOGGLE) -->
    <div class="top-actions">
        <a href="{{ url('/') }}" class="btn-glass-action" title="Kembali ke Beranda">
            <i class="fa-solid fa-house"></i>
        </a>
        <button class="btn-glass-action" id="themeToggle" title="Ganti Mode Gelap / Terang">
            <i class="fa-solid fa-sun text-warning" id="themeIcon"></i>
        </button>
    </div>

    <div class="login-wrapper">
        <div class="login-card">

            <!-- Brand -->
            <div class="brand-logo">
                <div class="brand-logo-icon">
                    <i class="fa-solid fa-prescription-bottle-medical"></i>
                </div>
                <span class="brand-name">AMS</span>
            </div>
            <p class="brand-subtitle">Apotek Management System &mdash; Portal Apoteker</p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success d-flex align-items-center mb-4" role="alert" style="background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.4); color: var(--text-main);">
                    <i class="fa-solid fa-circle-check me-2 text-success"></i>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="form-label">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}"
                               required autofocus autocomplete="username"
                               placeholder="apoteker@ams.co.id">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password"
                               required autocomplete="current-password"
                               placeholder="Masukkan kata sandi">
                        <button type="button" class="input-group-text" id="togglePassword"
                                style="cursor:pointer; border-radius: 0 12px 12px 0; border-left: none;"
                                title="Tampilkan/Sembunyikan kata sandi">
                            <i class="fa-solid fa-eye" id="togglePasswordIcon"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember" style="background-color: var(--input-bg); border-color: var(--border-color);">
                        <label class="form-check-label small" for="remember_me" style="color: var(--text-muted);">Ingat saya</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-decoration-none small fw-semibold" style="color: #34d399;">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-login">
                    <i class="fa-solid fa-right-to-bracket me-2"></i>Masuk ke Sistem
                </button>
            </form>

            <div class="footer-text">
                &copy; {{ date('Y') }} <strong>AMS Apotek Management System</strong>.<br>
                Crafted with <i class="fa-solid fa-heart text-danger"></i> by <a href="{{ config('app.developer_url', 'https://harunarrasyid.vercel.app') }}" target="_blank">{{ config('app.developer_name', 'nhmedia technology') }}</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Theme Management (Dark Mode / Light Mode)
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const savedTheme = localStorage.getItem('ams_theme') || 'dark';

        function setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('ams_theme', theme);
            if (theme === 'dark') {
                themeIcon.className = 'fa-solid fa-sun text-warning';
            } else {
                themeIcon.className = 'fa-solid fa-moon text-dark';
            }
        }

        setTheme(savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
        });

        // Password Visibility Toggle
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'fa-solid fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                icon.className = 'fa-solid fa-eye';
            }
        });
    </script>
</body>
</html>
