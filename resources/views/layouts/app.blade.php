<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AMS — Apotek Management System (Glassmorphism)</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom AMS Glassmorphism & Dark Mode CSS -->
    <style>
        :root, [data-theme="dark"] {
            --primary-color: #10b981;
            --secondary-color: #34d399;
            --bg-color: #030816;
            --sidebar-bg: rgba(15, 23, 42, 0.65);
            --sidebar-hover: rgba(52, 211, 153, 0.15);
            --sidebar-color: #f1f5f9;
            --topbar-bg: rgba(15, 23, 42, 0.65);
            --card-bg: rgba(15, 23, 42, 0.55);
            --card-bg-hover: rgba(15, 23, 42, 0.75);
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border-color: rgba(255, 255, 255, 0.14);
            --border-specular: rgba(255, 255, 255, 0.28);
            --shadow-sm: 0 4px 15px rgba(0, 0, 0, 0.35);
            --shadow-md: 0 15px 35px rgba(0, 0, 0, 0.55);
            --dropdown-bg: rgba(15, 23, 42, 0.85);
            --glass-blur: blur(24px);
            --input-bg: rgba(0, 0, 0, 0.25);
            --table-head-bg: rgba(255, 255, 255, 0.06);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-theme="light"] {
            --primary-color: #059669;
            --secondary-color: #10b981;
            --bg-color: #f0fdf4;
            --sidebar-bg: rgba(255, 255, 255, 0.75);
            --sidebar-hover: rgba(16, 185, 129, 0.12);
            --sidebar-color: #0f172a;
            --topbar-bg: rgba(255, 255, 255, 0.75);
            --card-bg: rgba(255, 255, 255, 0.75);
            --card-bg-hover: rgba(255, 255, 255, 0.92);
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: rgba(226, 232, 240, 0.8);
            --border-specular: #ffffff;
            --shadow-sm: 0 4px 15px rgba(16, 185, 129, 0.08);
            --shadow-md: 0 15px 35px rgba(16, 185, 129, 0.15);
            --dropdown-bg: rgba(255, 255, 255, 0.92);
            --glass-blur: blur(20px);
            --input-bg: rgba(255, 255, 255, 0.6);
            --table-head-bg: rgba(0, 0, 0, 0.03);
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            overflow-x: hidden;
            transition: var(--transition);
            min-height: 100vh;
            position: relative;
        }

        /* --- AURORA MESH GLOW BACKGROUND --- */
        .aurora-container {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            overflow: hidden;
            z-index: -1;
            pointer-events: none;
        }

        /* --- BOOTSTRAP MODAL STACKING FIX --- */
        .modal {
            z-index: 1060 !important;
        }
        .modal-backdrop {
            z-index: 1050 !important;
        }
        .modal-dialog {
            z-index: 1065 !important;
        }
        .aurora-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(85px);
            opacity: 0.45;
            animation: orbFloat 16s ease-in-out infinite alternate;
        }
        .orb-1 {
            width: 600px; height: 600px;
            background: radial-gradient(circle, #10b981 0%, rgba(16, 185, 129, 0) 70%);
            top: -150px; left: -100px;
        }
        .orb-2 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, #06b6d4 0%, rgba(6, 182, 212, 0) 70%);
            top: 40%; right: -150px;
            animation-delay: -5s;
        }
        .orb-3 {
            width: 650px; height: 650px;
            background: radial-gradient(circle, #8b5cf6 0%, rgba(139, 92, 246, 0) 70%);
            bottom: -200px; left: 20%;
            animation-delay: -10s;
        }

        @keyframes orbFloat {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(45px, -45px) scale(1.12); }
            100% { transform: translate(-30px, 30px) scale(0.95); }
        }

        /* Typography & Utilities */
        a { text-decoration: none; }
        .text-muted-custom, .text-muted { color: var(--text-muted) !important; }
        
        /* --- GLASS CARDS --- */
        .card {
            background: var(--card-bg) !important;
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--border-color) !important;
            border-top: 1px solid var(--border-specular) !important;
            border-radius: 1rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
            color: var(--text-main);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-3px);
            background: var(--card-bg-hover) !important;
            border-color: rgba(52, 211, 153, 0.45) !important;
            box-shadow: var(--shadow-md);
        }
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid var(--border-color);
            font-weight: 700;
            color: var(--text-main);
        }

        /* --- GLASS TABLES (DARK & LIGHT MODE OVERRIDE) --- */
        .table, .table-light, .table-dark, .table-striped, .table-hover, .table-bordered {
            --bs-table-bg: transparent !important;
            --bs-table-accent-bg: transparent !important;
            --bs-table-striped-bg: rgba(255, 255, 255, 0.03) !important;
            --bs-table-hover-bg: var(--sidebar-hover) !important;
            --bs-table-color: var(--text-main) !important;
            --bs-table-border-color: var(--border-color) !important;
            background-color: transparent !important;
            color: var(--text-main) !important;
            border-color: var(--border-color) !important;
            margin-bottom: 0;
        }
        [data-theme="dark"] .table,
        [data-theme="dark"] .table-light,
        [data-theme="dark"] .table-dark,
        [data-theme="dark"] .table-striped,
        [data-theme="dark"] .table-hover,
        [data-theme="dark"] .table-bordered,
        [data-theme="dark"] .table th,
        [data-theme="dark"] .table td,
        [data-theme="dark"] .table tr,
        [data-theme="dark"] .table thead,
        [data-theme="dark"] .table tbody,
        [data-theme="dark"] .table-light th,
        [data-theme="dark"] .table-light td,
        [data-theme="dark"] .table-light tr,
        [data-theme="dark"] .table-light thead {
            background-color: transparent !important;
            color: var(--text-main) !important;
            border-color: var(--border-color) !important;
            --bs-table-bg: transparent !important;
            --bs-table-accent-bg: transparent !important;
        }
        .table thead, .table-light thead, .table-dark thead,
        .table th, .table-light th, .table-dark th {
            border-bottom-width: 1px !important;
            font-weight: 700 !important;
            background: var(--table-head-bg) !important;
            color: var(--text-main) !important;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border-color: var(--border-color) !important;
        }
        .table td, .table th {
            color: var(--text-main) !important;
            border-color: var(--border-color) !important;
            vertical-align: middle;
            background-color: transparent !important;
        }
        .table-hover tbody tr:hover td,
        .table-hover tbody tr:hover th,
        .table-hover tbody tr:hover {
            background-color: var(--sidebar-hover) !important;
            color: var(--text-main) !important;
        }
        .table-responsive {
            background: transparent !important;
        }

        /* --- GLASS MODALS (DARK & LIGHT MODE OVERRIDE) --- */
        .modal-content {
            background: var(--card-bg) !important;
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid var(--border-color) !important;
            border-top: 1px solid var(--border-specular) !important;
            border-radius: 1.25rem !important;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4) !important;
            color: var(--text-main) !important;
        }
        .modal-header {
            border-bottom: 1px solid var(--border-color) !important;
            background: transparent !important;
            color: var(--text-main) !important;
        }
        .modal-footer {
            border-top: 1px solid var(--border-color) !important;
            background: transparent !important;
        }
        .modal-body {
            background: transparent !important;
            color: var(--text-main) !important;
        }
        [data-theme="dark"] .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        /* --- GLASS FORM CONTROLS --- */
        .form-control, .form-select {
            background-color: var(--input-bg) !important;
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-color) !important;
            color: var(--text-main) !important;
            border-radius: 0.65rem;
            transition: all 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            background-color: var(--input-bg) !important;
            border-color: var(--primary-color) !important;
            color: var(--text-main) !important;
            box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25);
        }
        .form-control::placeholder {
            color: var(--text-muted);
            opacity: 0.7;
        }
        .form-select option {
            background-color: var(--bg-color);
            color: var(--text-main);
        }

        /* --- GLASS PAGINATION, DROPDOWNS & LIST GROUPS --- */
        .pagination .page-link {
            background-color: var(--card-bg) !important;
            border-color: var(--border-color) !important;
            color: var(--text-main) !important;
            backdrop-filter: blur(12px);
        }
        .pagination .page-item.active .page-link {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: #fff !important;
        }
        .pagination .page-item.disabled .page-link {
            background-color: transparent !important;
            color: var(--text-muted) !important;
            border-color: var(--border-color) !important;
            opacity: 0.5;
        }
        .dropdown-menu {
            background-color: var(--card-bg) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color) !important;
            box-shadow: var(--shadow-md) !important;
        }
        .dropdown-item {
            color: var(--text-main) !important;
        }
        .dropdown-item:hover, .dropdown-item:focus {
            background-color: var(--sidebar-hover) !important;
            color: var(--primary-color) !important;
        }
        .dropdown-divider {
            border-top-color: var(--border-color) !important;
        }
        .list-group-item {
            background-color: transparent !important;
            border-color: var(--border-color) !important;
            color: var(--text-main) !important;
        }

        /* --- LAYOUT WRAPPER --- */
        #wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* --- GLASS SIDEBAR --- */
        #sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1040;
            box-shadow: var(--shadow-sm);
        }
        #sidebar.collapsed {
            width: 75px;
        }
        #sidebar.collapsed .brand-text,
        #sidebar.collapsed .menu-text,
        #sidebar.collapsed .menu-header {
            display: none;
        }
        #sidebar.collapsed .sidebar-brand {
            justify-content: center;
            padding: 1.25rem 0;
        }
        #sidebar.collapsed .menu-item {
            justify-content: center;
            padding: 0.85rem 0;
        }
        #sidebar.collapsed .menu-icon {
            margin-right: 0;
            font-size: 1.35rem;
        }

        .sidebar-brand {
            padding: 1.35rem 1.5rem;
            display: flex;
            align-items: center;
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--text-main);
            border-bottom: 1px solid var(--border-color);
            letter-spacing: -0.5px;
        }
        .sidebar-brand i {
            color: var(--primary-color);
            filter: drop-shadow(0 0 10px rgba(16, 185, 129, 0.4));
        }

        .sidebar-menu {
            padding: 1rem 0;
            flex: 1;
            overflow-y: auto;
        }

        .menu-header {
            padding: 1.2rem 1.5rem 0.4rem;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            font-weight: 700;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.5rem;
            color: var(--text-main);
            font-weight: 600;
            font-size: 0.92rem;
            transition: all 0.25s ease;
            margin: 0.15rem 0.75rem;
            border-radius: 0.75rem;
        }
        .menu-icon {
            width: 24px;
            margin-right: 12px;
            font-size: 1.1rem;
            text-align: center;
            color: var(--text-muted);
            transition: color 0.25s ease;
        }
        .menu-item:hover {
            background-color: var(--sidebar-hover);
            color: var(--primary-color);
            transform: translateX(3px);
        }
        .menu-item:hover .menu-icon {
            color: var(--primary-color);
        }
        .menu-item.active {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.25), rgba(52, 211, 153, 0.1));
            color: var(--primary-color);
            border: 1px solid rgba(52, 211, 153, 0.35);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.15);
            font-weight: 700;
        }
        .menu-item.active .menu-icon {
            color: var(--primary-color);
        }

        /* --- GLASS TOPBAR --- */
        #content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            width: 0; /* flexbug fix */
        }
        #topbar {
            height: 70px;
            background: var(--topbar-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.75rem;
            z-index: 1030;
            box-shadow: var(--shadow-sm);
        }
        .topbar-left, .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .toggle-btn {
            background: transparent;
            border: none;
            font-size: 1.25rem;
            color: var(--text-main);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: var(--transition);
        }
        .toggle-btn:hover {
            background-color: var(--sidebar-hover);
            color: var(--primary-color);
        }
        .search-box {
            position: relative;
            width: 260px;
        }
        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        .search-box input {
            padding-left: 36px;
            border-radius: 50px;
            background: var(--input-bg) !important;
            border-color: var(--border-color) !important;
            color: var(--text-main) !important;
        }

        .topbar-icon-btn {
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            position: relative;
            cursor: pointer;
            transition: all 0.25s ease;
        }
        .topbar-icon-btn:hover {
            background: var(--sidebar-hover);
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }
        .topbar-icon-btn .badge {
            position: absolute;
            top: -5px; right: -5px;
            font-size: 0.65rem;
        }

        /* --- GLASS DROPDOWNS --- */
        .dropdown-menu {
            background: var(--dropdown-bg) !important;
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid var(--border-color) !important;
            border-top: 1px solid var(--border-specular) !important;
            border-radius: 1rem;
            box-shadow: var(--shadow-md);
            padding: 0.5rem 0;
            color: var(--text-main);
        }
        .dropdown-item {
            color: var(--text-main);
            font-weight: 500;
            padding: 0.65rem 1.25rem;
            transition: all 0.2s ease;
        }
        .dropdown-item:hover {
            background-color: var(--sidebar-hover);
            color: var(--primary-color);
        }
        .dropdown-header {
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.72rem;
            letter-spacing: 0.5px;
        }
        .dropdown-divider {
            border-color: var(--border-color);
        }

        /* --- MAIN PAGE CONTENT --- */
        #main-content {
            flex: 1;
            padding: 1.75rem;
            overflow-y: auto;
            position: relative;
        }

        /* Custom Badges */
        .badge-safe { background-color: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4); }
        .badge-warning { background-color: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); }
        .badge-danger { background-color: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.4); }

        /* --- GLASS STAT CARDS --- */
        .stat-card {
            display: flex;
            align-items: center;
            padding: 1.6rem;
            border-radius: 1.2rem;
        }
        .stat-icon {
            width: 62px;
            height: 62px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.85rem;
            margin-right: 1.1rem;
            transition: all 0.3s ease;
        }
        .stat-icon.primary { background: rgba(16, 185, 129, 0.18); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); }
        .stat-icon.success { background: rgba(34, 211, 238, 0.18); color: #22d3ee; border: 1px solid rgba(34, 211, 238, 0.35); }
        .stat-icon.danger { background: rgba(239, 68, 68, 0.18); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.35); }
        .stat-icon.warning { background: rgba(245, 158, 11, 0.18); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35); }
        .stat-details h3 { margin: 0; font-weight: 800; font-size: 1.65rem; color: var(--text-main); }
        .stat-details p { margin: 0; color: var(--text-muted); font-size: 0.88rem; font-weight: 500; }

        /* Profile Page */
        .profile-header {
            background: linear-gradient(135deg, #064e3b, #059669);
            height: 160px;
            border-radius: 1rem 1rem 0 0;
            position: relative;
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid var(--card-bg);
            position: absolute;
            bottom: -60px;
            left: 30px;
            background-color: #fff;
            object-fit: cover;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }
        .profile-info { padding: 75px 30px 30px 30px; }

        /* Responsive */
        @media (max-width: 768px) {
            #sidebar { position: absolute; height: 100%; transform: translateX(-100%); z-index: 1050; }
            #sidebar.mobile-show { transform: translateX(0); }
            .search-box { display: none; }
        }

        /* Widgets */
        .widget-item { padding: 12px 0; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; }
        .widget-item:last-child { border-bottom: none; }
        .widget-icon { width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; }
        
        /* --- GLASS MODALS --- */
        .modal-content {
            background: var(--dropdown-bg) !important;
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid var(--border-color) !important;
            border-top: 1px solid var(--border-specular) !important;
            border-radius: 1.25rem;
            color: var(--text-main) !important;
            box-shadow: var(--shadow-md);
        }
        .modal-header { border-bottom-color: var(--border-color) !important; }
        .modal-footer { border-top-color: var(--border-color) !important; }

        /* Stat card link hover */
        .stat-card-link { cursor: pointer; }
        a:hover .stat-card-link { box-shadow: 0 12px 35px rgba(16, 185, 129, 0.25); }

        /* Breadcrumb text in dark/light */
        .breadcrumb-item a { color: var(--primary-color); text-decoration: none; font-weight: 600; }
        .breadcrumb-item.active { color: var(--text-muted); }
    </style>
</head>
<body>

<!-- AURORA GLOW BACKGROUND -->
<div class="aurora-container">
    <div class="aurora-orb orb-1"></div>
    <div class="aurora-orb orb-2"></div>
    <div class="aurora-orb orb-3"></div>
</div>

<div id="wrapper">
    <!-- GLASS SIDEBAR -->
    <nav id="sidebar">
        <div class="sidebar-brand">
            <i class="fa-solid fa-prescription-bottle-medical me-2"></i>
            <span class="brand-text">AMS <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50 small ms-1 py-1 px-2 rounded-pill" style="font-size: 0.65rem;">Glassmo</span></span>
        </div>
        <div class="sidebar-menu">
            @if(auth()->user()->role === 'superadmin')
                <a href="{{ route('superadmin.dashboard') }}" class="menu-item {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line menu-icon"></i>
                    <span class="menu-text">Dasbor Superadmin</span>
                </a>
                <div class="menu-header">Manajemen Sistem</div>
                <a href="{{ route('superadmin.users.index') }}" class="menu-item {{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users-gear menu-icon"></i>
                    <span class="menu-text">Kelola Pengguna</span>
                </a>
                <a href="{{ secure_url('log-viewer') }}" target="_blank" class="menu-item">
                    <i class="fa-solid fa-server menu-icon"></i>
                    <span class="menu-text">System Logs</span>
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line menu-icon"></i>
                    <span class="menu-text">Dasbor</span>
                </a>

                <div class="menu-header">Data Master</div>
                <a href="{{ route('products.index') }}" class="menu-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-pills menu-icon"></i>
                    <span class="menu-text">Obat</span>
                </a>
                <a href="{{ route('categories.index') }}" class="menu-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-tags menu-icon"></i>
                    <span class="menu-text">Kategori</span>
                </a>

                <div class="menu-header">Transaksi</div>
                <a href="{{ route('stock-in.index') }}" class="menu-item {{ request()->routeIs('stock-in.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-arrow-right-to-bracket menu-icon"></i>
                    <span class="menu-text">Obat Masuk</span>
                </a>
                <a href="{{ route('stock-out.index') }}" class="menu-item {{ request()->routeIs('stock-out.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-arrow-right-from-bracket menu-icon"></i>
                    <span class="menu-text">Obat Keluar</span>
                </a>

                <div class="menu-header">Pemantauan</div>
                <a href="{{ route('inventory.index') }}" class="menu-item {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-boxes-stacked menu-icon"></i>
                    <span class="menu-text">Stok Obat</span>
                </a>

                <div class="menu-header">Laporan & Analisis</div>
                <a href="{{ route('reports.index') }}" class="menu-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-invoice menu-icon"></i>
                    <span class="menu-text">Semua Laporan</span>
                </a>
                <a href="{{ route('analysis.index') }}" class="menu-item {{ request()->routeIs('analysis.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie menu-icon"></i>
                    <span class="menu-text">Analisis Stok</span>
                </a>
            @endif

            <div class="menu-header">Sistem</div>
            <a href="{{ route('profile.edit') }}" class="menu-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <i class="fa-solid fa-user-doctor menu-icon"></i>
                <span class="menu-text">Profil Saya</span>
            </a>
        </div>
    </nav>

    <!-- CONTENT WRAPPER -->
    <div id="content-wrapper">
        <!-- GLASS TOPBAR -->
        <header id="topbar">
            <div class="topbar-left">
                <button class="toggle-btn" id="sidebarToggle" aria-label="Toggle Sidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" class="form-control form-control-sm" id="globalSearch" placeholder="Cari data...">
                </div>
            </div>
            <div class="topbar-right">
                <!-- DARK MODE / LIGHT MODE TOGGLE BUTTON -->
                <button class="topbar-icon-btn" id="themeToggle" title="Ganti Mode Gelap / Terang">
                    <i class="fa-solid fa-sun text-warning" id="themeIcon"></i>
                </button>

                <!-- FULLSCREEN TOGGLE -->
                <button class="topbar-icon-btn" id="fullscreenToggle" title="Layar Penuh">
                    <i class="fa-solid fa-expand"></i>
                </button>

                <!-- NOTIFICATIONS DROPDOWN -->
                <div class="dropdown">
                    <button class="topbar-icon-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="border:none; background:transparent;">
                        <i class="fa-solid fa-bell"></i>
                        <span class="badge bg-danger rounded-pill" id="notification-count">0</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow" id="notification-dropdown">
                        <li><h6 class="dropdown-header">Notifikasi Stok</h6></li>
                        <div id="notification-items">
                            <li><a class="dropdown-item text-center small text-muted" href="#">Tidak ada notifikasi baru</a></li>
                        </div>
                    </ul>
                </div>

                <!-- USER AVATAR DROPDOWN -->
                <div class="dropdown">
                    <div class="d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="User" class="rounded-circle" width="36" height="36" style="object-fit: cover; border: 2px solid var(--primary-color);">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=10b981&color=fff" alt="User" class="rounded-circle" width="36" height="36" style="border: 2px solid var(--primary-color);">
                        @endif
                        <div class="ms-2 d-none d-md-block">
                            <span class="d-block fw-bold" style="font-size: 0.9rem; color: var(--text-main);">{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fa-solid fa-user me-2"></i>Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger w-100 text-start" style="background:none; border:none;">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i>Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <main id="main-content">
            <!-- Flash Message Container -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); color: var(--text-main); backdrop-filter: blur(12px);">
                    <i class="fa-solid fa-circle-check text-success me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); color: var(--text-main); backdrop-filter: blur(12px);">
                    <i class="fa-solid fa-triangle-exclamation text-danger me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); color: var(--text-main); backdrop-filter: blur(12px);">
                    <i class="fa-solid fa-triangle-exclamation text-danger me-2"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Content Slot -->
            {{ $slot }}

            <!-- Footer -->
            <footer class="mt-auto py-4 text-center small" style="color: var(--text-muted);">
                <hr class="mb-3" style="border-color: var(--border-color);">
                &copy; {{ date('Y') }} <strong>Apotek Management System (AMS)</strong>. All rights reserved.<br>
                Crafted with <i class="fa-solid fa-heart text-danger"></i> by <a href="{{ config('app.developer_url', 'https://harunarrasyid.vercel.app') }}" target="_blank" class="text-decoration-none fw-bold" style="color: #34d399;">{{ config('app.developer_name', 'nhmedia technology') }}</a>
            </footer>
        </main>
    </div>
</div>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS for AMS Glassmo & Theme Toggle -->
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

    // Sidebar Collapse
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    
    // Check saved sidebar state
    const sidebarState = localStorage.getItem('sidebarCollapsed');
    if (sidebarState === 'true') {
        sidebar.classList.add('collapsed');
    }

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('mobile-show');
        }
    });

    // Fullscreen Toggle
    const fullscreenToggle = document.getElementById('fullscreenToggle');
    fullscreenToggle.addEventListener('click', () => {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch(err => {
                console.log(`Error enabling fullscreen: ${err.message}`);
            });
            fullscreenToggle.querySelector('i').className = 'fa-solid fa-compress';
        } else {
            document.exitFullscreen();
            fullscreenToggle.querySelector('i').className = 'fa-solid fa-expand';
        }
    });

    // Close mobile sidebar when clicking outside
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768 && 
            !sidebar.contains(e.target) && 
            !sidebarToggle.contains(e.target) && 
            sidebar.classList.contains('mobile-show')) {
            sidebar.classList.remove('mobile-show');
        }
    });

    // Fetch Low Stock Notifications dynamically via API
    document.addEventListener('DOMContentLoaded', () => {
        fetch('{{ secure_url('api/low-stock-notifications') }}')
            .then(res => res.json())
            .then(data => {
                const countBadge = document.getElementById('notification-count');
                const dropdownItems = document.getElementById('notification-items');
                
                if (data.length > 0) {
                    countBadge.textContent = data.length;
                    dropdownItems.innerHTML = '';
                    data.forEach(item => {
                        dropdownItems.innerHTML += `
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/inventory">
                                    <i class="fa-solid fa-triangle-exclamation text-danger me-2"></i>
                                    <div>
                                        <span class="d-block fw-semibold text-wrap">${item.name}</span>
                                        <small class="text-muted">Stok: ${item.current_stock} / Min: ${item.minimum_stock}</small>
                                    </div>
                                </a>
                            </li>
                        `;
                    });
                    dropdownItems.innerHTML += `
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-center small text-muted" href="/inventory">Lihat Semua Stok</a></li>
                    `;
                } else {
                    countBadge.textContent = '0';
                    dropdownItems.innerHTML = '<li><a class="dropdown-item text-center small text-muted" href="#">Tidak ada peringatan stok</a></li>';
                }
            })
            .catch(err => console.log('Error loading notifications:', err));

        // Automatically move all Bootstrap modals to <body> to prevent backdrop overlay / stacking context issues
        const moveModalsToBody = () => {
            document.querySelectorAll('.modal').forEach(modal => {
                if (modal.parentElement && modal.parentElement !== document.body) {
                    document.body.appendChild(modal);
                }
            });
        };
        moveModalsToBody();
        setTimeout(moveModalsToBody, 300);
    });
</script>
@stack('scripts')
</body>
</html>
