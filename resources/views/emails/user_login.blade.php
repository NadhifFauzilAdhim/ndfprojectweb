<!DOCTYPE html>
<html>
<head>
    <title>New Login Detected</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #f3f4f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 200px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #f9fafb;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .detail-box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }
        .detail-item {
            margin-bottom: 15px;
        }
        .warning {
            color: #dc2626;
            background-color: #fef2f2;
            padding: 15px;
            border-radius: 6px;
            margin-top: 25px;
            border: 1px solid #fecaca;
        }
        .button {
            display: inline-block;
            background-color: #3b82f6;
            color: white !important;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="color: #1f2937; margin: 0;">New Login Detected ⚠️</h1>
    </div>

    <div class="content">
        <p style="font-size: 16px;">Hello, {{ $user->name }}!</p>
        <p style="font-size: 15px; color: #4b5563;">We detected a new login to your account:</p>

        <div class="detail-box">
            <div class="detail-item">
                <strong>IP Address:</strong> {{ $ipAddress }}
            </div>
            <div class="detail-item">
                <strong>Login Time:</strong> {{ $loginTime }}
            </div>
            <div class="detail-item">
                <strong>Browser:</strong> {{ $browser }}
            </div>
        </div>

        <div class="warning">
            <p style="margin: 0; font-size: 14px;">
                If this was not you, please secure your account immediately by clicking the button below:
            </p>
            <a href="{{ route('password.request') }}" class="button">
                Change Password
            </a>
        </div>

        <p style="font-size: 14px; color: #6b7280; margin-top: 30px;">
            If you have any questions, contact our support team  
        </p>
    </div>

    <footer style="text-align: center; color: #6b7280; font-size: 12px; margin-top: 30px;">
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </footer>
</body>
</html>