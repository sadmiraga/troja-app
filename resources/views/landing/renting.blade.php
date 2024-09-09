@extends('layouts.landingLayout')

@section('content')
    <section class="renting-banner">
        <div class="renting-banner__transition"></div>
    </section>
    <section class="renting-header">
        <h1 class="renting-header__heading secular">
            Najem restavracije za poslovna kosila ali dogodke
        </h1>
    </section>
    <section class="renting-description">
        <div class="renting-description__container secular">
            <article class="renting-description__text">
                <p>
                    Sprejemamo rezervacije za poslovne sprejeme, kosila, prednovoletna srečanja, rojstnodnevne zabave in še
                    mnogo drugega. Poleg najema atraktivnega prostora v dveh nivojih in različnih možnosti pogostitve vam
                    nudimo (samo)postrežni menu toplih in hladnih jedi ter pijač iz naše ponudbe.
                </p>
                <p>
                    Ceni najema in strežbe sta že všteti v ceni menijev, prav tako pa imate zagotovljen tudi brezplačen
                    parking.
                </p>
                <p>
                    Pri nas lahko vaše srečanje popestrite z video projekcijo, DJ-em in tematsko dekoracijo, kakršno si
                    boste zaželeli, saj smo zelo fleksibilni in se bomo prilagodili vašim željam tako, da bo vaš dogodek
                    krojen po vaši meri, ki se bo vtisnila v spomin vsem.
                </p>
            </article>
            <div class="renting-description__image-container">
                <div class="renting-description__image">
                    <img src="images/renting.png">
                </div>
                <div class="renting-description__image-caption">
                    Primerno za 150 oseb
                </div>
            </div>
    </section>
    <section class="paralax --catering-bg">
        <div class="paralax__overlay">
            <a href="catering">
                <button class="btn-menu">Poglej catering ponudbo</button>
            </a>
        </div>
    </section>

    <section class="events">
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
    <section class="terramona">
        <div class="terramona__image-container">
            <img src="images/terramona.png">
            <div class="terramona__btn secular" role="button">
                <div onclick='location.href="https://instagram.com/terramonavino?igshid=MzRlODBiNWFlZA"'>
                    Terramona
                </div>
                <div>
                    <svg width="53" height="53" xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-arrow-narrow-right" viewBox="0 0 24 24" stroke-width="1"
                        stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M0 12l19 0" />
                        <path d="M15 16l4 -4" />
                        <path d="M15 8l4 4" />
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!--
    <section class="reservation secular" id="rezervacija">
      <div class="transition-reverse"></div>
      <div class="reservation__heading">Rezerviraj prostor</div>
      <form class="reservation__form">
        <div class="reservation__form-row">
          <input class="reservation__form-input" name="fname" type="text" placeholder="Ime" required>
          <input class="reservation__form-input" name="lname" type="text" placeholder="Priimek" required>
        </div>
        <div class="reservation__form-row">
          <input class="reservation__form-input" type="email" placeholder="Elektronski naslov" required>
        </div>
        <div class="reservation__form-row">
          <input class="reservation__form-input" name="phone" type="tel" placeholder="Telefonska številka" required>
          <input class="reservation__form-input" name="company" type="text" placeholder="Podjetje" required>
        </div>
        <div class="reservation__form-row">
          <input class="reservation__form-input" name="numberOfPeople" type="number" placeholder="Število oseb" required>
          <input class="reservation__form-input" name="date" type="date" placeholder="Datum" required>
        </div>
        <div class="reservation__form-row">
          <textarea class="reservation__form-input" name="notes" placeholder="Opombe" rows="5" required></textarea>
        </div>
        <div class="reservation__form-btn-container">
          <button type="submit" class="reservation-btn secular">Rezerviraj</button>
        </div>
      </form>
    </section>
    -->

    <div id="app">
        <form-component></form-component>
    </div>
@endsection
