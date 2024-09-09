<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>FNX Café &amp; bistro - Odlično vzdušje in vrhunska ponudba</title>
    <meta name="description"
        content="Kavarna FNX vas vsakodnevno razvaja z izvrstnimi toplimi napitki, izbranimi pijačami, skrbno pripravljenimi koktejli, ki vas v družbi sproščujoče glasbe" />
    <meta name="robots" content="index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large" />
    <link rel="canonical" href="https://fnx.si/" />
    <meta property="og:locale" content="sl_SI" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="FNX Café &amp; bistro - Odlično vzdušje in vrhunska ponudba" />
    <meta property="og:description"
        content="Kavarna FNX vas vsakodnevno razvaja z izvrstnimi toplimi napitki, izbranimi pijačami, skrbno pripravljenimi koktejli, ki vas v družbi sproščujoče glasbe" />
    <meta property="og:url" content="https://fnx.si/" />
    <meta property="og:site_name" content="FNX" />
    <meta property="og:updated_time" content="2023-09-30T08:06:21+00:00" />
    <meta property="article:published_time" content="2020-11-26T08:53:45+00:00" />
    <meta property="article:modified_time" content="2021-04-30T08:06:21+00:00" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="FNX Café &amp; bistro - Odlično vzdušje in vrhunska ponudba" />
    <meta name="twitter:description"
        content="Kavarna FNX vas vsakodnevno razvaja z izvrstnimi toplimi napitki, izbranimi pijačami, skrbno pripravljenimi koktejli, ki vas v družbi sproščujoče glasbe" />

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/landing.css') }}" rel="stylesheet">

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
</head>

<body>
    <div class="navbar">
        <a class="navbar__mobile-logo" href="/">
            <img src="images/logo.png" alt="logo">
        </a>
        <div class="navbar__links">
            <a class="navbar__link ruda" href="najem-prostora">Najem prostora</a>
            <a class="navbar__link ruda" href="meni?page=1">Redna ponudba</a>
            <a class="navbar__logo" href="/">
                <img src="images/logo.png" alt="logo">
            </a>
            <a class="navbar__link ruda" href="meni?page=3">Tedenska ponudba</a>
            <a class="navbar__link ruda" href="catering">Catering</a>
            <div class="navbar__link navbar__socials">
                <a href="https://www.facebook.com/fnx.si" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 12 24"
                        fill="none">
                        <path
                            d="M9.75085 3.96177H11.9286V0.168015C11.5529 0.116318 10.2608 0 8.75589 0C5.61593 0 3.46498 1.97542 3.46498 5.60613V8.94754H0V13.1887H3.46498V23.8601H7.71321V13.1897H11.038L11.5658 8.94853H7.71222V6.02666C7.71321 4.80085 8.04321 3.96177 9.75085 3.96177Z"
                            fill="white" />
                    </svg>
                </a>
                <a href="https://www.instagram.com/fnxbistro/" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 27 27"
                        fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M8.26432 0H18.1815C22.7451 0 26.4458 3.70151 26.4458 8.26599V18.1852C26.4458 22.7497 22.7451 26.4512 18.1815 26.4512H8.26432C3.70076 26.4512 0 22.7497 0 18.1852V8.26599C0 3.70151 3.70076 0 8.26432 0ZM18.1815 23.9714C21.3715 23.9714 23.9665 21.3758 23.9665 18.1852V8.26599C23.9665 5.07532 21.3715 2.4798 18.1815 2.4798H8.26432C5.07429 2.4798 2.47929 5.07532 2.47929 8.26599V18.1852C2.47929 21.3758 5.07429 23.9714 8.26432 23.9714H18.1815Z"
                            fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M6.61133 13.2251C6.61133 9.57318 9.57161 6.6123 13.2228 6.6123C16.874 6.6123 19.8342 9.57318 19.8342 13.2251C19.8342 16.877 16.874 19.8379 13.2228 19.8379C9.57161 19.8379 6.61133 16.877 6.61133 13.2251ZM9.09063 13.2251C9.09063 15.5032 10.9451 17.3581 13.2228 17.3581C15.5004 17.3581 17.355 15.5032 17.355 13.2251C17.355 10.9453 15.5004 9.0921 13.2228 9.0921C10.9451 9.0921 9.09063 10.9453 9.09063 13.2251Z"
                            fill="white" />
                        <ellipse cx="20.3302" cy="6.11651" rx="0.880977" ry="0.881154" fill="white" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="navbar__hamburger-open" onclick="openSidebar()">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="37"
                height="37" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M4 6l16 0" />
                <path d="M4 12l16 0" />
                <path d="M4 18l16 0" />
            </svg>
        </div>
        <div class="navbar__hamburger-close" onclick="closeSidebar()">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="45"
                height="45" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </div>
    </div>

    <main>
        @yield('content')
    </main>
    <footer class="footer dm-sans">
        <div class="footer__logo">
            <img src="images/logo.png" alt="logo">
        </div>
        <div class="footer__info">
            <div class="footer__info-item footer__location">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin-filled"
                        width="21" height="21" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M18.364 4.636a9 9 0 0 1 .203 12.519l-.203 .21l-4.243 4.242a3 3 0 0 1 -4.097 .135l-.144 -.135l-4.244 -4.243a9 9 0 0 1 12.728 -12.728zm-6.364 3.364a3 3 0 1 0 0 6a3 3 0 0 0 0 -6z"
                            stroke-width="0" fill="currentColor" />
                    </svg>
                </div>
                <div>
                    <a href="https://goo.gl/maps/RBKtN2zWC235usue8" target="_blank">Letališka cesta 29a, 1000
                        Ljubljana</a>
                </div>
            </div>
            <div class="footer__info-item footer__email">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="26"
                        height="26" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                        <path d="M3 7l9 6l9 -6" />
                    </svg>
                </div>
                <div>
                    <a href="mailto:info@fnx.si">info@fnx.si</a>
                </div>
            </div>
            <div class="footer__info-item footer__phone">
                <div>
                    <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg" class="ionicon"
                        viewBox="0 0 512 512" stroke="currentColor" fill="currentColor">
                        <path
                            d="M391 480c-19.52 0-46.94-7.06-88-30-49.93-28-88.55-53.85-138.21-103.38C116.91 298.77 93.61 267.79 61 208.45c-36.84-67-30.56-102.12-23.54-117.13C45.82 73.38 58.16 62.65 74.11 52a176.3 176.3 0 0128.64-15.2c1-.43 1.93-.84 2.76-1.21 4.95-2.23 12.45-5.6 21.95-2 6.34 2.38 12 7.25 20.86 16 18.17 17.92 43 57.83 52.16 77.43 6.15 13.21 10.22 21.93 10.23 31.71 0 11.45-5.76 20.28-12.75 29.81-1.31 1.79-2.61 3.5-3.87 5.16-7.61 10-9.28 12.89-8.18 18.05 2.23 10.37 18.86 41.24 46.19 68.51s57.31 42.85 67.72 45.07c5.38 1.15 8.33-.59 18.65-8.47 1.48-1.13 3-2.3 4.59-3.47 10.66-7.93 19.08-13.54 30.26-13.54h.06c9.73 0 18.06 4.22 31.86 11.18 18 9.08 59.11 33.59 77.14 51.78 8.77 8.84 13.66 14.48 16.05 20.81 3.6 9.53.21 17-2 22-.37.83-.78 1.74-1.21 2.75a176.49 176.49 0 01-15.29 28.58c-10.63 15.9-21.4 28.21-39.38 36.58A67.42 67.42 0 01391 480z" />
                    </svg>
                </div>
                <div>
                    <a href="tel:+386 51 719 626">+386 (0)51 719 626</a>
                </div>
            </div>
        </div>
        <div class="footer__working-hours">
            <div>Delovni čas</div>
            <div>Ponedeljek – petek: 8.00–17.00</div>
        </div>
        <div class="footer__socials">
            <a href="https://www.facebook.com/fnx.si" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 12 24"
                    fill="none">
                    <path
                        d="M9.75085 3.96177H11.9286V0.168015C11.5529 0.116318 10.2608 0 8.75589 0C5.61593 0 3.46498 1.97542 3.46498 5.60613V8.94754H0V13.1887H3.46498V23.8601H7.71321V13.1897H11.038L11.5658 8.94853H7.71222V6.02666C7.71321 4.80085 8.04321 3.96177 9.75085 3.96177Z"
                        fill="white" />
                </svg>
            </a>
            <a href="https://www.instagram.com/fnxbistro/" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 27 27"
                    fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M8.26432 0H18.1815C22.7451 0 26.4458 3.70151 26.4458 8.26599V18.1852C26.4458 22.7497 22.7451 26.4512 18.1815 26.4512H8.26432C3.70076 26.4512 0 22.7497 0 18.1852V8.26599C0 3.70151 3.70076 0 8.26432 0ZM18.1815 23.9714C21.3715 23.9714 23.9665 21.3758 23.9665 18.1852V8.26599C23.9665 5.07532 21.3715 2.4798 18.1815 2.4798H8.26432C5.07429 2.4798 2.47929 5.07532 2.47929 8.26599V18.1852C2.47929 21.3758 5.07429 23.9714 8.26432 23.9714H18.1815Z"
                        fill="white" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M6.61133 13.2251C6.61133 9.57318 9.57161 6.6123 13.2228 6.6123C16.874 6.6123 19.8342 9.57318 19.8342 13.2251C19.8342 16.877 16.874 19.8379 13.2228 19.8379C9.57161 19.8379 6.61133 16.877 6.61133 13.2251ZM9.09063 13.2251C9.09063 15.5032 10.9451 17.3581 13.2228 17.3581C15.5004 17.3581 17.355 15.5032 17.355 13.2251C17.355 10.9453 15.5004 9.0921 13.2228 9.0921C10.9451 9.0921 9.09063 10.9453 9.09063 13.2251Z"
                        fill="white" />
                    <ellipse cx="20.3302" cy="6.11651" rx="0.880977" ry="0.881154" fill="white" />
                </svg>
            </a>
        </div>
    </footer>
</body>

<script src=" https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script>
    const hamburgerOpen = document.querySelector('.navbar__hamburger-open');
    const hamburgerClose = document.querySelector('.navbar__hamburger-close');
    const navbarLinks = document.querySelector('.navbar__links');

    function openSidebar() {
        navbarLinks.style.transition = "all 0.5s ease-in-out"
        hamburgerOpen.style.display = 'none';
        hamburgerClose.style.display = 'block';
        navbarLinks.style.transform = 'translateX(0)';
    }

    function closeSidebar() {
        hamburgerOpen.style.display = 'block';
        hamburgerClose.style.display = 'none';
        navbarLinks.style.transform = 'translateX(100%)';
    }

    const eventSwiper = new Swiper('.event-swiper', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        slidesPerView: 1,
        spaceBetween: 50,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },

        // Navigation arrows
        navigation: {
            prevEl: '.nav-left',
            nextEl: '.nav-right',
        },
    });

    function updateSwiperSlides() {
        var width = window.innerWidth;

        if (width > 767 && width < 1024) {
            eventSwiper.params.slidesPerView = 2;
        } else if (width <= 767)
            eventSwiper.params.slidesPerView = 1;
        else
            eventSwiper.params.slidesPerView = 3;
    }

    window.addEventListener('resize', function() {
        var width = window.innerWidth;

        updateSwiperSlides();


        if (width > 767) {
            closeSidebar();
            navbarLinks.style.transition = "none"
            navbarLinks.style.transform = 'translateX(0)';
            hamburgerOpen.style.display = 'none';
        } else {
            closeSidebar();
            hamburgerOpen.style.display = 'block';
            hamburgerClose.style.display = 'none';
        }
    });

    updateSwiperSlides();

    /* Menu swipers */
    const menuSwiper1 = new Swiper('#menu-swiper-1', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        slidesPerView: 1,
        autoplay: {
            delay: 4000,
            disableOnInteraction: true,
        },

        // Navigation arrows
        navigation: {
            prevEl: '#menu-swiper-1-left',
            nextEl: '#menu-swiper-1-right',
        },
    });

    const menuSwiper2 = new Swiper('#menu-swiper-2', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        slidesPerView: 1,
        autoplay: {
            delay: 4000,
            disableOnInteraction: true,
        },

        // Navigation arrows
        navigation: {
            prevEl: '#menu-swiper-2-left',
            nextEl: '#menu-swiper-2-right',
        },
    });

    const menuSwiper3 = new Swiper('#menu-swiper-3', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        slidesPerView: 1,
        autoplay: {
            delay: 4000,
            disableOnInteraction: true,
        },

        // Navigation arrows
        navigation: {
            prevEl: '#menu-swiper-3-left',
            nextEl: '#menu-swiper-3-right',
        },
    });

    const menuSwiper4 = new Swiper('#menu-swiper-4', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        slidesPerView: 1,
        autoplay: {
            delay: 4000,
            disableOnInteraction: true,
        },

        // Navigation arrows
        navigation: {
            prevEl: '#menu-swiper-4-left',
            nextEl: '#menu-swiper-4-right',
        },
    });

    const menuSwiper5 = new Swiper('#menu-swiper-5', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        slidesPerView: 1,
        autoplay: {
            delay: 4000,
            disableOnInteraction: true,
        },

        // Navigation arrows
        navigation: {
            prevEl: '#menu-swiper-5-left',
            nextEl: '#menu-swiper-5-right',
        },
    });

    const menuSwiper6 = new Swiper('#menu-swiper-6', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        slidesPerView: 1,
        autoplay: {
            delay: 4000,
            disableOnInteraction: true,
        },

        // Navigation arrows
        navigation: {
            prevEl: '#menu-swiper-6-left',
            nextEl: '#menu-swiper-6-right',
        },
    });
</script>

</html>
