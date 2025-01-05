<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.ico') }}" />
    <title>Redirecting...</title>
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
            margin: 10px auto;
            max-width: 80%;
            text-align: center;
        }

        .text-container {
            max-width: 100%;
            overflow: hidden;
            word-wrap: break-word;
            word-break: break-word;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: auto; 
            margin: 0 auto; 
            padding: 10px; 
        }

        .text-container p {
            margin: 0; 
            overflow-wrap: break-word;
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

        .cookie-popup {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            padding: 15px;
            border-radius: 10px;
            display: none;
            z-index: 1000;
            text-align: center;
            max-width: 90%;
            width: 300px;
        }

        .cookie-popup p {
            font-size: 0.9rem;
            color: #6d6d6d;
            margin: 0 0 10px;
            max-width: 100%;
        }

        .cookie-popup button {
            font-size: 0.9rem;
            padding: 10px 20px;
            border-radius: 20px;
            background-color: #81c784;
            color: white;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .cookie-popup button:hover {
            background-color: #66bb6a;
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
        <h3>Redirect Notice</h3>
        <div class="text-container">
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
