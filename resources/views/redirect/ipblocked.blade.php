<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.ico') }}" />
    <title>Access Denied</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.4/lottie.min.js"></script>
</head>
<body>
    <div class="card">
        <div class="logo">
            <img src="{{ asset('img/linksy.png') }}" alt="Logo">
        </div>
        <div class="ilustration">
            <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_pNx6yH.json" background="white" speed="1" loop autoplay></lottie-player>
        </div>
        <h3>Access Denied</h3>
        <div class="text-container">
            <p>
                Your IP address has been blocked due to suspicious activity or policy violations.
            </p>
            <p>
                If you believe this is a mistake, please contact support for further assistance.
            </p>
        </div>
        <button onclick="window.location.href='{{ url('/support') }}'">Contact Support</button>
    </div>

    <div class="cookie-popup" id="cookie-popup">
        <p>
            We use cookies to analyze our traffic. By using this site, you accept our use of cookies.
        </p>
        <button id="accept-cookies">Accept</button>
    </div>

    <script>
        const cookiePopup = document.getElementById('cookie-popup');
        const acceptCookiesButton = document.getElementById('accept-cookies');

        function showCookiePopup() {
            if (!document.cookie.includes("cookiesAccepted=true")) {
                cookiePopup.style.display = 'block';
            }
        }

        acceptCookiesButton.addEventListener('click', () => {
            document.cookie = "cookiesAccepted=true; path=/; max-age=" + 60 * 60 * 24 * 365;
            cookiePopup.style.display = 'none';
        });

        showCookiePopup();
    </script>
</body>
</html>
