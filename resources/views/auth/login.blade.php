<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — WMS Sistem Manajemen Gudang</title>
    <link rel="icon" type="image/png" href="/logo.png">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0d6efd 0%, #0a3d8f 40%, #1e2125 100%);
            position: relative;
            overflow: hidden;
        }

        /* Animated background circles */
        body::before {
            content: '';
            position: absolute;
            top: -150px;
            right: -150px;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.03);
            animation: float 8s ease-in-out infinite;
        }
        body::after {
            content: '';
            position: absolute;
            bottom: -200px;
            left: -200px;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.03);
            animation: float 10s ease-in-out infinite reverse;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-30px); }
        }

        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 460px;
            padding: 1rem;
            animation: slideUp 0.6s ease-out;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-card {
            background: rgba(255, 255, 255, 0.97);
            border-radius: 1.25rem;
            box-shadow: 0 25px 60px rgba(0,0,0,0.4);
            padding: 3rem 2.5rem;
            backdrop-filter: blur(10px);
        }

        .brand-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 0.5rem;
        }
        .brand-logo img {
            height: 80px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 12px rgba(13,110,253,0.2));
        }
        .brand-name {
            font-size: 1.8rem;
            font-weight: 800;
            color: #0d6efd;
            letter-spacing: -1px;
        }
        .brand-subtitle {
            text-align: center;
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 1.5px solid #e9ecef;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
        }
        .input-group-text {
            border-radius: 10px 0 0 10px;
            background: #f8f9fa;
            border: 1.5px solid #e9ecef;
            color: #6c757d;
        }
        .input-group .form-control {
            border-radius: 0 10px 10px 0;
            border-left: none;
        }
        .input-group:focus-within .input-group-text {
            border-color: #0d6efd;
            color: #0d6efd;
        }
        .input-group:focus-within .form-control {
            border-color: #0d6efd;
        }

        .btn-login {
            width: 100%;
            padding: 0.85rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            background: linear-gradient(135deg, #0d6efd, #0a3d8f);
            border: none;
            color: white;
            transition: all 0.3s ease;
            letter-spacing: 0.3px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.4);
        }

        .footer-text {
            text-align: center;
            margin-top: 2rem;
            color: #adb5bd;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">

            <!-- Brand -->
            <div class="brand-logo">
                <img src="/logo.png" alt="WMS Logo">
                <span class="brand-name">WMS</span>
            </div>
            <p class="brand-subtitle">Sistem Manajemen Gudang &mdash; Portal Administrator</p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold text-dark">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}"
                               required autofocus autocomplete="username"
                               placeholder="admin@wms.co.id">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold text-dark">Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password"
                               required autocomplete="current-password"
                               placeholder="Masukkan kata sandi">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                        <label class="form-check-label text-muted" for="remember_me">Ingat saya</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-primary text-decoration-none small fw-semibold">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Sistem
                </button>
            </form>

            <div class="footer-text">
                &copy; {{ date('Y') }} WMS — Sistem Manajemen Gudang. All rights reserved.
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
