<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Guest Dashboard - Grand Horizon')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fa;
        }
        /* Styling untuk Sidebar */
        .sidebar {
            min-height: 100vh;
            background-color: #ffffff;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            width: 260px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
        }
        .sidebar-brand {
            font-size: 1.25rem;
            color: #0d6efd;
        }
        .nav-link {
            color: #6c757d;
            font-weight: 500;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 15px;
            transition: all 0.3s ease;
        }
        .nav-link:hover, .nav-link.active {
            background-color: #0d6efd;
            color: #ffffff;
            box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2);
        }
        .nav-link i {
            font-size: 1.1rem;
        }
        /* Area Konten Utama */
        .main-content {
            margin-left: 260px; /* Memberi ruang agar tidak tertutup sidebar */
            padding: 30px;
            min-height: 100vh;
        }
    </style>
</head>
<body>

    <div class="sidebar py-4 d-flex flex-column">
        <div class="text-center mb-5">
            <h4 class="fw-bold sidebar-brand mb-0">Grand Horizon</h4>
            <span class="text-muted small">Hotel & Resort</span>
        </div>

        <nav class="nav flex-column mb-auto">
            <a class="nav-link active" href="{{ route('guest.dashboard') }}">
            <a class="nav-link {{ request()->routeIs('guest.dashboard') ? 'active' : '' }}" href="{{ route('guest.dashboard') }}">
                <i class="bi bi-grid-1x2-fill me-3"></i> Dashboard
            </a>
            <!-- Link Kamar Saya diperbarui -->
            <a class="nav-link {{ request()->routeIs('guest.my-room') ? 'active' : '' }}" href="{{ route('guest.my-room') }}">
                <i class="bi bi-door-open-fill me-3"></i> Kamar Saya
            </a>
            <a class="nav-link" href="#">
                <i class="bi bi-clock-history me-3"></i> Riwayat
            </a>
            <a class="nav-link" href="#">
                <i class="bi bi-person-fill me-3"></i> Profil
            </a>
        </nav>

        <div class="mt-auto px-3">
            <hr class="text-muted">
            <a href="{{ route('login') }}" class="nav-link text-danger d-flex align-items-center" style="background:none; box-shadow:none;">
                <i class="bi bi-box-arrow-left me-3"></i> Keluar
            </a>
        </div>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>