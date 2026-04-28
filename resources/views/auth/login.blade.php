<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - CineMax</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap" rel="stylesheet">
    <style>
        :root { --bg:#0d0d0f; --surface:#141417; --surface2:#1c1c21; --accent:#e8340a; --text:#f0eff4; --muted:rgba(240,239,244,0.5); --border:rgba(240,239,244,0.08); }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; min-height: 100vh; display: flex; flex-direction: column; }
        .navbar { background: rgba(13,13,15,0.85); border-bottom: 1px solid var(--border); padding: 0.9rem 0; }
        .navbar-brand { font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem; color: var(--accent) !important; letter-spacing: 2px; display:flex; align-items:center; gap:.4rem; text-decoration:none; }
        .nav-link { color: var(--muted) !important; font-size: .88rem; font-weight: 500; padding: .4rem 1rem !important; }
        .container { flex:1; display:flex; align-items:center; justify-content:center; padding:2rem; }
        .login-card { background: var(--surface); border:1px solid var(--border); border-radius:.75rem; padding:2rem; max-width:400px; width:100%; }
        .login-title { font-family:'Bebas Neue',sans-serif; font-size:2rem; color:var(--accent); text-align:center; margin-bottom:1.5rem; }
        .form-label { color: var(--text); font-weight:500; margin-bottom:.5rem; }
        .form-control { background:var(--surface2); border:1px solid var(--border); color:var(--text); border-radius:.4rem; padding:.75rem; }
        .btn-login { background:var(--accent); color:#fff; border:none; padding:.75rem 1.5rem; border-radius:.4rem; font-weight:600; width:100%; margin-top:1rem; }
        .register-link { text-align:center; margin-top:1rem; color:var(--muted); }
        .register-link a { color: var(--accent); text-decoration:none; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="/"><i class="bi bi-play-circle-fill"></i>CINEMAX</a>
            <div class="d-flex align-items-center gap-3">
                <a class="nav-link" href="/">Home</a>
                <a class="nav-link" href="/movies">Movies</a>
                @if(Auth::check())
                    <span class="navbar-text me-3">Welcome, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('register') }}" class="btn btn-light btn-sm me-2">Register</a>
                @endif
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="login-card">
            <h1 class="login-title">WELCOME BACK</h1>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                    @error('email')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn-login">Sign In</button>
            </form>
            <div class="register-link">New to CineMax? <a href="{{ route('register') }}">Create an account</a></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
