
<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Sistem Infrastruktur Desa</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css'>
    <link rel='stylesheet' href='https://unpkg.com/leaflet@1.9.4/dist/leaflet.css'>
    <style>
        body { overflow-x: hidden; background-color: #f5f6fa; }
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #1B5E20, #2D6A2D);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.85);
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 4px;
            transition: 0.2s;
            font-size: 14px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active-menu {
            background: rgba(255,255,255,0.18);
            color: white;
        }
        .brand-title { font-size: 18px; font-weight: bold; }
        .content-area { min-height: 100vh; }
        .user-box { background: rgba(255,255,255,0.12); border-radius: 10px; padding: 10px; }
    </style>
</head>
<body>
<div class='d-flex'>
    <!-- SIDEBAR -->
    <div class='sidebar text-white p-3 shadow'>
        <div class='text-center mb-3'>
            <div class='brand-title'>
                <i class='bi bi-building-fill-check'></i> INFRADES
            </div>
            <small style='font-size:11px;opacity:0.8;'>Sistem Infrastruktur Desa</small>
        </div>
        <hr class='text-white opacity-25'>
        <ul class='nav flex-column'>
            <li class='nav-item'>
                <a href='/dashboard' class='nav-link {{ request()->is("dashboard") ? "active-menu" : "" }}'>
                    <i class='bi bi-speedometer2 me-2'></i> Dashboard
                </a>
            </li>
            <li class='nav-item'>
                <a href='/infrastruktur' class='nav-link {{ request()->is("infrastruktur*") ? "active-menu" : "" }}'>
                    <i class='bi bi-building me-2'></i> Infrastruktur
                </a>
            </li>
            <li class='nav-item'>
                <a href='/laporan-kerusakan' class='nav-link {{ request()->is("laporan*") ? "active-menu" : "" }}'>
                    <i class='bi bi-exclamation-triangle me-2'></i> Laporan Kerusakan
                </a>
            </li>
            <li class='nav-item'>
                <a href='/pengajuan' class='nav-link {{ request()->is("pengajuan*") ? "active-menu" : "" }}'>
                    <i class='bi bi-file-earmark-plus me-2'></i> Pengajuan Pembangunan
                </a>
            </li>
            @if(in_array(auth()->user()->role, ['admin','petugas']))
            <li class='nav-item'>
                <a href='/maintenance' class='nav-link {{ request()->is("maintenance*") ? "active-menu" : "" }}'>
                    <i class='bi bi-tools me-2'></i> Maintenance
                </a>
            </li>
            @endif
            @if(auth()->user()->role == 'admin')
            <li class='nav-item'>
                <a href='/anggaran' class='nav-link {{ request()->is("anggaran*") ? "active-menu" : "" }}'>
                    <i class='bi bi-cash-stack me-2'></i> Anggaran
                </a>
            </li>
            @endif
            <li class='nav-item'>
                <a href='/peta' class='nav-link {{ request()->is("peta*") ? "active-menu" : "" }}'>
                    <i class='bi bi-map me-2'></i> Peta Infrastruktur
                </a>
            </li>
            @if(auth()->user()->role == 'admin')
            <li class='nav-item'>
                <a href='/export/pdf' class='nav-link'>
                    <i class='bi bi-file-pdf me-2'></i> Export PDF
                </a>
            </li>
            <!-- <li class='nav-item'>
                <a href='/users' class='nav-link {{ request()->is("users*") ? "active-menu" : "" }}'>
                    <i class='bi bi-people me-2'></i> Manajemen User
                </a>
            </li> -->
            @endif
        </ul>
        <hr class='text-white opacity-25 mt-3'>
        @auth
        <div class='user-box text-white mb-3'>
            <strong><i class='bi bi-person-circle'></i> {{ auth()->user()->name }}</strong><br>
            <small style='opacity:0.8;'>{{ ucfirst(auth()->user()->role) }}</small>
        </div>
        <form method='POST' action='{{ route("logout") }}'>
            @csrf
            <button class='btn btn-outline-light w-100 btn-sm rounded-pill'>
                <i class='bi bi-box-arrow-right'></i> Logout
            </button>
        </form>
        @endauth
    </div>
    <!-- CONTENT -->
    <div class='content-area w-100 p-4'>
        @if(session('success'))
            <div class='alert alert-success alert-dismissible fade show'>
                <i class='bi bi-check-circle'></i> {{ session('success') }}
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>
        @endif
        @if(session('error'))
            <div class='alert alert-danger alert-dismissible fade show'>
                <i class='bi bi-x-circle'></i> {{ session('error') }}
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>
        @endif
        @yield('content')
    </div>
</div>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
<script src='https://unpkg.com/leaflet@1.9.4/dist/leaflet.js'></script>
@stack('scripts')
</body>
</html>
