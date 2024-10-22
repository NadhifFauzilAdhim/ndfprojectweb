<x-errorlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
        <div class="home__container container">
            <div class="home__data">
                <span class="home__subtitle"></span>
                <h1 class="home__title">{{ $message }}</h1>
                <p class="home__description">
                    Oops! It looks like this link is no longer active or doesn't exist. <br> 
                    Please check the URL or return to the homepage.
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