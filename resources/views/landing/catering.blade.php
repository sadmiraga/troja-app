@extends('layouts.landingLayout')

@section('content')
    <section class="catering-banner">
        <div class="catering-banner__transition"></div>
    </section>
    <section class="catering-header">
        <h1 class="catering-header__heading secular">
            FNX CATERING
        </h1>
    </section>
    <section class="catering-description">
        <div class="catering-description__container secular">
            <article class="catering-description__text">
                <p>
                    Naše vabljivo vzdušje je popolno za različne priložnosti, bodisi za vsakdanje srečanje ali poseben
                    dogodek. Ponujamo živahno prizorišče, ki je idealno za poslovna srečanja, kosila in še več. Naša pestra
                    izbira možnosti vključuje samopostrežne menije in izbor jedi, ki zajemajo vrsto okusov – od žara, juh in
                    predjedi do naših znanih samopostrežnih prigrizkov. Ne glede na to, kaj je namen vašega dogodka, boste
                    zagotovo pustili trajen vtis na vaše goste.</p>
            </article>
            <div class="catering-description__image">
                <img src="images/catering11.png">
            </div>
        </div>
        <div class="catering-description__container secular">
            <article class="catering-description__text">
                <p>
                    Pri FNX se prilagajamo vašim željam, saj želimo vašemu dogodku dodati piko na i. Naša ekipa zagotavlja
                    nepozabno izkušnjo za vse udeležence. Raziščite naše edinstvene ponudbe cateringa in dovolite, da naše
                    storitve nadgradijo vaše celotno doživetje dogodka. Ne glede na velikost, vrsto ali temo vašega dogodka,
                    se bomo potrudili, da bo vse potekalo brezhibno in da bodo vaši gostje deležni vrhunskega razvajanja s
                    pristnimi in okusnimi jedmi.
                </p>
            </article>
            <div class="catering-description__image">
                <img src="images/catering21.png">
            </div>
        </div>
    </section>
    <section class="menus secular">
        <div class="menus__heading-container">
            <h2 class="menus__heading-title">Ponudba</h2>
        </div>
        <div class="menus__list">

            <!-- MENU 1 -->
            <div class="menus__menu">
                <div class="menus__text">
                    <h3 class="menus__menu-heading">
                        Samopostrežni menu 1
                    </h3>
                    <ul class="menus__menu-content">
                        <li>Piščanec caprese s sortirano zelenjavo</li>
                        <li>Sv. pečenka v naravni omaki s praženim krompirjem</li>
                        <li>Rižota s pršutom in traviso radičem (morska/vegi)</li>
                        <li>Dunajski zrezki z maslenim krompirjem</li>
                        <li>Grška solata</li>
                    </ul>
                </div>
                <!--
                <div class="swiper-container">
                    <div class="menu-swiper swiper" id="menu-swiper-1">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="images/menu.png">
                            </div>
                            <div class="swiper-slide">
                                <img src="images/menu.png">
                            </div>
                            <div class="swiper-slide">
                                <img src="images/menu.png">
                            </div>
                        </div>
                    </div>
                    <div class="menus__slider-arrows-container">
                        <div class="swiper-arrow nav-left" id="menu-swiper-1-left">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M5 12l4 4" />
                                <path d="M5 12l4 -4" />
                            </svg>
                        </div>
                        <div class="swiper-arrow nav-right" id="menu-swiper-1-right">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-right"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M15 16l4 -4" />
                                <path d="M15 8l4 4" />
                            </svg>
                        </div>
                    </div>
                </div>
                -->
            </div>

            <!-- MENU 2  -->
            <div class="menus__menu">
                <div class="menus__text">
                    <h3 class="menus__menu-heading">
                        Samopostrežni menu 2
                    </h3>
                    <ul class="menus__menu-content">
                        <li>Brancin ali losos na žaru s korenčkovim pirejem in zelenjavo</li>
                        <li>Sv. Ribica v gobovem objemu s kruhovo rezino</li>
                        <li>Puran v mandljevi srajčki in pekovskim krompirjem</li>
                        <li>Telečja ribica v brusnični omaki s sirovimi štruklji</li>
                        <li>Grška solata</li>
                    </ul>
                </div>
                <!-- 
                <div class="swiper-container">
                    <div class="menu-swiper swiper" id="menu-swiper-2">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="images/menu.png">
                            </div>
                            <div class="swiper-slide">
                                <img src="images/menu.png">
                            </div>
                            <div class="swiper-slide">
                                <img src="images/menu.png">
                            </div>
                        </div>
                    </div>
                    <div class="menus__slider-arrows-container">
                        <div class="swiper-arrow nav-left" id="menu-swiper-2-left">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M5 12l4 4" />
                                <path d="M5 12l4 -4" />
                            </svg>
                        </div>
                        <div class="swiper-arrow nav-right" id="menu-swiper-2-right">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-right"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M15 16l4 -4" />
                                <path d="M15 8l4 4" />
                            </svg>
                        </div>
                    </div>
                </div>
                -->
            </div>

            <!-- MENU 3 - finger food -->
            <div class="menus__menu">
                <div class="menus__text">
                    <h3 class="menus__menu-heading">
                        Menu 3 - finger food
                    </h3>
                    <ul class="menus__menu-content">
                        <li>Crispy piščanec</li>
                        <li>Sezam piščanec</li>
                        <li>Bučkini taquitosi</li>
                        <li>Piščančji taqutiosi</li>
                        <li>Caprese nabodala</li>
                        <li>Omakce (3 vrste)</li>
                    </ul>
                    <h3 class="menus__menu-heading">
                        Dodatno
                    </h3>
                    <ul class="menus__menu-content">
                        <li>Quesadilla (piščančje, goveje, vegi, tuna)</li>
                        <li>Kanapeji (pršut, losos, vegi, klasika)</li>
                        <li>Mini burger</li>
                    </ul>
                </div>
                <div class="swiper-container">
                    <div class="menu-swiper swiper" id="menu-swiper-3">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="images/taquitos.jpeg">
                            </div>
                        </div>
                    </div>

                    <!-- 
                    <div class="menus__slider-arrows-container">
                        <div class="swiper-arrow nav-left" id="menu-swiper-3-left">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M5 12l4 4" />
                                <path d="M5 12l4 -4" />
                            </svg>
                        </div>
                        <div class="swiper-arrow nav-right" id="menu-swiper-3-right">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-arrow-narrow-right" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M15 16l4 -4" />
                                <path d="M15 8l4 4" />
                            </svg>
                        </div>
                    </div>
                    -->
                </div>
            </div>

            <!-- MENU 4 - finger food -->
            <div class="menus__menu">
                <div class="menus__text">
                    <h3 class="menus__menu-heading">
                        Menu 4 - glavna jed kot "finger food"
                    </h3>
                    <ul class="menus__menu-content">
                        <li>Istrski fuži s tartufato in pršutom</li>
                        <li>Goveja tagliata s popečeno belo polento z brusnicami</li>
                        <li>Njoki z bučkami in žajbljem</li>
                        <li>Črna sipina rižota s parmezanom ali gamberi in bučkami</li>
                        <li>Cezarjeva solatka ali solatka caprese</li>
                    </ul>
                </div>
                <div class="swiper-container">
                    <div class="menu-swiper swiper" id="menu-swiper-4">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="images/burgerji.jpeg">
                            </div>
                        </div>
                    </div>

                    <!-- 
                    <div class="menus__slider-arrows-container">
                        <div class="swiper-arrow nav-left" id="menu-swiper-4-left">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M5 12l4 4" />
                                <path d="M5 12l4 -4" />
                            </svg>
                        </div>
                        <div class="swiper-arrow nav-right" id="menu-swiper-4-right">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-arrow-narrow-right" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M15 16l4 -4" />
                                <path d="M15 8l4 4" />
                            </svg>
                        </div>
                    </div>
                  -->
                </div>
            </div>

            <!-- Nudimo tudi -->
            <div class="menus__menu">
                <div class="menus__text">
                    <h3 class="menus__menu-heading">
                        Nudimo tudi
                    </h3>
                    <ul class="menus__menu-content">
                        <li>Jedi z žara</li>
                        <li>Juhe</li>
                        <li>Možnost streženih menujev</li>
                        <li>Možnost različnih predjedi</li>
                    </ul>
                </div>

                <!-- 
                <div class="swiper-container">
                    <div class="menu-swiper swiper" id="menu-swiper-5">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="images/menu.png">
                            </div>
                            <div class="swiper-slide">
                                <img src="images/menu.png">
                            </div>
                            <div class="swiper-slide">
                                <img src="images/menu.png">
                            </div>
                        </div>
                    </div>
                    <div class="menus__slider-arrows-container">
                        <div class="swiper-arrow nav-left" id="menu-swiper-5-left">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M5 12l4 4" />
                                <path d="M5 12l4 -4" />
                            </svg>
                        </div>
                        <div class="swiper-arrow nav-right" id="menu-swiper-5-right">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-arrow-narrow-right" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M15 16l4 -4" />
                                <path d="M15 8l4 4" />
                            </svg>
                        </div>
                    </div>
                </div>
                -->
            </div>

            <!-- Sladice -->
            <div class="menus__menu">
                <div class="menus__text">
                    <h3 class="menus__menu-heading">
                        Sladice
                    </h3>
                    <ul class="menus__menu-content">
                        <li>Tiramisu, grmada ali profoteroli</li>
                        <li>Panna cotta z gozdnimi sadeži</li>
                        <li>Tortice</li>
                    </ul>
                </div>
                <div class="swiper-container">
                    <div class="menu-swiper swiper" id="menu-swiper-6">
                        <div class="swiper-wrapper">

                          <!-- 
                            <div class="swiper-slide">
                                <img src="images/menu.png">
                            </div>
                          -->
                            <div class="swiper-slide">
                                <img src="images/sladice.jpeg">
                            </div>
                        </div>
                    </div>

                    <!-- 
                    <div class="menus__slider-arrows-container">
                        <div class="swiper-arrow nav-left" id="menu-swiper-6-left">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M5 12l4 4" />
                                <path d="M5 12l4 -4" />
                            </svg>
                        </div>
                        <div class="swiper-arrow nav-right" id="menu-swiper-6-right">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-arrow-narrow-right" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M15 16l4 -4" />
                                <path d="M15 8l4 4" />
                            </svg>
                        </div>
                    </div>
                  -->
                </div>
            </div>
        </div>
    </section>


    <!--
    <section class="catering-reservation">
      <div class="transition-reverse"></div>
      <div class="catering-reservation__btn-container">
        <a href="/najem-prostora#rezervacija">
          <button class="reservation-btn secular">
            Rezerviraj
          </button>
        </a>
      </div>
    </section>
    -->

    <div id="app">
        <form-component></form-component>
    </div>
@endsection
