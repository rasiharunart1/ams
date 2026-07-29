<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMS — Apotek Management System (Glassmorphism Edition)</title>
    <meta name="description" content="Sistem Manajemen Apotek (AMS) berdesain Glassmorphism futuristik. Pemantauan stok real-time, analisis fast/slow moving, dan laporan transaksi otomatis.">
    <link rel="icon" type="image/png" href="/logo.png">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6.4.2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --glass-bg: rgba(255, 255, 255, 0.07);
            --glass-bg-hover: rgba(255, 255, 255, 0.12);
            --glass-bg-active: rgba(255, 255, 255, 0.16);
            --glass-border: rgba(255, 255, 255, 0.16);
            --glass-border-hover: rgba(52, 211, 153, 0.6);
            --glass-border-specular: rgba(255, 255, 255, 0.35);
            --glass-blur: blur(24px);
            --glass-shadow: 0 20px 50px rgba(0, 0, 0, 0.45);
            --glass-shadow-sm: 0 10px 30px rgba(0, 0, 0, 0.35);
            --emerald-neon: #34d399;
            --cyan-neon: #22d3ee;
            --violet-neon: #a78bfa;
            --amber-neon: #fbbf24;
            --dark-bg: #030816;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background-color: var(--dark-bg);
            color: #f1f5f9;
            overflow-x: hidden;
            position: relative;
            min-height: 100vh;
        }

        /* --- AURORA GLOWING ORBS (For True Glassmorphism Refraction) --- */
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
            filter: blur(80px);
            opacity: 0.55;
            animation: orbFloat 14s ease-in-out infinite alternate;
        }
        .orb-1 {
            width: 650px; height: 650px;
            background: radial-gradient(circle, #059669 0%, rgba(5, 150, 105, 0) 70%);
            top: -150px; left: -150px;
            animation-delay: 0s;
        }
        .orb-2 {
            width: 550px; height: 550px;
            background: radial-gradient(circle, #0284c7 0%, rgba(2, 132, 199, 0) 70%);
            top: 35%; right: -150px;
            animation-delay: -4s;
        }
        .orb-3 {
            width: 700px; height: 700px;
            background: radial-gradient(circle, #4c1d95 0%, rgba(76, 29, 149, 0) 70%);
            bottom: -200px; left: 15%;
            animation-delay: -8s;
        }
        .orb-4 {
            width: 450px; height: 450px;
            background: radial-gradient(circle, #10b981 0%, rgba(16, 185, 129, 0) 70%);
            top: 65%; right: 20%;
            animation-delay: -2s;
        }

        @keyframes orbFloat {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(40px, -40px) scale(1.15); }
            100% { transform: translate(-30px, 30px) scale(0.95); }
        }

        /* --- GLASS CORE UTILITIES --- */
        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            border-top: 1px solid var(--glass-border-specular);
            box-shadow: var(--glass-shadow);
        }
        .glass-panel-sm {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-top: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: var(--glass-shadow-sm);
        }

        /* --- NAVBAR GLASSMORPHISM --- */
        .navbar-custom {
            background: rgba(3, 8, 22, 0.65);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 1.1rem 0;
            z-index: 1030;
        }
        .navbar-custom.scrolled {
            padding: 0.75rem 0;
            background: rgba(3, 8, 22, 0.85);
            border-bottom-color: rgba(52, 211, 153, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        .navbar-brand {
            font-weight: 800;
            color: #ffffff !important;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }
        .brand-logo-glass {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, rgba(52, 211, 153, 0.25), rgba(34, 211, 238, 0.15));
            border: 1px solid rgba(52, 211, 153, 0.5);
            color: var(--emerald-neon);
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            box-shadow: 0 0 20px rgba(52, 211, 153, 0.3);
        }
        .nav-link {
            font-weight: 600;
            color: #cbd5e1 !important;
            font-size: 0.95rem;
            padding: 0.5rem 1.1rem !important;
            transition: all 0.25s ease;
            border-radius: 12px;
        }
        .nav-link:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.08);
            text-shadow: 0 0 12px rgba(52, 211, 153, 0.6);
        }

        /* --- DEV PILL IN NAVBAR --- */
        .dev-badge-glass {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.45rem 1rem;
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(52, 211, 153, 0.35);
            border-radius: 50px;
            color: #a7f3d0;
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(52, 211, 153, 0.15);
        }
        .dev-badge-glass:hover {
            background: rgba(52, 211, 153, 0.15);
            border-color: var(--emerald-neon);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 0 25px rgba(52, 211, 153, 0.4);
        }

        /* --- BUTTONS GLASS --- */
        .btn-glass-primary {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.85), rgba(5, 150, 105, 0.85));
            backdrop-filter: blur(12px);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 50px;
            padding: 0.7rem 1.85rem;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.35);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
        }
        .btn-glass-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(52, 211, 153, 0.6);
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.95), rgba(5, 150, 105, 0.95));
            color: #ffffff;
            border-color: #ffffff;
        }

        .btn-glass-outline {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            color: #f1f5f9;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-top: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 50px;
            padding: 0.7rem 1.7rem;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
        }
        .btn-glass-outline:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: var(--emerald-neon);
            color: #ffffff;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(52, 211, 153, 0.25);
        }

        /* --- HERO TOP BADGE GLASS --- */
        .hero-top-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.55rem 1.2rem;
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(52, 211, 153, 0.35);
            border-top: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 50px;
            font-size: 0.88rem;
            font-weight: 700;
            color: #e2e8f0;
            text-decoration: none;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }
        .hero-top-badge:hover {
            transform: translateY(-3px);
            border-color: var(--emerald-neon);
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 12px 30px rgba(52, 211, 153, 0.3);
            color: #ffffff;
        }
        .badge-pulse-dot {
            width: 8px;
            height: 8px;
            background-color: var(--emerald-neon);
            border-radius: 50%;
            position: relative;
        }
        .badge-pulse-dot::after {
            content: '';
            position: absolute;
            top: -4px; left: -4px;
            width: 16px; height: 16px;
            background-color: var(--emerald-neon);
            border-radius: 50%;
            opacity: 0.5;
            animation: pulseNeon 2s infinite;
        }
        @keyframes pulseNeon {
            0% { transform: scale(1); opacity: 0.7; }
            70% { transform: scale(1.7); opacity: 0; }
            100% { transform: scale(1); opacity: 0; }
        }

        /* --- HERO SECTION --- */
        .hero-section {
            padding: 170px 0 110px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            z-index: 2;
        }
        .hero-title {
            font-size: 3.75rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.15;
            letter-spacing: -1.5px;
            margin-bottom: 1.6rem;
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        .hero-title .gradient-text-neon {
            background: linear-gradient(135deg, #34d399 0%, #22d3ee 50%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 20px rgba(52, 211, 153, 0.3));
        }
        .hero-subtitle {
            font-size: 1.2rem;
            color: #94a3b8;
            margin-bottom: 2.5rem;
            line-height: 1.75;
            font-weight: 400;
        }

        /* --- GLASS DASHBOARD MOCKUP --- */
        .mockup-wrapper {
            position: relative;
            padding: 1rem;
        }
        .mockup-window-glass {
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-top: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 28px;
            padding: 1.85rem;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.65), 0 0 40px rgba(52, 211, 153, 0.1);
            position: relative;
            z-index: 2;
            overflow: hidden;
        }
        .mockup-window-glass::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0) 50%);
            pointer-events: none;
        }
        .mockup-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 1.1rem;
            margin-bottom: 1.6rem;
        }
        .mockup-dots {
            display: flex;
            gap: 7px;
        }
        .mockup-dot {
            width: 12px; height: 12px;
            border-radius: 50%;
            box-shadow: 0 0 8px rgba(0,0,0,0.4);
        }
        .dot-red { background: #ff5f56; }
        .dot-yellow { background: #ffbd2e; }
        .dot-green { background: #27c93f; }

        .glass-stat-card-mini {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-top: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 20px;
            padding: 1.25rem;
            height: 100%;
            transition: all 0.3s ease;
        }
        .glass-stat-card-mini:hover {
            background: rgba(255, 255, 255, 0.09);
            border-color: rgba(52, 211, 153, 0.5);
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        /* --- FLOATING GLASS PILL CARDS --- */
        .floating-glass-pill {
            position: absolute;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(52, 211, 153, 0.4);
            border-top: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 20px;
            padding: 0.95rem 1.25rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6), 0 0 20px rgba(52, 211, 153, 0.2);
            display: flex;
            align-items: center;
            gap: 1rem;
            z-index: 5;
            animation: floatGlass 7s ease-in-out infinite;
        }
        .float-top-right {
            top: -20px; right: -15px;
            animation-delay: 0s;
        }
        .float-bottom-left {
            bottom: -20px; left: -15px;
            animation-delay: -3.5s;
        }
        @keyframes floatGlass {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-14px) rotate(1deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        /* --- STATS RIBBON GLASS --- */
        .stats-ribbon-glass {
            padding: 60px 0;
            position: relative;
            z-index: 2;
        }
        .stat-box-glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            padding: 2rem 1.5rem;
            text-align: center;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: var(--glass-shadow-sm);
        }
        .stat-box-glass:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--emerald-neon);
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(52, 211, 153, 0.25);
        }
        .stat-num-neon {
            font-size: 2.75rem;
            font-weight: 800;
            background: linear-gradient(135deg, #34d399 0%, #22d3ee 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.35rem;
        }

        /* --- FEATURES SECTION GLASS --- */
        .features-section-glass {
            padding: 110px 0;
            position: relative;
            z-index: 2;
        }
        .section-tag-glass {
            display: inline-block;
            padding: 0.45rem 1.1rem;
            background: rgba(52, 211, 153, 0.15);
            border: 1px solid rgba(52, 211, 153, 0.4);
            color: var(--emerald-neon);
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 1rem;
            backdrop-filter: blur(12px);
        }
        .section-title-glass {
            font-size: 2.85rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -1px;
            margin-bottom: 1.1rem;
        }
        .section-subtitle-glass {
            font-size: 1.12rem;
            color: #94a3b8;
            max-width: 620px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* --- BENTO GLASS FEATURE CARDS --- */
        .feature-card-glass {
            padding: 2.5rem 2.2rem;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-top: 1px solid rgba(255, 255, 255, 0.32);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            position: relative;
            overflow: hidden;
            box-shadow: var(--glass-shadow-sm);
        }
        .feature-card-glass::before {
            content: '';
            position: absolute;
            top: -100px; right: -100px;
            width: 220px; height: 220px;
            background: radial-gradient(circle, rgba(52, 211, 153, 0.15) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            transition: all 0.4s ease;
        }
        .feature-card-glass:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.11);
            border-color: rgba(52, 211, 153, 0.55);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6), 0 0 30px rgba(52, 211, 153, 0.2);
        }
        .feature-icon-glass {
            width: 68px;
            height: 68px;
            border-radius: 20px;
            background: rgba(52, 211, 153, 0.15);
            border: 1px solid rgba(52, 211, 153, 0.4);
            color: var(--emerald-neon);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1.85rem;
            transition: all 0.35s ease;
            box-shadow: 0 0 20px rgba(52, 211, 153, 0.2);
        }
        .feature-card-glass:hover .feature-icon-glass {
            background: linear-gradient(135deg, var(--emerald-neon), var(--cyan-neon));
            color: #030816;
            transform: scale(1.1) rotate(-5deg);
            box-shadow: 0 0 30px rgba(52, 211, 153, 0.6);
        }
        .feature-title-glass {
            font-weight: 700;
            font-size: 1.3rem;
            color: #ffffff;
            margin-bottom: 0.85rem;
        }
        .feature-desc-glass {
            color: #94a3b8;
            font-size: 0.98rem;
            line-height: 1.65;
            margin-bottom: 0;
        }

        /* --- DEVELOPER SHOWCASE GLASS CARD --- */
        .developer-section-glass {
            padding: 100px 0;
            position: relative;
            z-index: 2;
        }
        .developer-card-glass {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(35px);
            -webkit-backdrop-filter: blur(35px);
            border: 1px solid rgba(52, 211, 153, 0.45);
            border-top: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 36px;
            padding: 3.8rem;
            color: #ffffff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.7), 0 0 50px rgba(52, 211, 153, 0.18);
        }
        .developer-card-glass::after {
            content: '';
            position: absolute;
            bottom: -150px; right: -150px;
            width: 450px; height: 450px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(52, 211, 153, 0.22) 0%, rgba(0,0,0,0) 70%);
            pointer-events: none;
        }
        .dev-avatar-glass {
            width: 95px;
            height: 95px;
            border-radius: 26px;
            background: linear-gradient(135deg, #34d399, #22d3ee);
            color: #030816;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.35rem;
            font-weight: 800;
            box-shadow: 0 0 35px rgba(52, 211, 153, 0.5);
            border: 2px solid rgba(255, 255, 255, 0.6);
        }
        .dev-role-pill-glass {
            display: inline-block;
            padding: 0.4rem 1rem;
            background: rgba(52, 211, 153, 0.18);
            border: 1px solid rgba(52, 211, 153, 0.5);
            border-radius: 50px;
            color: var(--emerald-neon);
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            box-shadow: 0 0 15px rgba(52, 211, 153, 0.2);
        }
        .btn-glass-portfolio {
            background: linear-gradient(135deg, #ffffff, #e2e8f0);
            color: #030816;
            font-weight: 700;
            border-radius: 50px;
            padding: 0.85rem 2.2rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3), 0 0 20px rgba(255, 255, 255, 0.4);
        }
        .btn-glass-portfolio:hover {
            background: linear-gradient(135deg, #34d399, #22d3ee);
            color: #030816;
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(52, 211, 153, 0.6);
        }

        /* --- FOOTER GLASS --- */
        .footer-glass {
            background: rgba(3, 8, 22, 0.85);
            backdrop-filter: blur(24px);
            color: #94a3b8;
            padding: 4.5rem 0 2.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            position: relative;
            z-index: 2;
        }
        .footer-link-glass {
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .footer-link-glass:hover {
            color: var(--emerald-neon);
            text-shadow: 0 0 10px rgba(52, 211, 153, 0.5);
        }
        .portfolio-credit-glass {
            color: var(--emerald-neon);
            font-weight: 700;
            text-decoration: none;
            transition: all 0.25s ease;
        }
        .portfolio-credit-glass:hover {
            color: var(--cyan-neon);
            text-decoration: underline;
            text-shadow: 0 0 15px rgba(34, 211, 238, 0.6);
        }

        /* Responsive Tweaks */
        @media (max-width: 991px) {
            .hero-title { font-size: 2.85rem; }
            .hero-section { padding: 140px 0 70px; }
            .developer-card-glass { padding: 2.5rem 1.75rem; }
            .float-top-right, .float-bottom-left { display: none; }
        }
    </style>
</head>
<body>

    <!-- AURORA GLOWING MESH BACKGROUND -->
    <div class="aurora-container">
        <div class="aurora-orb orb-1"></div>
        <div class="aurora-orb orb-2"></div>
        <div class="aurora-orb orb-3"></div>
        <div class="aurora-orb orb-4"></div>
    </div>

    <!-- GLASS NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <span class="brand-logo-glass">
                    <i class="fa-solid fa-prescription-bottle-medical"></i>
                </span>
                <span>AMS <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50 fs-6 py-1 px-2 rounded-pill ms-1">Glassmo</span></span>
            </a>

            <button class="navbar-toggler border-0 shadow-none text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars fs-4"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur Unggulan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#developer">Tentang Developer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#stats">Statistik</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <!-- Nav Developer Portfolio Link -->
                    <a href="{{ config('app.developer_url', 'https://harunarrasyid.vercel.app') }}" target="_blank" rel="noopener noreferrer" class="dev-badge-glass d-none d-md-inline-flex" title="Kunjungi Website Pengembang">
                        <i class="fa-solid fa-code" style="color: #34d399;"></i>
                        <span>{{ config('app.developer_name', 'nhmedia technology') }}</span>
                        <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.7rem;"></i>
                    </a>

                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-glass-primary">
                            <i class="fa-solid fa-gauge-high"></i> Masuk Dasbor
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-glass-primary">
                            <i class="fa-solid fa-right-to-bracket"></i> Login Apoteker
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- GLASS HERO SECTION -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <!-- Left Column: Copy & CTAs -->
                <div class="col-lg-6">
                    <!-- Animated Developer Badge Top -->
                    <a href="{{ config('app.developer_url', 'https://harunarrasyid.vercel.app') }}" target="_blank" rel="noopener noreferrer" class="hero-top-badge">
                        <span class="badge-pulse-dot"></span>
                        <span>✨ Powered by <strong style="color: #34d399;">{{ config('app.developer_name', 'nhmedia technology') }}</strong></span>
                        <i class="fa-solid fa-arrow-right ms-1" style="font-size: 0.75rem;"></i>
                    </a>

                    <h1 class="hero-title">
                        Sistem Apotek Modern dengan <span class="gradient-text-neon">Real-Time Glassmo UI</span>
                    </h1>
                    <p class="hero-subtitle">
                        Apotek Management System (AMS) menghadirkan antarmuka transparan berdesain Glassmorphism futuristik untuk monitoring stok obat, transaksi keluar-masuk, serta analitik cerdas.
                    </p>

                    <div class="d-flex flex-wrap gap-3 align-items-center">
                        <a href="{{ route('login') }}" class="btn-glass-primary py-3 px-4 fs-6">
                            <span>Mulai Kelola Apotek</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>

                        <a href="#developer" class="btn-glass-outline py-3 px-4 fs-6">
                            <i class="fa-solid fa-user-check" style="color: #34d399;"></i>
                            <span>Profil Developer</span>
                        </a>
                    </div>

                    <!-- Highlight Badges below CTA -->
                    <div class="d-flex align-items-center gap-4 mt-5 pt-3 border-top" style="border-color: rgba(255, 255, 255, 0.12) !important;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check fs-5" style="color: #34d399;"></i>
                            <span class="small fw-semibold text-light">100% Real-Time Stock</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-shield-halved fs-5" style="color: #34d399;"></i>
                            <span class="small fw-semibold text-light">Keamanan Multi-Role</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Frosted Glass Dashboard Mockup -->
                <div class="col-lg-6">
                    <div class="mockup-wrapper">
                        <!-- Floating Glass Card Top Right -->
                        <div class="floating-glass-pill float-top-right">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 44px; height: 44px; background: rgba(52, 211, 153, 0.2); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.4);">
                                <i class="fa-solid fa-chart-line fs-6"></i>
                            </div>
                            <div>
                                <div class="small fw-bold text-white">Fast Moving Item</div>
                                <div class="text-info" style="font-size: 0.75rem;">Paracetamol 500mg (+24%)</div>
                            </div>
                        </div>

                        <!-- Floating Glass Card Bottom Left -->
                        <div class="floating-glass-pill float-bottom-left">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 44px; height: 44px; background: rgba(251, 191, 36, 0.2); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.4);">
                                <i class="fa-solid fa-bell fs-6"></i>
                            </div>
                            <div>
                                <div class="small fw-bold text-white">Notifikasi Stok</div>
                                <div class="text-warning" style="font-size: 0.75rem;">Amoxicillin hampir habis</div>
                            </div>
                        </div>

                        <!-- Main Glass Window Mockup -->
                        <div class="mockup-window-glass">
                            <div class="mockup-header">
                                <div class="mockup-dots">
                                    <span class="mockup-dot dot-red"></span>
                                    <span class="mockup-dot dot-yellow"></span>
                                    <span class="mockup-dot dot-green"></span>
                                </div>
                                <span class="badge rounded-pill px-3 py-1" style="background: rgba(52, 211, 153, 0.2); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.4);">
                                    <i class="fa-solid fa-circle me-1" style="font-size: 6px;"></i> Live Glassmo Feed
                                </span>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <div class="glass-stat-card-mini">
                                        <div class="text-light text-opacity-75 small mb-1">Total Item Obat</div>
                                        <div class="fs-3 fw-bold text-white">1,248</div>
                                        <div class="small fw-semibold mt-1" style="color: #34d399;">
                                            <i class="fa-solid fa-arrow-up"></i> +12 item baru
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="glass-stat-card-mini">
                                        <div class="text-light text-opacity-75 small mb-1">Stok Masuk Hari Ini</div>
                                        <div class="fs-3 fw-bold text-white">342 <span class="fs-6 fw-normal text-light text-opacity-75">unit</span></div>
                                        <div class="small fw-semibold mt-1" style="color: #22d3ee;">
                                            <i class="fa-solid fa-check"></i> Terverifikasi
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Simulated Translucent Table Strip -->
                            <div class="rounded-4 p-3" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12);">
                                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom" style="border-color: rgba(255, 255, 255, 0.1) !important;">
                                    <span class="small fw-bold text-white">Aktivitas Stok Terkini</span>
                                    <span class="badge border small" style="background: rgba(255, 255, 255, 0.1); color: #fff;">Real-time</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between py-2 border-bottom" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge p-2 rounded-2" style="background: rgba(52, 211, 153, 0.2); color: #34d399;"><i class="fa-solid fa-arrow-down"></i></span>
                                        <div>
                                            <div class="small fw-bold text-white mb-0">Stok Masuk #IN-089</div>
                                            <div class="text-light text-opacity-50" style="font-size: 0.72rem;">Omeperazole 20mg</div>
                                        </div>
                                    </div>
                                    <span class="small fw-bold" style="color: #34d399;">+50 Box</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between py-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge p-2 rounded-2" style="background: rgba(248, 113, 113, 0.2); color: #f87171;"><i class="fa-solid fa-arrow-up"></i></span>
                                        <div>
                                            <div class="small fw-bold text-white mb-0">Stok Keluar #OUT-142</div>
                                            <div class="text-light text-opacity-50" style="font-size: 0.72rem;">Cetirizine 10mg</div>
                                        </div>
                                    </div>
                                    <span class="small fw-bold text-danger">-15 Strip</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- GLASS STATS RIBBON -->
    <section id="stats" class="stats-ribbon-glass">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="stat-box-glass">
                        <div class="stat-num-neon">99.9%</div>
                        <div class="text-light text-opacity-75 small fw-semibold">Akurasi Pencatatan Stok</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-box-glass">
                        <div class="stat-num-neon">Real-Time</div>
                        <div class="text-light text-opacity-75 small fw-semibold">Monitoring Transaksi</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-box-glass">
                        <div class="stat-num-neon">1-Click</div>
                        <div class="text-light text-opacity-75 small fw-semibold">Export PDF & Excel</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-box-glass">
                        <div class="stat-num-neon">24/7</div>
                        <div class="text-light text-opacity-75 small fw-semibold">Akses Aman Kapan Saja</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- GLASS FEATURES SECTION (BENTO GLASSMO GRID) -->
    <section id="features" class="features-section-glass">
        <div class="container">
            <div class="text-center mb-5 pb-3">
                <span class="section-tag-glass">Keunggulan AMS</span>
                <h2 class="section-title-glass">Solusi Lengkap Manajemen Apotek</h2>
                <p class="section-subtitle-glass">
                    Dirancang dengan antarmuka kaca frosted transparan (Glassmorphism) agar apoteker dapat memantau ketersediaan obat dan laporan secara nyaman dan mewah.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card-glass">
                        <div class="feature-icon-glass">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <h4 class="feature-title-glass">Manajemen Stok Real-Time</h4>
                        <p class="feature-desc-glass">
                            Pantau jumlah obat, tanggal kadaluarsa, serta riwayat masuk dan keluar obat secara real-time dalam antarmuka transparan.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card-glass">
                        <div class="feature-icon-glass">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <h4 class="feature-title-glass">Analisis Fast & Slow Moving</h4>
                        <p class="feature-desc-glass">
                            Ketahui produk obat yang paling cepat laris dan yang bergerak lambat untuk strategi pengadaan yang tepat sasaran.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card-glass">
                        <div class="feature-icon-glass">
                            <i class="fa-solid fa-bell"></i>
                        </div>
                        <h4 class="feature-title-glass">Peringatan Stok Menipis</h4>
                        <p class="feature-desc-glass">
                            Dapatkan notifikasi otomatis untuk item dengan stok di bawah ambang batas agar apotek tidak pernah kehabisan stok.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card-glass">
                        <div class="feature-icon-glass">
                            <i class="fa-solid fa-file-invoice"></i>
                        </div>
                        <h4 class="feature-title-glass">Cetak Struk & Bukti Resmi</h4>
                        <p class="feature-desc-glass">
                            Buat tanda terima transaksi stok masuk dan keluar secara instan lengkap dengan detail nomor batch dan otorisasi.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card-glass">
                        <div class="feature-icon-glass">
                            <i class="fa-solid fa-file-export"></i>
                        </div>
                        <h4 class="feature-title-glass">Export Excel & PDF</h4>
                        <p class="feature-desc-glass">
                            Rekapitulasi seluruh laporan transaksi dan pergerakan inventory siap diunduh ke format PDF maupun spreadsheet Excel.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card-glass">
                        <div class="feature-icon-glass">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <h4 class="feature-title-glass">Hak Akses Multi-Role</h4>
                        <p class="feature-desc-glass">
                            Kontrol otorisasi terpisah untuk Superadmin dan Apoteker, menjamin integritas data serta keamanan operasional apotek.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- DEVELOPER SHOWCASE GLASS CARD -->
    <section id="developer" class="developer-section-glass">
        <div class="container">
            <div class="developer-card-glass">
                <div class="row align-items-center g-4">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="dev-role-pill-glass">
                                <i class="fa-solid fa-code me-1"></i> Software & Technology Solution
                            </span>
                            <span class="badge rounded-pill px-3 py-1 small" style="background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.2);">
                                Glassmo UI Edition
                            </span>
                        </div>

                        <h2 class="fw-bold display-6 mb-3 text-white">
                            Dikembangkan oleh <br>
                            <span style="color: #34d399; text-shadow: 0 0 25px rgba(52, 211, 153, 0.6);">{{ config('app.developer_name', 'nhmedia technology') }}</span>
                        </h2>

                        <p class="text-light text-opacity-75 mb-4 lead" style="max-width: 650px; font-size: 1.05rem;">
                            AMS (Apotek Management System) dikembangkan oleh tim nhmedia technology dengan fokus pada antarmuka Glassmorphism yang elegan serta keandalan sistem apotek modern.
                        </p>

                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <a href="{{ config('app.developer_url', 'https://harunarrasyid.vercel.app') }}" target="_blank" rel="noopener noreferrer" class="btn-glass-portfolio">
                                <i class="fa-solid fa-globe"></i>
                                <span>Kunjungi Website Pengembang</span>
                                <i class="fa-solid fa-arrow-up-right-from-square small"></i>
                            </a>

                            <a href="{{ config('app.developer_url', 'https://harunarrasyid.vercel.app') }}" target="_blank" rel="noopener noreferrer" class="text-white text-decoration-none fw-semibold d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.25); backdrop-filter: blur(12px);">
                                <i class="fa-solid fa-link" style="color: #34d399;"></i>
                                <span>{{ config('app.developer_name', 'nhmedia technology') }}</span>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 text-center text-lg-end">
                        <div class="d-inline-flex flex-column align-items-center justify-content-center p-4 rounded-4" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.18); backdrop-filter: blur(20px);">
                            <div class="dev-avatar-glass mb-3">
                                <span>NH</span>
                            </div>
                            <h5 class="fw-bold text-white mb-1">{{ config('app.developer_name', 'nhmedia technology') }}</h5>
                            <p class="text-light text-opacity-75 small mb-3">Software & Web Technology Solution</p>
                            <a href="{{ config('app.developer_url', 'https://harunarrasyid.vercel.app') }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm text-white rounded-pill px-3 py-1 fw-semibold" style="background: rgba(52,211,153,0.25); border: 1px solid rgba(52,211,153,0.5);">
                                Kunjungi Website <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- GLASS FOOTER -->
    <footer class="footer-glass">
        <div class="container">
            <div class="row g-4 justify-content-between mb-5">
                <div class="col-lg-5">
                    <a href="#" class="navbar-brand mb-3 d-inline-block">
                        <span class="brand-logo-glass" style="width: 38px; height: 38px; font-size: 1.1rem;">
                            <i class="fa-solid fa-prescription-bottle-medical"></i>
                        </span>
                        <span>AMS</span>
                    </a>
                    <p class="text-light text-opacity-75 small mb-3" style="max-width: 380px;">
                        Apotek Management System — Solusi pencatatan, pemantauan stok real-time, serta pelaporan transaksi berdesain Glassmorphism futuristik.
                    </p>
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ config('app.developer_url', 'https://harunarrasyid.vercel.app') }}" target="_blank" rel="noopener noreferrer" class="badge text-light text-decoration-none px-3 py-2 rounded-pill" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(52,211,153,0.4);">
                            <i class="fa-solid fa-laptop-code me-1" style="color: #34d399;"></i> {{ config('app.developer_name', 'nhmedia technology') }}
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <h6 class="text-white fw-bold mb-3">Navigasi</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2 small">
                        <li><a href="#features" class="footer-link-glass">Fitur Unggulan</a></li>
                        <li><a href="#stats" class="footer-link-glass">Statistik Sistem</a></li>
                        <li><a href="#developer" class="footer-link-glass">Tentang Pengembang</a></li>
                        <li><a href="{{ route('login') }}" class="footer-link-glass">Login Apoteker</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-6">
                    <h6 class="text-white fw-bold mb-3">Developer & Solution</h6>
                    <p class="small text-light text-opacity-75 mb-2">
                        Ingin bekerja sama atau melihat solusi lainnya?
                    </p>
                    <a href="{{ config('app.developer_url', 'https://harunarrasyid.vercel.app') }}" target="_blank" rel="noopener noreferrer" class="portfolio-credit-glass d-inline-flex align-items-center gap-2 small">
                        <span>{{ config('app.developer_name', 'nhmedia technology') }}</span>
                        <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.75rem;"></i>
                    </a>
                </div>
            </div>

            <div class="border-top pt-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3" style="border-color: rgba(255, 255, 255, 0.1) !important;">
                <p class="small text-light text-opacity-75 mb-0">
                    &copy; {{ date('Y') }} <strong>Apotek Management System (AMS)</strong>. All rights reserved.
                </p>
                <p class="small text-light text-opacity-75 mb-0">
                    Crafted with <i class="fa-solid fa-heart text-danger"></i> by 
                    <a href="{{ config('app.developer_url', 'https://harunarrasyid.vercel.app') }}" target="_blank" rel="noopener noreferrer" class="portfolio-credit-glass">
                        {{ config('app.developer_name', 'nhmedia technology') }}
                    </a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Glass Navbar transition on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 20) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>