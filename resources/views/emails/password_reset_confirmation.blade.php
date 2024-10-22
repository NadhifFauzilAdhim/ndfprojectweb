<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        p {
            color: #555;
            line-height: 1.5;
        }
        a.button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff; /* Bootstrap primary color */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        a.button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        footer {
            margin-top: 30px;
            font-size: 12px;
            color: #888;
            text-align: center;
        }
        /* Style for the logo */
        .logo {
            max-width: 50%; /* Responsive width */
            height: auto; /* Maintain aspect ratio */
            display: block; /* Center image in email */
            margin: 0 auto; /* Center the image */
        }
    </style>
</head>
<body>
    <div class="container">
        <img
            src="https://i.ibb.co.com/D1stnvk/Arabisoft-removebg-preview.png"
            alt="Arabisoft"
            class="logo"
        />
        <h1>Hai {{ $user->name }},</h1>
        <p>
            Kami menerima permintaan untuk mereset password Anda. Silakan klik
            tombol di bawah ini untuk melanjutkan ke halaman perubahan password:
        </p>
        <a
            href="{{ url('/dashboard/profile/reset-password?token=' . $token) }}"
            class="button"
        >Ganti Password</a>
        <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
    </div>
    <footer>
        <p>Terima kasih,<br />NDFProject</p>
    </footer>
</body>
</html>
