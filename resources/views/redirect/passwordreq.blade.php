<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.ico') }}" />
    <title>Password Protected</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: #eceff1;
            font-family: 'Fredoka', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background-color: #eceff1;
            border-radius: 30px;
            text-align: center;
            padding: 15px;
            max-width: 375px;
            margin: auto;
            box-shadow: 20px 20px 20px rgba(0, 0, 0, 0.1),
                        -20px -20px 20px rgba(255, 255, 255, 0.7);
        }

        .logo {
            margin-top: 20px;
        }

        .logo img {
            max-width: 150px;
        }

        .ilustration {
            margin: 30px;
        }

        .ilustration lottie-player {
            width: 200px;
            height: 200px;
            border-radius: 100%;
            overflow: hidden;
            margin: 0 auto;
            box-shadow: 20px 20px 20px rgba(0, 0, 0, 0.1),
                        -20px -20px 20px rgba(255, 255, 255, 0.7);
        }

        h3 {
            font-size: 2rem;
            line-height: 2.2rem;
            color: #4d4d4d;
            font-weight: bold;
            margin: 30px 0;
        }

        p {
            font-size: 1rem;
            line-height: 1.3rem;
            color: #6d6d6d;
            margin: 30px auto;
            max-width: 80%;
        }

        .input-field {
            width: 80%;
            padding: 10px;
            margin: 20px 0;
            border-radius: 20px;
            border: 1px solid #ccc;
            font-size: 1rem;
            text-align: center;
        }

        button {
            font-size: 1.1rem;
            font-weight: bold;
            padding: 15px 80px;
            border-radius: 25px;
            color: white;
            border: none;
            background-color: #81c784;
            margin: 30px 0;
            box-shadow: 10px 10px 10px rgba(129, 199, 132, 0.2),
                        -10px -10px 10px rgba(129, 199, 132, 0.2);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        button:hover {
            box-shadow: 20px 20px 20px rgba(129, 199, 132, 0.1),
                        -20px -20px 20px rgba(129, 199, 132, 0.1);
            transform: translateY(-3px);
        }

        button:active {
            transform: scale(0.9);
            box-shadow: inset -1px -1px 3px rgba(129, 199, 132, 0.3);
        }

        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-top: 10px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.4/lottie.min.js"></script>
</head>
<body>
    <div class="card">
        <div class="logo">
            <img src="{{ asset('img/ndflogo.png') }}" alt="Logo">
        </div>
        <div class="ilustration">
            <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_LrcfNr.json" background="white" speed="1" loop autoplay></lottie-player>
        </div>
        <h3>Password Protected</h3>
        <p>This link requires a password to access.</p>
        <form method="POST" action="{{ route('link.redirect', $linkSlug) }}">
            @csrf
            <input type="password" name="password" class="input-field" placeholder="Enter Password" required>
            <button type="submit">Submit</button>
        </form>
        @if ($errors->has('password'))
            <div class="error-message">{{ $errors->first('password') }}</div>
        @endif
    </div>
</body>
</html>