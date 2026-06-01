<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AnimeTracker - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --bg-main:    #f0f4ff;
            --bg-sidebar: #ffffff;
            --bg-card:    #ffffff;
            --bg-input:   #f8faff;
            --border:     #dde3f0;
            --text-main:  #1e2a45;
            --text-muted: #7a8aaa;
            --accent:     #4f6ef7;
            --accent-hover: #3a57e8;
            --accent-soft:  #eef1ff;
            --danger:     #e94560;
        }
        body { background: var(--bg-main); color: var(--text-main); font-family: 'Segoe UI', sans-serif; }

        /* Sidebar */
        .sidebar {
            width: 240px; min-height: 100vh; background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            position: fixed; top: 0; left: 0; z-index: 1000;
            transition: transform .3s ease;
            box-shadow: 2px 0 12px rgba(79,110,247,.06);
        }
        .sidebar .brand { padding: 1.4rem 1.2rem; border-bottom: 1px solid var(--border); }
        .sidebar .brand h5 { color: var(--accent); font-weight: 700; margin: 0; }
        .sidebar .nav-link {
            color: var(--text-muted); padding: .6rem 1.1rem; border-radius: 8px;
            margin: 2px 8px; transition: all .2s; font-size: .9rem;
        }
        .sidebar .nav-link:hover { background: var(--accent-soft); color: var(--accent); }
        .sidebar .nav-link.active { background: var(--accent); color: #fff; }
        .sidebar .nav-link i { width: 20px; }

        /* Main */
        .main-content { margin-left: 240px; min-height: 100vh; }
        .topbar {
            background: var(--bg-sidebar); padding: .7rem 1.5rem;
            border-bottom: 1px solid var(--border);
            position: sticky; top: 0; z-index: 999;
            box-shadow: 0 2px 8px rgba(79,110,247,.05);
        }

        /* Cards */
        .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 12px; box-shadow: 0 2px 8px rgba(79,110,247,.05); }
        .card-header { background: #f8faff; border-bottom: 1px solid var(--border); }

        /* Tables */
        .table { color: var(--text-main); }
        .table thead th { background: #f4f7ff; color: var(--text-muted); border-color: var(--border); font-size: .82rem; text-transform: uppercase; letter-spacing: .04em; }
        .table td, .table th { border-color: var(--border); vertical-align: middle; }
        .table tbody tr:hover { background: #f8faff; }

        /* Forms */
        .form-control, .form-select {
            background: var(--bg-input); border: 1px solid var(--border); color: var(--text-main);
        }
        .form-control:focus, .form-select:focus {
            background: #fff; border-color: var(--accent); color: var(--text-main);
            box-shadow: 0 0 0 .2rem rgba(79,110,247,.15);
        }
        .form-label { color: var(--text-muted); font-size: .83rem; font-weight: 500; }

        /* Buttons */
        .btn-primary { background: var(--accent); border-color: var(--accent); }
        .btn-primary:hover { background: var(--accent-hover); border-color: var(--accent-hover); }

        /* Stat cards */
        .stat-card { border-left: 4px solid var(--accent); }
        .stat-card .stat-icon { font-size: 2rem; color: var(--accent); }

        /* Modals */
        .modal-content { background: var(--bg-card); border: 1px solid var(--border); }
        .modal-header { border-color: var(--border); }
        .modal-footer { border-color: var(--border); }

        /* Toast */
        .toast-container { position: fixed; top: 1rem; right: 1rem; z-index: 9999; }

        /* Avatar initials */
        .avatar-initials {
            background: var(--accent); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; border-radius: 50%;
        }

        /* Progress */
        .progress { background: var(--border); }

        /* HR */
        hr { border-color: var(--border); }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

@php
    $u = auth()->user();
    $avatarSrc = $u->profile_picture_base64 ?? null;
    $initials   = strtoupper(substr($u->name, 0, 1));
@endphp

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="brand d-flex align-items-center gap-2">
        <i class="bi bi-play-circle-fill fs-4" style="color:var(--accent)"></i>
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
        <hr class="mx-3 my-2">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link btn btn-link text-start w-100" style="color:var(--text-muted);">
                <i class="bi bi-box-arrow-left me-2"></i> Logout
            </button>
        </form>
    </nav>
</div>

<!-- Main -->
<div class="main-content">
    <div class="topbar d-flex align-items-center justify-content-between">
        <button class="btn btn-sm btn-outline-secondary d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
            <i class="bi bi-list"></i>
        </button>
        <span class="text-muted small fw-semibold d-none d-md-block">@yield('title', 'Dashboard')</span>
        <div class="d-flex align-items-center gap-2">
            @if($avatarSrc)
                <img src="{{ $avatarSrc }}" class="rounded-circle" width="32" height="32" style="object-fit:cover;border:2px solid var(--accent);">
            @else
                <div class="avatar-initials" style="width:32px;height:32px;font-size:.8rem;">{{ $initials }}</div>
            @endif
            <span class="small fw-semibold" style="color:var(--text-main)">{{ $u->name }}</span>
        </div>
    </div>

    <!-- Toasts -->
    @if(session('toast_success'))
    <div class="toast-container">
        <div class="toast show align-items-center text-bg-success border-0 shadow" role="alert">
            <div class="d-flex">
                <div class="toast-body"><i class="bi bi-check-circle me-2"></i>{{ session('toast_success') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif
    @if(session('toast_error'))
    <div class="toast-container">
        <div class="toast show align-items-center text-bg-danger border-0 shadow" role="alert">
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
    document.querySelectorAll('.toast').forEach(t => {
        setTimeout(() => bootstrap.Toast.getOrCreateInstance(t).hide(), 4000);
    });
</script>
@stack('scripts')
</body>
</html>
