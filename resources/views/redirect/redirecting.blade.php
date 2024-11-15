<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.ico') }}" />
    <title>Redirecting</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .redirect-card {
            max-width: 320px;
            padding: 1.5rem;
            background: rgba(31, 41, 55, 0.85); /* Warna transparan */
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Bayangan ringan */
            text-align: center;
            font-family: 'Poppins', sans-serif;
            word-wrap: break-word;
            color: #ffffff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
    
        .redirect-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25); /* Efek bayangan lebih intens */
        }
    
        .redirect-card img {
            max-width: 50%;
            height: auto;
            margin: 0 auto 1rem;
            display: block;
            border-radius: 10px;
            transition: transform 0.3s ease;
            opacity: 0.9; /* Sedikit transparan agar lebih menyatu */
        }
    
        .redirect-card img:hover {
            transform: scale(1.05);
        }
    
        .title {
            font-weight: 600;
            font-size: 1.25rem;
            color: #d1e8e2;
        }
    
        .description {
            margin-top: 0.75rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            color: #cbd5e0; /* Warna teks lebih terang untuk kontras */
        }
    
        .accept {
            font-size: 0.75rem;
            line-height: 1rem;
            background: rgba(75, 85, 99, 0.9); /* Tombol semi-transparan */
            font-weight: 500;
            border-radius: 0.5rem;
            color: #ffffff;
            padding: 0.625rem 1.25rem;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
            margin-top: 1rem;
        }
    
        .accept:hover {
            background: rgba(107, 114, 128, 0.95); /* Warna lebih terang saat di-hover */
            transform: scale(1.05);
        }
    
        .footer {
            margin-top: 2rem;
            font-size: 0.75rem;
            color: rgba(203, 213, 224, 0.7); /* Warna lebih terang agar tampak menyatu */
            text-align: center;
        }
    </style>
  
</head>
    <body style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background: linear-gradient(135deg, #0f2027, #203a43, #2c5364); flex-direction: column;">
        <div class="redirect-card">
            <img src="{{ asset('img/ndflogowhite.png') }}" alt="image">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sign-turn-right-fill" viewBox="0 0 16 16">
                <path d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM9 8.466V7H7.5A1.5 1.5 0 0 0 6 8.5V11H5V8.5A2.5 2.5 0 0 1 7.5 6H9V4.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L9.41 8.658A.25.25 0 0 1 9 8.466"/>
            </svg>
            <span class="title">Redirect Notice</span>
            <p class="description">You are being redirected to {{ $targetUrl }} in <br> <span id="countdown">5</span> seconds...</p>
            <button class="accept">Stay on page</button>
            <p>create your own link on <a href="{{ url('/') }}">here</a></p>
        </div>

        <script>
            let countdown = 5; 
            const countdownElement = document.getElementById('countdown');
            let isPaused = false; 
            function startCountdown() {
                isPaused = false;
                countdownInterval = setInterval(function() {
                    countdown--;
                    countdownElement.textContent = countdown;
                    if (countdown <= 0) {
                        clearInterval(countdownInterval);
                        window.location.href = "{{ $targetUrl }}";
                    }
                }, 1000);
            }
            startCountdown();    
            document.querySelector('.accept').onclick = function() {
                if (isPaused) {
                    this.textContent = "Stay on page";
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
