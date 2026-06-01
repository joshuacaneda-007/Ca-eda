<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AnimeTracker - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #0f0f1a; color: #e0e0e0; font-family: 'Segoe UI', sans-serif; }
        .sidebar {
            width: 240px; min-height: 100vh; background: #1a1a2e;
            position: fixed; top: 0; left: 0; z-index: 1000;
            transition: transform .3s ease;
        }
        .sidebar .brand { padding: 1.5rem 1rem; border-bottom: 1px solid #2d2d4e; }
        .sidebar .brand h5 { color: #e94560; font-weight: 700; margin: 0; }
        .sidebar .nav-link {
            color: #a0a0c0; padding: .65rem 1.2rem; border-radius: 8px;
            margin: 2px 8px; transition: all .2s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: #e94560; color: #fff;
        }
        .sidebar .nav-link i { width: 20px; }
        .main-content { margin-left: 240px; min-height: 100vh; }
        .topbar {
            background: #1a1a2e; padding: .75rem 1.5rem;
            border-bottom: 1px solid #2d2d4e; position: sticky; top: 0; z-index: 999;
        }
        .card { background: #1a1a2e; border: 1px solid #2d2d4e; border-radius: 12px; }
        .card-header { background: #16213e; border-bottom: 1px solid #2d2d4e; }
        .table { color: #e0e0e0; }
        .table thead th { background: #16213e; color: #a0a0c0; border-color: #2d2d4e; }
        .table td, .table th { border-color: #2d2d4e; vertical-align: middle; }
        .table tbody tr:hover { background: #16213e; }
        .form-control, .form-select {
            background: #16213e; border: 1px solid #2d2d4e; color: #e0e0e0;
        }
        .form-control:focus, .form-select:focus {
            background: #16213e; border-color: #e94560; color: #e0e0e0; box-shadow: 0 0 0 .2rem rgba(233,69,96,.25);
        }
        .form-control::placeholder { color: #606080; }
        .btn-primary { background: #e94560; border-color: #e94560; }
        .btn-primary:hover { background: #c73652; border-color: #c73652; }
        .stat-card { border-left: 4px solid #e94560; }
        .stat-card .stat-icon { font-size: 2rem; color: #e94560; }
        .badge-watching { background: #17a2b8; }
        .badge-completed { background: #28a745; }
        .badge-dropped { background: #dc3545; }
        .badge-hold { background: #ffc107; color: #000; }
        .badge-plan { background: #6c757d; }
        .toast-container { position: fixed; top: 1rem; right: 1rem; z-index: 9999; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="brand d-flex align-items-center gap-2">
        <i class="bi bi-play-circle-fill text-danger fs-4"></i>
        <h5>AnimeTracker</h5>
    </div>
    <nav class="nav flex-column mt-3">
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
        <a href="{{ route('anime.index') }}" class="nav-link {{ request()->routeIs('anime.*') ? 'active' : '' }}">
            <i class="bi bi-collection-play me-2"></i> My Anime List
        </a>
        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-people me-2"></i> Users
        </a>
        <a href="{{ route('profile.show') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle me-2"></i> Profile
        </a>
        <hr style="border-color:#2d2d4e; margin: .5rem 1rem;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link btn btn-link text-start w-100" style="color:#a0a0c0;">
                <i class="bi bi-box-arrow-left me-2"></i> Logout
            </button>
        </form>
    </nav>
</div>

<!-- Main -->
<div class="main-content">
    <!-- Topbar -->
    <div class="topbar d-flex align-items-center justify-content-between">
        <button class="btn btn-sm btn-outline-secondary d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
            <i class="bi bi-list"></i>
        </button>
        <span class="text-muted small d-none d-md-block">@yield('title', 'Dashboard')</span>
        <div class="d-flex align-items-center gap-2">
            @if(auth()->user()->profile_picture)
                <img src="{{ Storage::url(auth()->user()->profile_picture) }}" class="rounded-circle" width="32" height="32" style="object-fit:cover;">
            @else
                <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center" style="width:32px;height:32px;font-size:.8rem;font-weight:700;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
            <span class="small">{{ auth()->user()->name }}</span>
        </div>
    </div>

    <!-- Toast -->
    @if(session('toast_success'))
    <div class="toast-container">
        <div class="toast show align-items-center text-bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body"><i class="bi bi-check-circle me-2"></i>{{ session('toast_success') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif
    @if(session('toast_error'))
    <div class="toast-container">
        <div class="toast show align-items-center text-bg-danger border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body"><i class="bi bi-x-circle me-2"></i>{{ session('toast_error') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif

    <div class="p-3 p-md-4">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-dismiss toasts
    document.querySelectorAll('.toast').forEach(t => {
        setTimeout(() => { const toast = bootstrap.Toast.getOrCreateInstance(t); toast.hide(); }, 4000);
    });
</script>
@stack('scripts')
</body>
</html>
