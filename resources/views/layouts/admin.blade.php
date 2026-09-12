<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Админ — DRIVE ELITE</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- AdminLTE CDN --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --gold: #c9a86a;
            --gold-light: #e6cf9e;
        }
        body { font-family: 'Poppins', sans-serif !important; }

        /* Sidebar branding */
        .brand-link { background: #1a1a1c !important; border-bottom: 1px solid #2a2a2c !important; }
        .brand-text { font-family: 'Cinzel', serif !important; color: var(--gold) !important; letter-spacing: 2px; font-size: 1rem !important; }
        .brand-text small { color: #666 !important; font-family: 'Poppins', sans-serif; font-size: 0.65rem; letter-spacing: 1px; }

        /* Sidebar */
        .main-sidebar { background: #141416 !important; }
        .sidebar { background: #141416 !important; }
        .nav-sidebar .nav-link { color: #8d8a86 !important; font-size: 0.85rem !important; letter-spacing: 0.5px; }
        .nav-sidebar .nav-link:hover { background: rgba(201,168,106,0.08) !important; color: var(--gold) !important; }
        .nav-sidebar .nav-link.active { background: rgba(201,168,106,0.12) !important; color: var(--gold) !important; }
        .nav-sidebar .nav-link.active i { color: var(--gold) !important; }
        .nav-sidebar .nav-link i { color: #555 !important; }
        .user-panel { border-bottom: 1px solid #222 !important; }
        .user-panel .info a { color: var(--gold) !important; font-size: 0.88rem; }
        .user-panel .info span { color: #666; font-size: 0.72rem; letter-spacing: 1px; }

        /* Topbar */
        .main-header { background: #1a1a1c !important; border-bottom: 1px solid #252527 !important; }
        .main-header .nav-link { color: #8d8a86 !important; }
        .main-header .nav-link:hover { color: var(--gold) !important; }
        .navbar-light .navbar-nav .nav-link { color: #8d8a86 !important; }

        /* Content area */
        .content-wrapper { background: #0f0f11 !important; }
        .content-header h1 {
            font-family: 'Cinzel', serif !important;
            font-size: 1.1rem !important;
            color: var(--gold) !important;
            letter-spacing: 2px;
        }
        .breadcrumb-item, .breadcrumb-item a { color: #666 !important; font-size: 0.78rem; }
        .breadcrumb-item.active { color: var(--gold) !important; }

        /* Cards */
        .card { background: #1a1a1c !important; border: 1px solid #252527 !important; border-radius: 6px !important; }
        .card-header { background: #1e1e20 !important; border-bottom: 1px solid #252527 !important; }
        .card-title { color: var(--gold) !important; font-family: 'Cinzel', serif; font-size: 0.9rem !important; letter-spacing: 1px; }
        .card-body { color: #ece9e4 !important; }

        /* Small stat cards */
        .small-box { border-radius: 6px !important; }
        .small-box h3 { font-family: 'Cinzel', serif !important; color: #fff !important; }
        .small-box-footer { opacity: 0.85; }

        /* Tables */
        .table { color: #ece9e4 !important; }
        .table thead th { color: #8d8a86 !important; border-color: #252527 !important; font-size: 0.72rem; letter-spacing: 1.5px; text-transform: uppercase; background: #111113; }
        .table td, .table th { border-color: #222 !important; vertical-align: middle !important; }
        .table tbody tr:hover td { background: rgba(255,255,255,0.02) !important; }

        /* Buttons */
        .btn-gold { background: var(--gold); color: #0b0b0d; border: none; font-weight: 600; font-size: 0.82rem; letter-spacing: 1px; }
        .btn-gold:hover { background: var(--gold-light); color: #0b0b0d; }
        .btn-outline-secondary { border-color: #333 !important; color: #8d8a86 !important; }
        .btn-outline-secondary:hover { background: #252527 !important; color: #ece9e4 !important; }

        /* Forms */
        .form-control { background: #111113 !important; border-color: #2a2a2c !important; color: #ece9e4 !important; }
        .form-control:focus { border-color: var(--gold) !important; box-shadow: 0 0 0 3px rgba(201,168,106,0.08) !important; }
        select.form-control option { background: #1a1a1c; }
        label { color: #8d8a86 !important; font-size: 0.72rem !important; letter-spacing: 1.5px; text-transform: uppercase; }
        .custom-file-label { background: #111113 !important; border-color: #2a2a2c !important; color: #666 !important; }

        /* Badges */
        .badge { letter-spacing: 0.5px; font-weight: 500; }

        /* Flash messages */
        .alert-success { background: rgba(201,168,106,0.1) !important; border-color: rgba(201,168,106,0.3) !important; color: var(--gold) !important; }
        .alert-danger  { background: rgba(226,86,107,0.1) !important; border-color: rgba(226,86,107,0.3) !important; color: #e2566b !important; }

        /* Footer */
        .main-footer { background: #1a1a1c !important; border-top: 1px solid #252527 !important; color: #555 !important; font-size: 0.78rem; }
        .main-footer strong { color: var(--gold) !important; }

        /* Sidebar footer */
        [class*="sidebar-dark"] .sidebar a { color: #8d8a86 !important; }
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active { background: rgba(201,168,106,0.12) !important; }
    </style>

    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed" style="background:#0b0b0d;">
<div class="wrapper">

    {{-- Topbar --}}
    <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="bi bi-list" style="font-size:1.2rem;"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link" style="font-size:0.82rem; letter-spacing:1px;">← На сайт</a>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link" style="font-size:0.82rem; color:#8d8a86; letter-spacing:1px;">Выйти</button>
                </form>
            </li>
        </ul>
    </nav>

    {{-- Sidebar --}}
    <aside class="main-sidebar sidebar-dark-primary elevation-0">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <span class="brand-text"> DRIVE ELITE <small class="d-block">ADMIN PANEL</small></span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <div style="width:34px;height:34px;background:var(--gold);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#0b0b0d;font-family:'Cinzel',serif;">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                    <span>АДМИНИСТРАТОР</span>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-grid-1x2 nav-icon"></i>
                            <p>Дашборд</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.cars.index') }}" class="nav-link {{ request()->routeIs('admin.cars.*') ? 'active' : '' }}">
                            <i class="bi bi-car-front nav-icon"></i>
                            <p>Автомобили</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.brands.index') }}" class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                            <i class="bi bi-award nav-icon"></i>
                            <p>Бренды</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="bi bi-bag-check nav-icon"></i>
                            <p>Заказы</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                            <i class="bi bi-people nav-icon"></i>
                            <p>Клиенты</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    {{-- Content --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@yield('page-title', 'Дашборд')</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <small style="color:#555; font-size:0.78rem;">{{ now()->format('d.m.Y') }}</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="main-footer text-center">
        <strong> DRIVE ELITE</strong> &mdash; Admin Panel &mdash;
        Разработано: <strong>Abdulrahman Fatao</strong> 2024–2026
    </footer>

</div>

{{-- AdminLTE JS --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stack('scripts')
</body>
</html>