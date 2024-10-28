<x-errorlayout>
    <x-slot:title>{{ "404" }}</x-slot:title>
        <div class="home__container container">
            <div class="home__data">
                <span class="home__subtitle">Error 404</span>
                <h1 class="home__title">Page Not Found &#128546</h1>
                <p class="home__description">
                    We can't seem to find the page <br> you are looking for.
                </p>
                <a href="{{ route('home') }}" class="home__button">
                    Go Home
                </a>
            </div>

            <div class="home__img">
                <img src="{{ asset('img/ghost-img.png') }}" alt="">
                <div class="home__shadow"></div>
            </div>
        </div>
</x-errorlayout>