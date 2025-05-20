<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - SIMPUSKLU Admin</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #11894A;
            --primary-dark: #0a7a50;
            --secondary-color: #f8f9fa;
            --text-color: #343a40;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: var(--primary-color);
            color: white;
            padding-top: 32px;
            transition: all 0.3s;
            z-index: 999;
        }

        .sidebar .brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar .brand img {
            width: 60px;
            height: 60px;
        }

        .sidebar .brand-text {
            font-size: 18px;
            font-weight: 600;
            margin-top: 10px;
        }

        .sidebar .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            color: white;
            text-decoration: none;
        }

        .sidebar .menu-item:hover,
        .sidebar .menu-item.active {
            background-color: var(--primary-dark);
            border-left: 4px solid white;
        }

        .sidebar .menu-item .icon {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Content */
        .content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 12px;


        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: none;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #eee;
            font-weight: 600;
            padding: 15px 20px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 6px;
            font-weight: 500;
            padding: 8px 16px;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .user-profile {
            display: flex;
            align-items: center;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .dropdown-item {
            padding: 8px 15px;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: var(--primary-light);
        }



        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
                padding-top: 15px;
            }

            .sidebar .brand-text {
                display: none;
            }

            .sidebar .menu-item span {
                display: none;
            }

            .sidebar .menu-item .icon {
                margin-right: 0;
                font-size: 20px;
            }

            .content {
                margin-left: 80px;
            }
        }
    </style>

    @stack('css')
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">
            <img src="{{ asset('assets/img/logo-puskesmas.png') }}" alt="Logo Puskesmas Kluwut"
                onerror="this.src='https://via.placeholder.com/60x60?text=PUSKESMAS'">
            <div class="brand-text">Puskesmas Kluwut</div>
        </div>

        <a href="{{ route('admin.dashboard') }}"
            class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <div class="icon"><i class="fas fa-tachometer-alt"></i></div>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.pendaftaran.index') }}"
            class="menu-item {{ request()->routeIs('admin.pendaftaran*') ? 'active' : '' }}">
            <div class="icon"><i class="fas fa-clipboard-list"></i></div>
            <span>Pendaftaran</span>
        </a>

        <a href="{{ route('admin.poli.index') }}"
            class="menu-item {{ request()->routeIs('admin.poli*') ? 'active' : '' }}">
            <div class="icon"><i class="fas fa-hospital"></i></div>
            <span>Poli</span>
        </a>

        <a href="{{ route('admin.dokter.index') }}"
            class="menu-item {{ request()->routeIs('admin.dokter*') ? 'active' : '' }}">
            <div class="icon"><i class="fas fa-user-md"></i></div>
            <span>Dokter</span>
        </a>

        <a href="{{ route('admin.pasien.index') }}"
            class="menu-item {{ request()->routeIs('admin.pasien*') ? 'active' : '' }}">
            <div class="icon"><i class="fas fa-users"></i></div>
            <span>Pasien</span>
        </a>

        <a href="{{ route('admin.rekam-medis.index') }}"
            class="menu-item {{ request()->routeIs('admin.rekam-medis*') ? 'active' : '' }}">
            <div class="icon"><i class="fas fa-notes-medical"></i></div>
            <span>Rekam Medis</span>
        </a>

        <!-- <a href="{{ route('admin.obat.index') }}"
            class="menu-item {{ request()->routeIs('admin.obat*') ? 'active' : '' }}">
            <div class="icon"><i class="fas fa-pills"></i></div>
            <span>Obat</span>
        </a> -->
    </div>

    <!-- Content -->
    <div class="content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light mb-4">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="navbar-nav me-auto">
                        <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
                    </div>

                    <div class="user-profile">
                        <img src="{{ asset('assets/img/profile-avatar.png') }}" alt="Profile">
                        <div class="dropdown">
                            <a href="#" class="text-decoration-none text-dark dropdown-toggle" id="userDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="fw-bold">{{ Auth::user()->name }}</div>
                                <small class="text-muted">{{ Auth::user()->role }}</small>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profil</a>
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>
                                        Pengaturan</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="dropdown-item p-0">
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
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @stack('js')

    @yield('scripts')

    <script>
        // Auto close alerts after 5 seconds
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 5000);
    </script>
</body>

</html>
