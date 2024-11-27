<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Protected</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/redirect.css') }}">
</head>
<body >
    <body class="bg-gradient-center">
        <div class="redirect-card">
            <img class="img-logo" src="{{ asset('img/ndflogowhite.png') }}" alt="Logo">
            <h2 class="title">Password Protected</h2>
            <p class="description">This link requires a password to access.</p>
            <form method="POST" action="{{ route('link.redirect', $linkSlug) }}">
                @csrf
                <input type="password" name="password" class="input-field" placeholder="Enter Password" required>
                <button type="submit" class="submit-btn">Submit</button>
            </form>
            @if ($errors->has('password'))
                <div class="error-message">{{ $errors->first('password') }}</div>
            @endif
        </div>
    </body>
</body>
</html>
