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
            padding: 1rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 20px 20px 30px rgba(0, 0, 0, .05);
            text-align: center;
            font-family: 'Poppins', sans-serif;
        }

        .title {
            font-weight: 600;
            color: rgb(31, 41, 55);
        }

        .description {
            margin-top: 1rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            color: rgb(75, 85, 99);
        }

        .accept {
            font-size: 0.75rem;
            line-height: 1rem;
            background-color: rgb(17, 24, 39);
            font-weight: 500;
            border-radius: 0.5rem;
            color: #fff;
            padding: 0.625rem 1rem;
            border: none;
            transition: all .15s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            margin-top: 1rem;
        }

        .accept:hover {
            background-color: rgb(55, 65, 81);
        }

        .footer {
            margin-top: 2rem;
            font-size: 0.75rem;
            color: rgb(107, 114, 128);
            text-align: center;
        }
    </style>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f5f5f5; flex-direction: column;">

    <div class="redirect-card">
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

        const interval = setInterval(function() {
            countdown--;
            countdownElement.textContent = countdown;
            if (countdown <= 0) {
                clearInterval(interval);
                window.location.href = "{{ $targetUrl }}";
            }
        }, 1000);

        document.querySelector('.accept').onclick = function() {
            clearInterval(interval);
            countdownElement.textContent = "Cancelled";
        };
    </script>

</body>
</html>
