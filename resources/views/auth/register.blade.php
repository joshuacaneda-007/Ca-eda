<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - AnimeTracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #0f0f1a; color: #e0e0e0; min-height: 100vh; display: flex; align-items: center; }
        .auth-card { background: #1a1a2e; border: 1px solid #2d2d4e; border-radius: 16px; }
        .form-control { background: #16213e; border: 1px solid #2d2d4e; color: #e0e0e0; }
        .form-control:focus { background: #16213e; border-color: #e94560; color: #e0e0e0; box-shadow: 0 0 0 .2rem rgba(233,69,96,.25); }
        .form-control::placeholder { color: #606080; }
        .btn-primary { background: #e94560; border-color: #e94560; }
        .btn-primary:hover { background: #c73652; border-color: #c73652; }
        .brand-title { color: #e94560; font-weight: 700; }
        .toast-container { position: fixed; top: 1rem; right: 1rem; z-index: 9999; }
    </style>
</head>
<body>
<div class="container">
    @if(session('toast_success'))
    <div class="toast-container">
        <div class="toast show align-items-center text-bg-success border-0">
            <div class="d-flex">
                <div class="toast-body"><i class="bi bi-check-circle me-2"></i>{{ session('toast_success') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5">
            <div class="auth-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <i class="bi bi-play-circle-fill text-danger fs-1"></i>
                    <h3 class="brand-title mt-2">AnimeTracker</h3>
                    <p class="text-muted small">Create your account</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger py-2">
                        <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="John Doe" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="you@example.com" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Min. 6 characters" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>

                <p class="text-center text-muted small mt-3">
                    Already have an account? <a href="{{ route('login') }}" class="text-danger">Login</a>
                </p>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.toast').forEach(t => {
        setTimeout(() => bootstrap.Toast.getOrCreateInstance(t).hide(), 4000);
    });
</script>
</body>
</html>
