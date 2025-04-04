<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password | Arabisoft</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 640px;
            margin: 2rem auto;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            padding: 2rem;
            text-align: center;
        }
        .logo {
            max-width: 220px;
            height: auto;
            filter: brightness(0) invert(1);
        }
        .content {
            padding: 2.5rem;
            color: #374151;
        }
        h1 {
            color: #1e3a8a;
            font-size: 1.8rem;
            margin: 0 0 1.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .key-icon {
            font-size: 1.5rem;
        }
        p {
            line-height: 1.6;
            margin: 0 0 1.5rem 0;
            color: #4b5563;
        }
        .button {
            display: inline-block;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
            margin: 1.5rem 0;
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.2);
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(59, 130, 246, 0.3);
        }
        .footer {
            padding: 1.5rem;
            background-color: #f3f4f6;
            text-align: center;
            font-size: 0.875rem;
            color: #6b7280;
        }
        .security-note {
            background: #fef2f2;
            padding: 1rem;
            border-radius: 8px;
            margin: 1.5rem 0;
            display: flex;
            gap: 0.75rem;
            color: #dc2626;
        }
        .warning-icon {
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        @media (max-width: 640px) {
            .container {
                margin: 0;
                border-radius: 0;
            }
            .content {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://i.ibb.co.com/D1stnvk/Arabisoft-removebg-preview.png" 
                 alt="Arabisoft Logo" 
                 class="logo" />
        </div>
        
        <div class="content">
            <h1>
                <span class="key-icon">🔑</span>
                Reset Password Anda
            </h1>
            
            <p>Halo <strong>{{ $user->name }}</strong>,</p>
            <p>Kami menerima permintaan reset password untuk akun Anda. Klik tombol di bawah ini untuk melanjutkan proses reset password:</p>
            
            <a href="{{ url('/dashboard/profile/reset-password?token=' . $token) }}" 
               class="button">
                Atur Ulang Password
            </a>
            
            <div class="security-note">
                <span class="warning-icon">⚠️</span>
                <div>
                    <strong>Penting:</strong> Link ini akan kedaluwarsa dalam 60 menit. 
                    Jika Anda tidak melakukan permintaan ini, segera abaikan email ini dan 
                    periksa keamanan akun Anda.
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>© 2025 NDFProject. All rights reserved.</p>
            <p>Email auto-generated. Please do not reply.</p>
        </div>
    </div>
</body>
</html>