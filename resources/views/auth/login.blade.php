<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In — CineMax</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#0d0d0f;--surface:#141417;--surface2:#1c1c21;--accent:#e8340a;--accent2:#ff6b35;--text:#f0eff4;--muted:rgba(240,239,244,.5);--border:rgba(240,239,244,.08);}
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        body{background:var(--bg);color:var(--text);font-family:'DM Sans',sans-serif;min-height:100vh;display:flex;flex-direction:column;overflow:hidden;}
        .bg-glow{position:fixed;inset:0;z-index:0;background:radial-gradient(ellipse 90% 70% at 80% 50%,rgba(232,52,10,.07) 0%,transparent 65%),radial-gradient(ellipse 60% 60% at 10% 80%,rgba(232,52,10,.04) 0%,transparent 60%),var(--bg);}
        .bg-glow::before{content:'';position:fixed;inset:0;background-image:repeating-linear-gradient(90deg,transparent,transparent 60px,rgba(255,255,255,.012) 60px,rgba(255,255,255,.012) 61px);pointer-events:none;}
        .navbar{position:relative;z-index:10;background:rgba(13,13,15,.7);backdrop-filter:blur(20px);border-bottom:1px solid var(--border);padding:.85rem 0;}
        .navbar-brand{font-family:'Bebas Neue',sans-serif;font-size:1.8rem;color:var(--accent)!important;letter-spacing:2px;text-decoration:none;display:flex;align-items:center;gap:.4rem;}
        .brand-dot{width:8px;height:8px;background:var(--accent);border-radius:50%;display:inline-block;animation:pulse-dot 2s ease-in-out infinite;}
        @keyframes pulse-dot{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.4;transform:scale(.7)}}
        .nav-link{color:var(--muted)!important;font-size:.88rem;font-weight:500;padding:.4rem 1rem!important;transition:color .2s;}
        .nav-link:hover{color:var(--text)!important;}
        .auth-wrap{position:relative;z-index:5;flex:1;display:flex;align-items:center;justify-content:center;padding:2rem 1rem;}
        .auth-card{background:rgba(20,20,23,.88);backdrop-filter:blur(24px);border:1px solid var(--border);border-radius:1.25rem;padding:2.5rem 2.25rem;width:100%;max-width:420px;box-shadow:0 30px 80px rgba(0,0,0,.5),0 0 0 1px rgba(255,255,255,.03);animation:slideUp .45s ease both;}
        @keyframes slideUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
        .auth-logo{text-align:center;margin-bottom:1.75rem;}
        .auth-logo-icon{width:56px;height:56px;background:rgba(232,52,10,.12);border:1px solid rgba(232,52,10,.3);border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:1.5rem;color:var(--accent);margin-bottom:1rem;}
        .auth-title{font-family:'Bebas Neue',sans-serif;font-size:2rem;letter-spacing:2px;color:var(--text);line-height:1;}
        .auth-sub{color:var(--muted);font-size:.875rem;margin-top:.35rem;}
        .alert-c{border-radius:.6rem;padding:.75rem 1rem;font-size:.85rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:.5rem;}
        .alert-ok{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.25);color:#4ade80;}
        .alert-err{background:rgba(232,52,10,.1);border:1px solid rgba(232,52,10,.25);color:#ff7350;}
        .field-group{margin-bottom:1.1rem;}
        .field-label{font-size:.82rem;font-weight:600;color:var(--muted);margin-bottom:.35rem;letter-spacing:.3px;}
        .field-wrap{position:relative;}
        .field-icon{position:absolute;left:.9rem;top:50%;transform:translateY(-50%);color:var(--muted);font-size:1rem;pointer-events:none;transition:color .2s;}
        .field-input{width:100%;padding:.7rem .85rem .7rem 2.5rem;background:var(--surface2);border:1px solid var(--border);border-radius:.5rem;color:var(--text);font-family:'DM Sans',sans-serif;font-size:.9rem;transition:border-color .2s,box-shadow .2s;}
        .field-input:focus{outline:none;border-color:rgba(232,52,10,.5);box-shadow:0 0 0 3px rgba(232,52,10,.1);}
        .field-input::placeholder{color:var(--muted);}
        .field-wrap:focus-within .field-icon{color:var(--accent);}
        .pw-toggle{position:absolute;right:.9rem;top:50%;transform:translateY(-50%);color:var(--muted);cursor:pointer;font-size:1rem;background:none;border:none;padding:0;transition:color .2s;}
        .pw-toggle:hover{color:var(--text);}
        .field-error{font-size:.78rem;color:#ff7350;margin-top:.3rem;}
        .btn-auth{width:100%;padding:.75rem;background:var(--accent);color:#fff;border:none;border-radius:.5rem;font-family:'DM Sans',sans-serif;font-weight:700;font-size:.95rem;cursor:pointer;margin-top:1.25rem;transition:background .2s,transform .15s,box-shadow .2s;display:flex;align-items:center;justify-content:center;gap:.5rem;}
        .btn-auth:hover{background:#c42908;transform:translateY(-1px);box-shadow:0 8px 24px rgba(232,52,10,.3);}
        .auth-footer{text-align:center;margin-top:1.5rem;color:var(--muted);font-size:.875rem;}
        .auth-footer a{color:var(--accent);text-decoration:none;font-weight:600;}
        .auth-footer a:hover{color:var(--accent2);}
        .nav-btn{background:transparent;border:1px solid var(--border);color:var(--text);border-radius:.4rem;padding:.35rem .9rem;font-size:.85rem;text-decoration:none;transition:background .2s;}
        .nav-btn:hover{background:rgba(255,255,255,.05);color:var(--text);}
    </style>
</head>
<body>
<div class="bg-glow"></div>
<nav class="navbar">
    <div class="container-fluid px-4 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <a class="navbar-brand" href="/"><i class="bi bi-play-circle-fill"></i> CINEMAX <span class="brand-dot"></span></a>
            <a class="nav-link" href="/">Home</a>
            <a class="nav-link" href="{{ route('movies.index', ['status'=>'now-showing']) }}">Movies</a>
        </div>
        <a href="{{ route('register') }}" class="nav-btn">Register</a>
    </div>
</nav>
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-logo">
            <div class="auth-logo-icon"><i class="bi bi-play-circle-fill"></i></div>
            <div class="auth-title">WELCOME BACK</div>
            <div class="auth-sub">Sign in to your CineMax account</div>
        </div>

        @if(session('success'))
            <div class="alert-c alert-ok"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-c alert-err"><i class="bi bi-exclamation-triangle-fill"></i> {{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="field-group">
                <div class="field-label">Email Address</div>
                <div class="field-wrap">
                    <i class="bi bi-envelope field-icon"></i>
                    <input type="email" name="email" id="email" class="field-input" placeholder="you@example.com" value="{{ old('email') }}" required>
                </div>
            </div>
            <div class="field-group">
                <div class="field-label">Password</div>
                <div class="field-wrap">
                    <i class="bi bi-lock field-icon"></i>
                    <input type="password" name="password" id="password" class="field-input" placeholder="••••••••" required>
                    <button type="button" class="pw-toggle" onclick="togglePw('password',this)"><i class="bi bi-eye-slash"></i></button>
                </div>
            </div>
            <button type="submit" class="btn-auth"><i class="bi bi-box-arrow-in-right"></i> Sign In</button>
        </form>
        <div class="auth-footer">New to CineMax? <a href="{{ route('register') }}">Create an account</a></div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePw(id,btn){const i=document.getElementById(id),ic=btn.querySelector('i');if(i.type==='password'){i.type='text';ic.classList.replace('bi-eye-slash','bi-eye');}else{i.type='password';ic.classList.replace('bi-eye','bi-eye-slash');}}
</script>
</body>
</html>
