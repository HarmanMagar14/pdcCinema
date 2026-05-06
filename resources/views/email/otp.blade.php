<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineMax OTP Code</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background-color: #0d0d0f;
            font-family: Arial, Helvetica, sans-serif;
            color: #f0eff4;
            padding: 0;
            margin: 0;
        }
        .email-wrapper {
            background-color: #0d0d0f;
            padding: 32px 16px;
            min-height: 100vh;
        }
        .email-container {
            max-width: 520px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #1a0a07 0%, #2d0f05 50%, #1a0a07 100%);
            border: 1px solid rgba(232,52,10,0.3);
            border-radius: 16px 16px 0 0;
            padding: 36px 32px 28px;
            text-align: center;
        }
        .brand-logo {
            font-size: 26px;
            font-weight: 900;
            color: #e8340a;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .brand-tagline {
            font-size: 11px;
            color: rgba(240,239,244,0.35);
            letter-spacing: 3px;
            text-transform: uppercase;
        }
        .divider-line {
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #e8340a, transparent);
            margin: 18px auto;
        }
        .lock-icon {
            font-size: 40px;
            margin-bottom: 12px;
        }
        .header-title {
            font-size: 24px;
            font-weight: 900;
            color: #f0eff4;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .header-sub {
            font-size: 13px;
            color: rgba(240,239,244,0.45);
            line-height: 1.6;
        }

        /* OTP Body */
        .otp-body {
            background: #141417;
            border-left: 1px solid rgba(240,239,244,0.07);
            border-right: 1px solid rgba(240,239,244,0.07);
            padding: 36px 32px;
            text-align: center;
        }
        .otp-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: rgba(240,239,244,0.35);
            margin-bottom: 14px;
        }
        .otp-code {
            display: inline-block;
            background: linear-gradient(135deg, rgba(232,52,10,0.12) 0%, rgba(255,107,53,0.06) 100%);
            border: 2px solid rgba(232,52,10,0.45);
            border-radius: 12px;
            padding: 18px 36px;
            font-size: 42px;
            font-weight: 900;
            font-family: 'Courier New', Courier, monospace;
            color: #e8340a;
            letter-spacing: 12px;
            margin-bottom: 20px;
        }
        .expiry-badge {
            display: inline-block;
            background: rgba(245,197,24,0.08);
            border: 1px solid rgba(245,197,24,0.25);
            color: #f5c518;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 6px 16px;
            border-radius: 20px;
            margin-bottom: 20px;
        }
        .otp-instruction {
            font-size: 14px;
            color: rgba(240,239,244,0.45);
            line-height: 1.6;
        }

        /* Security note */
        .security-box {
            background: #141417;
            border-left: 1px solid rgba(240,239,244,0.07);
            border-right: 1px solid rgba(240,239,244,0.07);
            padding: 0 32px 24px;
        }
        .security-inner {
            background: rgba(240,239,244,0.03);
            border: 1px solid rgba(240,239,244,0.07);
            border-radius: 10px;
            padding: 14px 18px;
            font-size: 12px;
            color: rgba(240,239,244,0.4);
            line-height: 1.7;
            text-align: left;
        }
        .security-inner strong {
            color: rgba(240,239,244,0.6);
        }

        /* Footer */
        .footer {
            background: #0a0a0c;
            border: 1px solid rgba(240,239,244,0.05);
            border-top: none;
            border-radius: 0 0 16px 16px;
            padding: 24px 32px;
            text-align: center;
        }
        .footer-note {
            font-size: 12px;
            color: rgba(240,239,244,0.3);
            line-height: 1.6;
            margin-bottom: 10px;
        }
        .footer-brand {
            font-size: 10px;
            color: rgba(240,239,244,0.15);
            letter-spacing: 2px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
<div class="email-wrapper">
<div class="email-container">

    {{-- ── HEADER ── --}}
    <div class="header">
        <div class="brand-logo">&#9654; CINEMAX</div>
        <div class="brand-tagline">Premium Cinema Experience</div>
        <div class="divider-line"></div>
        <div class="lock-icon">&#128274;</div>
        <div class="header-title">Verify Your Account</div>
        <div class="header-sub">
            Enter this one-time password to complete<br>your CineMax registration.
        </div>
    </div>

    {{-- ── OTP CODE ── --}}
    <div class="otp-body">
        <div class="otp-label">Your One-Time Password</div>
        <div class="otp-code">{{ $otp }}</div>
        <div><div class="expiry-badge">&#9201; Expires in 10 minutes</div></div>
        <div class="otp-instruction">
            Enter this code in the verification screen to activate your account.<br>
            Do not share this code with anyone.
        </div>
    </div>

    {{-- ── SECURITY NOTE ── --}}
    <div class="security-box">
        <div class="security-inner">
            <strong>&#9888; Security Notice:</strong> CineMax will never ask for your OTP via phone, chat, or email.
            If you did not request this code, please ignore this message &mdash; your account remains secure.
        </div>
    </div>

    {{-- ── FOOTER ── --}}
    <div class="footer">
        <div class="footer-note">
            This is an automated message from CineMax. Please do not reply directly to this email.
        </div>
        <div class="footer-brand">&copy; {{ date('Y') }} CineMax &bull; All rights reserved</div>
    </div>

</div>
</div>
</body>
</html>