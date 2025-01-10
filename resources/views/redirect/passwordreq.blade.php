<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.ico') }}" />
    <title>Password Protected</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/linksy.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.4/lottie.min.js"></script>
</head>
<body>
    <div class="card">
        <div class="logo">
            <img src="{{ asset('img/linksy.png') }}" alt="Logo">
        </div>
        <div class="ilustration">
            <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_LrcfNr.json" background="white" speed="1" loop autoplay></lottie-player>
        </div>
        <h3>Password Protected</h3>
        <p>This link requires a password to access.</p>
        <form method="POST" action="{{ route('link.redirect', $linkSlug) }}">
            @csrf
            <input type="password" name="password" class="input-field" placeholder="Enter Password" required>
            <button type="submit">Let Me In !</button>
        </form>
        @if ($errors->has('password'))
            <div class="error-message">{{ $errors->first('password') }}</div>
        @endif
    </div>
</body>
</html>