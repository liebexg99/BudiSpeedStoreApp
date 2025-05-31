<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aplikasi manajemen toko online untuk mengelola barang, penjualan, pembelian, dan laporan.">
    <title>{{ config('app.name', 'Toko Online') }} - @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <style>
        .btn-sc {
            background-color: rgba(178, 34, 34, 0.05);
        }

        :root {
            --primary-color: #B22222;
            --primary-hover: #8B1538;
            --sidebar-width: 280px;
            --sidebar-bg: #FFF5F5;
            --sidebar-text: #333333;
            --sidebar-active: #FFE4E1;
            --sidebar-icon: #CD5C5C;
            --sidebar-icon-active: #B22222;
            --content-bg: #fafafa;
            --transition-speed: 0.3s;
            --accent-gold: #DAA520;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--content-bg);
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #FFF8F8 100%);
            position: fixed;
            height: 100vh;
            box-shadow: 0 2px 15px rgba(178, 34, 34, 0.1);
            transition: transform var(--transition-speed) ease-in-out;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            border-right: 2px solid rgba(178, 34, 34, 0.1);
            transform: translateX(0);
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar-brand {
            height: 4.375rem;
            padding: 1rem;
            border-bottom: 2px solid rgba(178, 34, 34, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, var(--primary-color) 0%, #DC143C 100%);
        }

        .sidebar-brand-text {
            font-size: 1.3rem;
            font-weight: 700;
            color: #FFFFFF;
            text-decoration: none;
            display: flex;
            align-items: center;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .sidebar-brand-text i {
            margin-right: 0.5rem;
            color: var(--accent-gold);
        }

        .sidebar-toggle-btn {
            background: rgba(255, 255, 255, 0.1);
            color: #FFFFFF;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 2rem;
            height: 2rem;
            font-size: 0.9rem;
            line-height: 1;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        .sidebar-divider {
            border-top: 1px solid rgba(178, 34, 34, 0.15);
            margin: 1rem 0;
        }

        .sidebar-heading {
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.75rem;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 0.13em;
            background: rgba(178, 34, 34, 0.05);
            margin: 0.25rem 0;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.85rem 1rem;
            color: var(--sidebar-text);
            font-weight: 500;
            transition: all var(--transition-speed) ease;
            border-left: 0.25rem solid transparent;
            margin: 0.1rem 0;
            border-radius: 0 0.5rem 0.5rem 0;
        }

        .nav-link:hover {
            color: var(--primary-color);
            background: linear-gradient(90deg, var(--sidebar-active) 0%, rgba(178, 34, 34, 0.08) 100%);
            transform: translateX(5px);
            border-left-color: var(--sidebar-icon);
        }

        .nav-link i {
            font-size: 0.9rem;
            margin-right: 0.75rem;
            color: var(--sidebar-icon);
            width: 1.2rem;
            text-align: center;
        }

        .nav-link.active {
            color: var(--primary-color);
            background: linear-gradient(90deg, var(--sidebar-active) 0%, rgba(178, 34, 34, 0.12) 100%);
            border-left-color: var(--primary-color);
            font-weight: 600;
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(178, 34, 34, 0.15);
        }

        .nav-link.active i {
            color: var(--sidebar-icon-active);
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 0.5rem 0 1rem 0;
            scrollbar-width: thin;
            scrollbar-color: var(--sidebar-icon) var(--sidebar-active);
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: var(--sidebar-active);
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: var(--sidebar-icon);
            border-radius: 3px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }

        .logout-btn {
            padding: 1rem;
            background: linear-gradient(135deg, rgba(178, 34, 34, 0.05) 0%, rgba(178, 34, 34, 0.1) 100%);
            border-top: 2px solid rgba(178, 34, 34, 0.1);
            text-align: center;
        }

        .logout-btn .btn {
            background: linear-gradient(135deg, var(--primary-color) 0%, #DC143C 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all var(--transition-speed) ease;
            box-shadow: 0 2px 8px rgba(178, 34, 34, 0.3);
        }

        .logout-btn .btn:hover {
            background: linear-gradient(135deg, var(--primary-hover) 0%, #B22222 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(178, 34, 34, 0.4);
        }

        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            transition: margin-left var(--transition-speed) ease-in-out;
        }

        .main-content.expanded {
            margin-left: 0;
            width: 100%;
        }

        .top-navbar {
            height: 4.375rem;
            box-shadow: 0 2px 15px rgba(178, 34, 34, 0.08);
            background: linear-gradient(90deg, #ffffff 0%, #fefefe 100%);
            z-index: 100;
            border-bottom: 2px solid rgba(178, 34, 34, 0.05);
        }

        .content-header {
            padding: 1.5rem;
            background-color: transparent;
        }

        .content-header h1 {
            color: var(--primary-color);
            font-weight: 600;
        }

        .content-container {
            padding: 1.5rem;
        }

        /* Floating Toggle Button for Reopening Sidebar */
        .floating-toggle-btn {
            position: fixed;
            top: 1rem;
            left: 1rem;
            background: linear-gradient(135deg, var(--primary-color) 0%, #DC143C 100%);
            color: #FFFFFF;
            border: none;
            border-radius: 50%;
            width: 2.5rem;
            height: 2.5rem;
            font-size: 1rem;
            display: none;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(178, 34, 34, 0.3);
            z-index: 999;
            transition: all var(--transition-speed) ease;
        }

        .floating-toggle-btn:hover {
            background: linear-gradient(135deg, var(--primary-hover) 0%, #B22222 100%);
            transform: scale(1.05);
        }

        .floating-toggle-btn.show {
            display: flex;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(178, 34, 34, 0.08);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, rgba(178, 34, 34, 0.05) 0%, rgba(178, 34, 34, 0.08) 100%);
            border-bottom: 1px solid rgba(178, 34, 34, 0.1);
            padding: 1rem 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        /* Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #DC143C 100%);
            border: none;
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            transition: all var(--transition-speed) ease;
            box-shadow: 0 2px 8px rgba(178, 34, 34, 0.25);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-hover) 0%, #B22222 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(178, 34, 34, 0.35);
        }

        /* Dropdown Styles */
        .dropdown-menu {
            border: 1px solid rgba(178, 34, 34, 0.1);
            box-shadow: 0 4px 15px rgba(178, 34, 34, 0.15);
        }

        .dropdown-item:hover {
            background-color: var(--sidebar-active);
            color: var(--primary-color);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.collapsed {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .main-content.expanded {
                margin-left: 0;
                width: 100%;
            }

            .floating-toggle-btn {
                display: none;
            }

            .floating-toggle-btn.show {
                display: flex;
            }

            .sidebar-toggle-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }

        /* Toggle Button */
        .sidebar-collapse-btn {
            display: none;
            border: none;
            background: transparent;
            font-size: 1.25rem;
            color: var(--primary-color);
            padding: 0.5rem;
            border-radius: 0.25rem;
            transition: all var(--transition-speed) ease;
        }

        .sidebar-collapse-btn:hover {
            background: rgba(178, 34, 34, 0.1);
            color: var(--primary-hover);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }

        @keyframes slideOut {
            from { transform: translateX(0); }
            to { transform: translateX(-100%); }
        }

        .animate-fade {
            animation: fadeIn 0.5s ease-in-out;
        }

        .animate-zoom-in {
            animation: zoomIn 0.6s ease-out;
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Toastr customization */
        .toast {
            border-radius: 0.5rem !important;
        }

        /* User dropdown styling */
        .navbar-nav .nav-link {
            color: var(--primary-color) !important;
            font-weight: 500;
            transition: all var(--transition-speed) ease;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-hover) !important;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <nav class="sidebar animate-zoom-in">
            <div class="sidebar-brand">
                <a href="{{ route('dashboard') }}" class="sidebar-brand-text">
                    <i class="fas fa-store"></i>
                    BudiSpeed!
                </a>
                <button class="sidebar-toggle-btn animate-slide-up" id="sidebarBrandToggle">
                    <i class="fas fa-angle-left"></i>
                </button>
            </div>
            <div class="sidebar-nav">
                <div class="sidebar-divider"></div>
                <ul class="nav flex-column">
                    <li class="nav-item animate-slide-up">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}" aria-current="{{ Route::is('dashboard') ? 'page' : '' }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-heading animate-slide-up">Data Pokok</li>
                    <li class="nav-item animate-slide-up">
                        <a href="{{ route('kategori.index') }}" class="nav-link {{ Route::is('kategori.*') ? 'active' : '' }}">
                            <i class="fas fa-tag"></i>
                            <span>Kategori</span>
                        </a>
                    </li>
                    <li class="nav-item animate-slide-up">
                        <a href="{{ route('barang.index') }}" class="nav-link {{ Route::is('barang.*') ? 'active' : '' }}">
                            <i class="fas fa-box"></i>
                            <span>Barang</span>
                        </a>
                    </li>
                    <li class="nav-item animate-slide-up">
                        <a href="{{ route('supplier.index') }}" class="nav-link {{ Route::is('supplier.*') ? 'active' : '' }}">
                            <i class="fas fa-truck"></i>
                            <span>Supplier</span>
                        </a>
                    </li>
                    <li class="nav-item animate-slide-up">
                        <a href="{{ route('pembeli.index') }}" class="nav-link {{ Route::is('pembeli.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Pembeli</span>
                        </a>
                    </li>

                    <li class="sidebar-heading animate-slide-up">Jual Beli</li>
                    <li class="nav-item animate-slide-up">
                        <a href="{{ route('pembelian.index') }}" class="nav-link {{ Route::is('pembelian.*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Pembelian</span>
                        </a>
                    </li>
                    <li class="nav-item animate-slide-up">
                        <a href="{{ route('penjualan.index') }}" class="nav-link {{ Route::is('penjualan.*') ? 'active' : '' }}">
                            <i class="fas fa-cash-register"></i>
                            <span>Penjualan</span>
                        </a>
                    </li>

                    <li class="sidebar-heading animate-slide-up">Hasil Laporan</li>
                    <li class="nav-item animate-slide-up">
                        <a href="{{ route('laporan.penjualan') }}" class="nav-link {{ Route::is('laporan.penjualan') ? 'active' : '' }}">
                            <i class="fas fa-chart-bar"></i>
                            <span>Laporan Penjualan</span>
                        </a>
                    </li>
                    <li class="nav-item animate-slide-up">
                        <a href="{{ route('laporan.stok') }}" class="nav-link {{ Route::is('laporan.stok') ? 'active' : '' }}">
                            <i class="fas fa-cubes"></i>
                            <span>Laporan Stok</span>
                        </a>
                    </li>
                    <li class="nav-item animate-slide-up">
                        <a href="{{ route('laporan.barang-terjual') }}" class="nav-link {{ Route::is('laporan.barang-terjual') ? 'active' : '' }}">
                            <i class="fas fa-chart-line"></i>
                            <span>Barang Terjual</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="logout-btn animate-slide-up">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </div>
        </nav>

        <button class="floating-toggle-btn" id="floatingToggle">
            <i class="fas fa-angle-right"></i>
        </button>

        <div class="main-content animate-fade">
            <nav class="navbar navbar-expand top-navbar">
                <div class="container-fluid">
                    <button class="sidebar-collapse-btn" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="navbar-nav ms-auto">
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>
                                <span>{{ Auth::user()->username }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#" id="profileLink"><i class="fas fa-user me-2"></i> Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="content-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3 mb-0">@yield('title')</h1>
                    @yield('breadcrumb')
                </div>
            </div>

            <div class="content-container">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Sidebar toggle functionality
        const sidebar = document.querySelector('.sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarBrandToggle = document.getElementById('sidebarBrandToggle');
        const floatingToggle = document.getElementById('floatingToggle');
        const mainContent = document.querySelector('.main-content');
        const toggleIcon = sidebarBrandToggle.querySelector('i');

        function toggleSidebar() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            floatingToggle.classList.toggle('show');
            if (sidebar.classList.contains('collapsed')) {
                sidebar.classList.remove('show');
                toggleIcon.classList.remove('fa-angle-left');
                toggleIcon.classList.add('fa-angle-right');
            } else {
                sidebar.classList.add('show');
                toggleIcon.classList.remove('fa-angle-right');
                toggleIcon.classList.add('fa-angle-left');
            }
        }

        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarBrandToggle.addEventListener('click', toggleSidebar);
        floatingToggle.addEventListener('click', toggleSidebar);

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768 &&
                !sidebar.contains(event.target) &&
                event.target !== sidebarToggle &&
                !sidebarToggle.contains(event.target) &&
                event.target !== sidebarBrandToggle &&
                !sidebarBrandToggle.contains(event.target) &&
                event.target !== floatingToggle &&
                !floatingToggle.contains(event.target)) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
                floatingToggle.classList.add('show');
                toggleIcon.classList.remove('fa-angle-left');
                toggleIcon.classList.add('fa-angle-right');
            }
        });

        // Adjust sidebar state on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('expanded');
                floatingToggle.classList.remove('show');
                sidebar.classList.remove('show');
                toggleIcon.classList.remove('fa-angle-right');
                toggleIcon.classList.add('fa-angle-left');
            } else if (!sidebar.classList.contains('show')) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
                floatingToggle.classList.add('show');
                toggleIcon.classList.remove('fa-angle-left');
                toggleIcon.classList.add('fa-angle-right');
            }
        });

        // Initialize sidebar state based on screen size
        if (window.innerWidth <= 768) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
            floatingToggle.classList.add('show');
            toggleIcon.classList.remove('fa-angle-left');
            toggleIcon.classList.add('fa-angle-right');
        }

        // Toastr notifications
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 5000,
            extendedTimeOut: 2000,
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };

        @if(session('success'))
            toastr.success('{{ session('success') }}', 'Sukses');
        @endif

        @if(session('error'))
            toastr.error('{{ session('error') }}', 'Error');
        @endif

        // Active link indicator
        const currentPath = window.location.pathname;
        document.querySelectorAll('.nav-link').forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });

        // Add event listener for "Profil" link
        document.getElementById('profileLink').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link behavior
            toastr.info('LOH KATE NYAPO!!??', 'Informasi'); // Show the Toastr message
        });
    </script>

    @yield('scripts')
</body>
</html>