<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — AMS Apotek Management System (Glassmo Edition)</title>
    <link rel="icon" type="image/png" href="/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
            --shadow-md: 0 25px 60px rgba(16, 185, 129, 0.15);
            --glass-blur: blur(20px);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            margin: 0;
            padding: 2rem 1rem;
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

        @keyframes orbFloat {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(45px, -45px) scale(1.15); }
            100% { transform: translate(-30px, 30px) scale(0.95); }
        }

        /* --- TOP ACTIONS --- */
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

        .auth-card {
            background: var(--card-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--border-color);
            border-top: 1px solid var(--border-specular);
            border-radius: 2rem;
            box-shadow: var(--shadow-md);
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 2;
        }
        .brand-logo-icon {
            width: 58px; height: 58px;
            background: linear-gradient(135deg, rgba(52, 211, 153, 0.25), rgba(34, 211, 238, 0.15));
            border: 1px solid rgba(52, 211, 153, 0.5);
            color: #34d399;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            box-shadow: 0 0 25px rgba(52, 211, 153, 0.35);
        }
        .form-label {
            font-weight: 600;
            color: var(--text-main);
            font-size: 0.88rem;
        }
        .form-control {
            background: var(--input-bg) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-main) !important;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
        }
        .btn-register {
            background: linear-gradient(135deg, #10b981, #059669);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-weight: 700;
            border-radius: 50px;
            padding: 0.75rem 2rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.35);
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(16, 185, 129, 0.55);
            background: linear-gradient(135deg, #34d399, #10b981);
            color: #ffffff;
        }
        .footer-text {
            text-align: center;
            margin-top: 2rem;
            color: var(--text-muted);
            font-size: 0.82rem;
        }
        .footer-text a {
            color: #34d399;
            text-decoration: none;
            font-weight: 700;
        }
    </style>
</head>
<body>

    <!-- AURORA GLOW BACKGROUND -->
    <div class="aurora-container">
        <div class="aurora-orb orb-1"></div>
        <div class="aurora-orb orb-2"></div>
    </div>

    <!-- TOP ACTIONS -->
    <div class="top-actions">
        <a href="{{ url('/') }}" class="btn-glass-action" title="Kembali ke Beranda">
            <i class="fa-solid fa-house"></i>
        </a>
        <button class="btn-glass-action" id="themeToggle" title="Ganti Mode Gelap / Terang">
            <i class="fa-solid fa-sun text-warning" id="themeIcon"></i>
        </button>
    </div>

    <div class="auth-card">
        <div class="text-center mb-4">
            <div class="brand-logo-icon mb-2">
                <i class="fa-solid fa-prescription-bottle-medical"></i>
            </div>
            <h4 class="fw-bold mt-2">Daftar Akun AMS</h4>
            <p class="small text-muted mb-0">Buat akun untuk mengelola stok apotek</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus placeholder="Nama Anda">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="email@ams.co.id">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Kata Sandi</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Minimal 8 karakter">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi kata sandi">
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('login') }}" class="text-decoration-none small fw-semibold" style="color: #34d399;">Sudah punya akun?</a>
                <button type="submit" class="btn btn-register">Daftar</button>
            </div>
        </form>

        <div class="footer-text">
            &copy; {{ date('Y') }} <strong>AMS Apotek Management System</strong>.<br>
            Crafted with <i class="fa-solid fa-heart text-danger"></i> by <a href="{{ config('app.developer_url', 'https://harunarrasyid.vercel.app') }}" target="_blank">{{ config('app.developer_name', 'nhmedia technology') }}</a>
        </div>
    </div>

    <script>
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
    </script>
</body>
</html>
