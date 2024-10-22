<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.ico') }}" />
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="{{ asset('css/error.css') }}">
        <title>{{ $title }}</title>
    </head>
    <body>
        <header class="header">
            <nav class="nav container">
                <a href="#" class="nav__logo">
                    <img src="{{ asset('img/ndflogo.png') }}" width="125px" alt="">
                </a>

                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="{{ route('home') }}" class="nav__link">Home</a>
                        </li>
                        <li class="nav__item">
                            <a href="{{ route('home') }}" class="nav__link">About</a>
                        </li>
                        <li class="nav__item">
                            <a href="{{ route('home') }}" class="nav__link">Contact</a>
                        </li>
                    </ul>

                    <div class="nav__close" id="nav-close">
                        <i class='bx bx-x'></i>
                    </div>
                </div>
                <div class="nav__toggle" id="nav-toggle">
                    <i class='bx bx-grid-alt'></i>
                </div>
            </nav>
        </header>
        <main class="main">
            <section class="home">
           {{ $slot }}
                <footer class="home__footer"> 
                    <span>ndfproject.my.id | All Rights Reserved</span>
                </footer>
            </section>
        </main>
        <script src="assets/vendor/scrollreveal/scrollreveal.min.js"></script>
        <script src="assets/vendor/scrollreveal/errormain.js"></script>
    </body>
</html>