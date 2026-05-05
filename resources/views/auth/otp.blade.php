<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Verify OTP - CineMax</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --bg:#0d0d0f; --surface:#141417; --accent:#e8340a; --text:#f0eff4; --border:rgba(240,239,244,0.08); }
        body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; min-height:100vh; display:flex; align-items:center; justify-content:center; }
        .otp-card { background: var(--surface); border:1px solid var(--border); border-radius:.75rem; padding:2rem; max-width:380px; width:100%; }
        .otp-title { font-size:1.8rem; color:var(--accent); text-align:center; margin-bottom:1rem; font-weight:700; }
        .form-control { background:#1c1c21; border:1px solid var(--border); color:var(--text); border-radius:.4rem; padding:.75rem; text-align:center; font-size:1.5rem; letter-spacing:8px; }
        .btn-verify { background:var(--accent); color:#fff; border:none; padding:.85rem; border-radius:.4rem; font-weight:600; width:100%; margin-top:1rem; }
    </style>
</head>
<body>
    <div class="otp-card">
        <h1 class="otp-title">Enter OTP</h1>
        <p class="text-center text-muted mb-3">We sent a 6-digit code to <strong>{{ session('otp_email') }}</strong></p>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf
            <div class="mb-3">
                <input type="text" class="form-control" name="otp" maxlength="6" placeholder="000000" autofocus>
                @error('otp')<div class="text-danger mt-1">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn-verify">Verify</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('register') }}" style="color:#e8340a;">Back to Register</a>
        </div>
    </div>
</body>
</html>