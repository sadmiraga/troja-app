@extends('layouts.landingLayout')

@section('content')

    <section class="banner">
        <div class="banner__transition"></div>
    </section>
    <section class="featured-food-list">
        <img class="featured-food-list__item" src="images/food1.png">
        <img class="featured-food-list__item" src="images/food2.png">
        <img class="featured-food-list__item" src="images/food3.png">
        <img class="featured-food-list__item" src="images/food4.png">
    </section>
    <section class="paralax --food-bg">
        <div class="paralax__overlay">
            <a href="meni?page=1">
                <button class="btn-menu">Poglej ponudbo hrane</button>
            </a>
        </div>
    </section>
    <section class="featured-drinks-list">
        <img class="featured-drinks-list__item" src="images/drinks1.png">
        <img class="featured-drinks-list__item" src="images/drinks2.png">
        <img class="featured-drinks-list__item" src="images/drinks3.png">
        <img class="featured-drinks-list__item" src="images/drinks4.png">
    </section>
    <section class="paralax --drinks-bg">
        <div class="paralax__overlay">
            <a href="meni?page=2">
                <button class="btn-menu">Poglej ponudbo pijače</button>
            </a>
        </div>
    </section>
    <section class="catering">
        <h2 class="catering__header secular">Vaš Zanesljiv Partner za Dogodke: <br>FNX Kavarna & Bistro
        </h2>
        <div class="catering__content">
            <div class="catering__images">
                <img class="catering__image" src="images/catering1.png">
                <img class="catering__image" src="images/catering2.png">
            </div>
            <p class="catering__text ruda">Naše vabljivo vzdušje je popolno za vsak dan ali posebne dogodke, saj ponuja
                živahno prizorišče za poslovna srečanja, kosila in več. Z možnostmi samopostrežnih ali katerih menijev, ki
                vključujejo vrsto jedi od žara, juh, predjedi in naših znanih samopostrežnih ter prigrizkov, bo vaš dogodek
                zagotovo pustil trajen vtis. V FNX prilagajamo vaš dogodek vašim željam, zagotavljamo nepozabno izkušnjo za
                vse. Raziščite naše edinstvene ponudbe in dovolite, da naše storitve cateringa nadgradijo vaše doživetje
                dogodka.
            </p>
        </div>
        <div class="catering__button-container">
            <a href="catering">
                <button class="catering__button">Poglej catering ponudbo</button>
            </a>
        </div>
    </section>
    <section class="events">
        <!-- EVENTS -->
        @if (count($events) != 0)
            <h2 class="events__header secular">Dogodki</h2>
            <div class="swiper-container">
                <div class="swiper-arrow nav-left">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l14 0" />
                        <path d="M5 12l4 4" />
                        <path d="M5 12l4 -4" />
                    </svg>
                </div>
                <div class="event-swiper swiper">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">

                        @foreach ($events as $event)
                            <div class="swiper-slide">
                                <img class="events__event-image" src="images_dynamic/events/{{ $event->image }}">
                                <div class="events__event-text montserrat">
                                    <h3 class="events__event-title">{{ $event->name }}</h3>
                                    <div class="events__event-info">
                                        <div class="events__event-date">{{ formatDate($event->date) }} -
                                            {{ formatTime($event->time) }}</div>
                                        @if ($event->price == 0)
                                            <div class="events__event-price">prosti vstop</div>
                                        @else
                                            <div class="events__event-price">{{ $event->price }} €</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-arrow nav-right">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-right"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l14 0" />
                        <path d="M15 16l4 -4" />
                        <path d="M15 8l4 4" />
                    </svg>
                </div>
            </div>
        @endif
    </section>
    <section class="visit-us">
        <h2 class="visit-us__heading ruda">Obiščite nas</h2>
        <div class="visit-us__map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d173.02560460810565!2d14.565931677023123!3d46.06287188802823!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47653217073b5b4d%3A0x45f179521f0fdfcc!2sFNX%20Kavarna%20%26%20Bistro!5e0!3m2!1sen!2ssi!4v1690781576228!5m2!1sen!2ssi"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

@endsection
