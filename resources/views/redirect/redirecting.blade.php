<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.ico') }}" />
    <title>{{ $title }}</title>
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
        <h3>Redirect Notice</h3>
        <div class="text-container">
            <img src="https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url={{ urlencode($targetUrl) }}&size=32" 
                alt="Favicon" >
            <p>
                You are being redirected to:<br>
                
                <strong>{{ $targetUrl }}</strong><br>
                in <span id="countdown">5</span> seconds...
            </p>
            
        </div>
        <div class="text-container">
            <p>
                Domain Trust: <strong id="domain-trust">Safe</strong>
            </p>
        </div>
        <button id="stay-button">Stay on Page</button>
    </div>

    <div class="cookie-popup" id="cookie-popup">
        <p>
            We use cookies to analyze our traffic. By using this site, you accept our use of cookies.
        </p>
        <button id="accept-cookies">Accept</button>
    </div>

    <script>
        let countdown = 5;
        const countdownElement = document.getElementById('countdown');
        const stayButton = document.getElementById('stay-button');
        const cookiePopup = document.getElementById('cookie-popup');
        const acceptCookiesButton = document.getElementById('accept-cookies');
        let isPaused = false;
        let countdownInterval;

        function startCountdown() {
            isPaused = false;
            countdownInterval = setInterval(() => {
                countdown--;
                countdownElement.textContent = countdown;
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    window.location.href = "{{ $targetUrl }}";
                }
            }, 1000);
        }

        startCountdown();

        stayButton.addEventListener('click', () => {
            if (isPaused) {
                stayButton.textContent = "Stay on Page";
                startCountdown();
            } else {
                clearInterval(countdownInterval);
                countdownElement.textContent = "Cancelled";
                stayButton.textContent = "Continue";
            }
            isPaused = !isPaused;
        });

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
