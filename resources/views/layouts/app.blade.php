<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AMS - Apotek Management System</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom AMS CSS -->
    <style>
        :root {
            --primary-color: #1B5E20;
            --secondary-color: #66BB6A;
            --bg-color: #E8F5E9;
            --sidebar-bg: #ffffff;
            --sidebar-hover: #A5D6A7;
            --sidebar-color: #333333;
            --topbar-bg: #ffffff;
            --card-bg: #ffffff;
            --text-main: #333333;
            --text-muted: #6c757d;
            --border-color: #A5D6A7;
            --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --shadow-md: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            --transition: all 0.3s ease;
        }

        /* Light theme only — dark mode disabled */

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            overflow-x: hidden;
            transition: var(--transition);
        }

        /* Typography & Utilities */
        a { text-decoration: none; }
        .text-muted-custom { color: var(--text-muted) !important; }
        .card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
        }
        .table {
            color: var(--text-main);
            border-color: var(--border-color);
        }
        .table th {
            border-bottom-width: 1px;
            font-weight: 600;
            background-color: rgba(0,0,0,0.02);
        }
        /* [data-theme="dark"] .table th { background-color: rgba(255,255,255,0.02); } */
        .table-hover tbody tr:hover { background-color: var(--sidebar-hover); color: var(--text-main); }
        .form-control, .form-select {
            background-color: var(--card-bg);
            border-color: var(--border-color);
            color: var(--text-main);
        }
        .form-control:focus, .form-select:focus {
            background-color: var(--card-bg);
            color: var(--text-main);
        }

        /* Layout Structure */
        #wrapper {
            display: flex;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar */
        #sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            z-index: 1040;
        }
        #sidebar.collapsed {
            width: 70px;
        }
        .sidebar-brand {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            border-bottom: 1px solid var(--border-color);
        }
        #sidebar.collapsed .brand-text { display: none; }
        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 0;
        }
        .sidebar-menu::-webkit-scrollbar { width: 5px; }
        .sidebar-menu::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 5px; }
        
        .menu-header {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 600;
            color: var(--text-muted);
            padding: 0.5rem 1.5rem;
            margin-top: 1rem;
        }
        #sidebar.collapsed .menu-header { display: none; }
        
        .menu-item {
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            color: var(--sidebar-color);
            transition: var(--transition);
            cursor: pointer;
        }
        .menu-item:hover, .menu-item.active {
            background-color: var(--sidebar-hover);
            color: var(--primary-color);
            border-left: 4px solid var(--primary-color);
        }
        .menu-item:not(.active) { border-left: 4px solid transparent; }
        .menu-icon { font-size: 1.2rem; min-width: 30px; text-align: center; }
        .menu-text { margin-left: 10px; font-weight: 500; white-space: nowrap; }
        #sidebar.collapsed .menu-text { display: none; }
        #sidebar.collapsed .menu-item { justify-content: center; padding: 0.75rem 0; }
        #sidebar.collapsed .menu-icon { margin: 0; }

        /* Main Content */
        #content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Topbar */
        #topbar {
            height: 70px;
            background-color: var(--topbar-bg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            z-index: 1030;
        }
        .topbar-left, .topbar-right { display: flex; align-items: center; gap: 1rem; }
        .toggle-btn {
            background: transparent;
            border: none;
            color: var(--text-main);
            font-size: 1.5rem;
            cursor: pointer;
        }
        .search-box {
            position: relative;
            width: 250px;
        }
        .search-box input {
            border-radius: 20px;
            padding-left: 35px;
            border-color: var(--border-color);
        }
        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }
        .topbar-icon-btn {
            background: transparent;
            border: none;
            color: var(--text-main);
            font-size: 1.2rem;
            position: relative;
        }
        .topbar-icon-btn .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 0.6rem;
        }

        /* Page Content */
        #main-content {
            flex: 1;
            padding: 1.5rem;
            overflow-y: auto;
            position: relative;
        }

        /* Custom Badges */
        .badge-safe { background-color: rgba(25, 135, 84, 0.1); color: #198754; border: 1px solid #198754; }
        .badge-warning { background-color: rgba(255, 193, 7, 0.1); color: #ffc107; border: 1px solid #ffc107; }
        .badge-danger { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; border: 1px solid #dc3545; }

        /* Stat Cards */
        .stat-card { display: flex; align-items: center; padding: 1.5rem; }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-right: 1rem;
        }
        .stat-icon.primary { background-color: rgba(27, 94, 32, 0.1); color: #1B5E20; }
        .stat-icon.success { background-color: rgba(102, 187, 106, 0.1); color: #66BB6A; }
        .stat-icon.danger { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; }
        .stat-icon.warning { background-color: rgba(255, 193, 7, 0.1); color: #ffc107; }
        .stat-details h3 { margin: 0; font-weight: 700; font-size: 1.5rem; }
        .stat-details p { margin: 0; color: var(--text-muted); font-size: 0.9rem; }

        /* Profile Page */
        .profile-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            height: 150px;
            border-radius: 0.5rem 0.5rem 0 0;
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
        }
        .profile-info { padding: 70px 30px 30px 30px; }

        /* Responsive */
        @media (max-width: 768px) {
            #sidebar { position: absolute; height: 100%; transform: translateX(-100%); z-index: 1050; }
            #sidebar.mobile-show { transform: translateX(0); }
            .search-box { display: none; }
        }

        /* Widgets */
        .widget-item { padding: 10px 0; border-bottom: 1px solid var(--border-color); display: flex; align-items: center;}
        .widget-item:last-child { border-bottom: none; }
        .widget-icon { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;}
        
        /* Modals */
        .modal-content { background-color: var(--card-bg); color: var(--text-main); }
        .modal-header { border-bottom-color: var(--border-color); }
        .modal-footer { border-top-color: var(--border-color); }

        /* Stat card link hover */
        .stat-card-link { cursor: pointer; }
        a:hover .stat-card-link { box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.15); }
    </style>
</head>
<body>

<div id="wrapper">
    <!-- SIDEBAR -->
    <nav id="sidebar">
        <div class="sidebar-brand">
            <i class="fa-solid fa-prescription-bottle-medical me-2"></i>
            <span class="brand-text">AMS</span>
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
                <a href="{{ url('log-viewer') }}" target="_blank" class="menu-item">
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
        <!-- TOPBAR -->
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

                <button class="topbar-icon-btn" id="fullscreenToggle" title="Layar Penuh">
                    <i class="fa-solid fa-expand"></i>
                </button>
                <div class="dropdown">
                    <button class="topbar-icon-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="border:none; background:transparent;">
                        <i class="fa-solid fa-bell"></i>
                        <span class="badge bg-danger rounded-pill" id="notification-count">0</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow" id="notification-dropdown">
                        <li><h6 class="dropdown-header">Notifikasi</h6></li>
                        <div id="notification-items">
                            <!-- Low stock notifications will be dynamically loaded if any -->
                            <li><a class="dropdown-item text-center small text-muted" href="#">Tidak ada notifikasi baru</a></li>
                        </div>
                    </ul>
                </div>
                <div class="dropdown">
                    <div class="d-flex align-items-center cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1B5E20&color=fff" alt="User" class="rounded-circle" width="35" height="35">
                        <div class="ms-2 d-none d-md-block">
                            <span class="d-block fw-semibold" style="font-size: 0.9rem;">{{ Auth::user()->name }}</span>
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
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>
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
        </main>
    </div>
</div>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS for WMS UI Controls -->
<script>
    // Force light theme always
    document.documentElement.setAttribute('data-theme', 'light');
    localStorage.setItem('theme', 'light');

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
        
        // For mobile screens: toggle visibility
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
        fetch('/api/low-stock-notifications')
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
    });
</script>
@stack('scripts')
</body>
</html>
