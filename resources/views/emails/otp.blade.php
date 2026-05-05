<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #333;
            margin: 0;
        }
        .otp-code {
            text-align: center;
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .otp-code .code {
            font-size: 32px;
            font-weight: bold;
            color: #007bff;
            letter-spacing: 4px;
        }
        .message {
            color: #666;
            line-height: 1.6;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            color: #999;
            font-size: 12px;
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>CineMax</h1>
            <p>OTP Verification Code</p>
        </div>

        <div class="message">
            <p>Hello,</p>
            <p>Your One-Time Password (OTP) for CineMax is:</p>
        </div>

        <div class="otp-code">
            <div class="code">{{ $otp }}</div>
        </div>

        <div class="message">
            <p>This code will expire in 10 minutes.</p>
            <p>If you did not request this code, please ignore this email.</p>
            <p>Do not share this code with anyone.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} CineMax. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
