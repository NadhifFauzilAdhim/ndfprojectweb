<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #2c5364, #203a43, #0f2027);
            color: #ffffff;
            margin: 0;
        }
        .password-card {
            background: rgba(31, 41, 55, 0.85);
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .password-card input {
            width: 100%;
            padding: 0.5rem;
            margin-top: 1rem;
            border-radius: 8px;
            border: none;
        }
        .password-card button {
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background-color: #1d4ed8;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .password-card button:hover {
            background-color: #2563eb;
        }
        .error-message {
            color: #f87171;
            margin-top: 1rem;
        }
        .img-logo{
            width: 200px;
        }
    </style>
</head>
<body >
    <div class="password-card">
        <h2>Access Denied</h2>
        <p>{{ $message }}</p>
    </div>
</body>
</html>
