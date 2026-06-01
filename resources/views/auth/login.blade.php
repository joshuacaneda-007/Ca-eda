<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AnimeTracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f0f4ff; min-height: 100vh; display: flex; align-items: center; }
        .auth-card { background: #fff; border: 1px solid #dde3f0; border-radius: 16px; box-shadow: 0 4px 24px rgba(79,110,247,.1); }
        .form-control { background: #f8faff; border: 1px solid #dde3f0; color: #1e2a45; }
        .form-control:focus { background: #fff; border-color: #4f6ef7; color: #1e2a45; box-shadow: 0 0 0 .2rem rgba(79,110,247,.15); }
        .form-control::placeholder { color: #aab4cc; }
        .btn-primary { background: #4f6ef7; border-color: #4f6ef7; }
        .btn-primary:hover { background: #3a57e8; border-color: #3a57e8; }
        .brand-title { color: #4f6ef7; font-weight: 700; }
        .toast-container { position: fixed; top: 1rem; right: 1rem; z-index: 9999; }
        .form-label { color: #7a8aaa; font-size: .83rem; font-weight: 500; }
        .form-check-label { color: #7a8aaa; font-size: .85rem; }
    </style>
</head>
<body>
<div class="container">
    @if(session('toast_success'))
    <div class="toast-container">
        <div class="toast show align-items-center text-bg-success border-0 shadow">
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
                    <i class="bi bi-play-circle-fill fs-1" style="color:#4f6ef7"></i>
                    <h3 class="brand-title mt-2">AnimeTracker</h3>
                    <p class="text-muted small">Sign in to your account</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger py-2">
                        <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="you@example.com" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Your password" required>
                    </div>
                    <div class="mb-4 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <p class="text-center text-muted small mt-3">
                    No account yet? <a href="{{ route('register') }}" style="color:#4f6ef7">Register</a>
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
