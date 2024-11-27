<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.ico') }}" />
    <title>Redirecting...</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/redirect.css') }}">
</head>
<body>
    <div class="redirect-card">
        <!-- Safety Tips -->
        <div class="safety-tips" id="safety-tips">
            ⚠️ Safety Tip: Always check the domain of the link before visiting to ensure it's safe.
        </div>

        <!-- Redirect Card Content -->
        <img src="{{ asset('img/ndflogowhite.png') }}" alt="Logo">
        <div class="icon">
            <i class="bi bi-sign-turn-right-fill"></i>
        </div>
        <span class="title">Redirect Notice</span>
        <p class="description">You are being redirected to: <br><strong>{{ $targetUrl }}</strong> <br> in <span id="countdown">5</span> seconds...</p>
        <button class="accept">Stay on Page</button>
        <p class="footer">Create your own link <a href="{{ url('/') }}">here</a>.</p>
    </div>

    <script>
        let countdown = 5;
        const countdownElement = document.getElementById('countdown');
        const safetyTips = document.getElementById('safety-tips');
        let isPaused = false;
        let countdownInterval;

        setTimeout(() => {
            safetyTips.classList.add('show');
        }, 2000); 

        function startCountdown() {
            isPaused = false;
            countdownInterval = setInterval(function () {
                countdown--;
                countdownElement.textContent = countdown;
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    window.location.href = "{{ $targetUrl }}";
                }
            }, 1000);
        }

        startCountdown();

        document.querySelector('.accept').onclick = function () {
            if (isPaused) {
                this.textContent = "Stay on Page";
                startCountdown();
            } else {
                clearInterval(countdownInterval);
                countdownElement.textContent = "Cancelled";
                this.textContent = "Continue";
            }
            isPaused = !isPaused;
        };
    </script>
</body>
</html>
