<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Login Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 10px 0;
        }
        .header img {
            height: 50px;
        }
        .content {
            padding: 20px;
        }
        .panel {
            background: #ffe6e6;
            padding: 15px;
            border-left: 4px solid #ff4d4d;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background: #ff4d4d;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://i.ibb.co/D1stnvk/Arabisoft-removebg-preview.png" alt="NDFPROJECT">
        </div>
        <div class="content">
            <h2>🔐 Notifikasi Login Baru</h2>
            <p>Hai <strong>{{ $user->name }}</strong>,</p>
            <p>Kami mendeteksi login ke akun Anda dari:</p>
            <ul>
                <li>🌍 <strong>IP Address:</strong> [IP Address]</li>
                <li>🕒 <strong>Waktu Login:</strong> [Login Time]</li>
            </ul>
            <div class="panel">
                <p><strong>Jika ini bukan Anda:</strong></p>
                <ul>
                    <li>Segera ubah password</li>
                    <li>Periksa aktivitas terakhir</li>
                    <li>Hubungi tim support kami</li>
                </ul>
            </div>
            <p style="text-align: center;">
                <a href="{{ route('password.update') }}" class="button">🔒 Ubah Password Sekarang</a>
            </p>
        </div>
        <div class="footer">
            © <script>document.write(new Date().getFullYear());</script> NDFProject. All rights reserved.<br>
        </div>
    </div>
</body>
</html>