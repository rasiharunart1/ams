<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMS - Apotek Management System</title>
    <link rel="icon" type="image/png" href="/logo.png">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #E8F5E9;
            color: #333;
            overflow-x: hidden;
        }
        
        /* Navbar */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }
        .navbar-brand {
            font-weight: 800;
            color: #1B5E20 !important;
            font-size: 1.5rem;
        }
        .nav-link {
            font-weight: 500;
            color: #1B5E20 !important;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            color: #66BB6A !important;
        }
        .btn-login {
            background: linear-gradient(135deg, #1B5E20, #66BB6A);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(27, 94, 32, 0.3);
            color: white;
        }

        /* Hero Section */
        .hero-section {
            padding: 120px 0 80px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #E8F5E9 0%, #ffffff 100%);
            position: relative;
        }
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: #1B5E20;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }
        .hero-subtitle {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        .hero-icon {
            font-size: 15rem;
            color: #66BB6A;
            opacity: 0.8;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        /* Features Section */
        .features-section {
            padding: 80px 0;
            background-color: #ffffff;
        }
        .feature-card {
            padding: 2rem;
            border-radius: 1rem;
            background: #E8F5E9;
            border: none;
            transition: all 0.3s ease;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(27, 94, 32, 0.1);
        }
        .feature-icon {
            font-size: 2.5rem;
            color: #1B5E20;
            margin-bottom: 1.5rem;
        }
        .feature-title {
            font-weight: 700;
            color: #1B5E20;
            margin-bottom: 1rem;
        }

        /* Footer */
        .footer {
            background-color: #1B5E20;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        .footer p {
            margin: 0;
            opacity: 0.9;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fa-solid fa-prescription-bottle-medical me-2"></i>AMS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link me-3" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-login">Masuk Dasbor</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-login">Login Apoteker</a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-2 order-lg-1 mt-5 mt-lg-0">
                    <h1 class="hero-title">Kelola Apotek Lebih Mudah & Cerdas</h1>
                    <p class="hero-subtitle">
                        Apotek Management System (AMS) membantu Anda memantau stok obat, mencatat transaksi masuk & keluar, serta menganalisis pergerakan obat secara real-time.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('login') }}" class="btn btn-login px-4 py-3 fs-5">
                            Mulai Sekarang <i class="fa-solid fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 text-center">
                    <i class="fa-solid fa-pills hero-icon"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: #1B5E20;">Fitur Unggulan</h2>
                <p class="text-muted">Semua yang Anda butuhkan untuk operasional apotek</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="fa-solid fa-boxes-stacked feature-icon"></i>
                        <h4 class="feature-title">Manajemen Stok</h4>
                        <p class="text-muted mb-0">Pantau ketersediaan obat secara real-time. Dapatkan peringatan otomatis saat stok menipis.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="fa-solid fa-chart-pie feature-icon"></i>
                        <h4 class="feature-title">Analisis Cerdas</h4>
                        <p class="text-muted mb-0">Ketahui obat mana yang paling cepat terjual (Fast Moving) dan yang menumpuk (Slow Moving).</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="fa-solid fa-file-pdf feature-icon"></i>
                        <h4 class="feature-title">Laporan Otomatis</h4>
                        <p class="text-muted mb-0">Cetak struk transaksi dan ekspor laporan bulanan ke format Excel atau PDF dengan satu klik.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} Apotek Management System. All rights reserved.</p>
            <p class="mt-2 small" style="opacity: 0.7;">Copyright by nhmedia-tech</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>