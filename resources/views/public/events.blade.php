@extends('layouts.publicLayout')

@section('content')

<div id="app">
    <public-events-component :events="{{json_encode($events)}}" ></public-events-component>
</div>

<!-- 
<nav id="nav-public" class="nav-public--events">
    <div class="logo-button-container">
        <img src="https://i.imgur.com/3LLHxS4.png" alt="logo" class="nav__logo--menu">
        <button class="btn btn-primary" onclick="openSidebar()">
            <svg width="16" height="9" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg" class="open-sidebar-button">
                <path d="M0 0H16V1.34737H0V0ZM0 3.36842H16V4.71579H0V3.36842ZM0 6.73684H16V8.08421H0V6.73684Z" fill="currentColor" />
            </svg>
        </button>
    </div>
</nav>

<main id="main-public--events">
    <div class="public-events-index-container">
        <div class="public-events-list">
            <a class="public-events-list__item" href="">
                <img class="public-events-list__event-image" src="https://images.squarespace-cdn.com/content/v1/571eda2a746fb91437167983/1637457209871-LO6Z9EH9RAFQA4HNN5G5/Brisbane_christmas_work_party_ideas_gold_coast_colleagues_fun_brewery_tour_golf.jpg?format=1500w">
                <div class="public-events-list__event-info">
                    <span class="public-events-lists__event-title">Oldies goldies z Dj</span>
                    <div class="public-events-list__event-date-entry">
                        <div class="public-events-list__event-date">20.5.2O22</div>
                        <div class="public-events-list__event-entry">prosti vstop</div>
                    </div>
                </div>
            </a>
            <a class="public-events-list__item" href="">
                <img class="public-events-list__event-image" src="https://www.blog.uporabnastran.si/wp-content/uploads/2022/08/Festival-Panc-2022-program.jpeg">
                <div class="public-events-list__event-info">
                    <span class="public-events-lists__event-title">15. Panč festival Stand-up komedije</span>
                    <div class="public-events-list__event-date-entry">
                        <div class="public-events-list__event-date">5.5.2O22</div>
                        <div class="public-events-list__event-entry">prosti vstop</div>
                    </div>
                </div>
            </a>
            <a class="public-events-list__item" href="">
                <img class="public-events-list__event-image" src="https://images.squarespace-cdn.com/content/v1/571eda2a746fb91437167983/1637457209871-LO6Z9EH9RAFQA4HNN5G5/Brisbane_christmas_work_party_ideas_gold_coast_colleagues_fun_brewery_tour_golf.jpg?format=1500w">
                <div class="public-events-list__event-info">
                    <span class="public-events-lists__event-title">Oldies goldies z Dj</span>
                    <div class="public-events-list__event-date-entry">
                        <div class="public-events-list__event-date">20.5.2O22</div>
                        <div class="public-events-list__event-entry">prosti vstop</div>
                    </div>
                </div>
            </a>
            <a class="public-events-list__item" href="">
                <img class="public-events-list__event-image" src="https://www.blog.uporabnastran.si/wp-content/uploads/2022/08/Festival-Panc-2022-program.jpeg">
                <div class="public-events-list__event-info">
                    <span class="public-events-lists__event-title">15. Panč festival Stand-up komedije</span>
                    <div class="public-events-list__event-date-entry">
                        <div class="public-events-list__event-date">5.5.2O22</div>
                        <div class="public-events-list__event-entry">prosti vstop</div>
                    </div>
                </div>
            </a>
            <a class="public-events-list__item" href="">
                <img class="public-events-list__event-image" src="https://images.squarespace-cdn.com/content/v1/571eda2a746fb91437167983/1637457209871-LO6Z9EH9RAFQA4HNN5G5/Brisbane_christmas_work_party_ideas_gold_coast_colleagues_fun_brewery_tour_golf.jpg?format=1500w">
                <div class="public-events-list__event-info">
                    <span class="public-events-lists__event-title">Oldies goldies z Dj</span>
                    <div class="public-events-list__event-date-entry">
                        <div class="public-events-list__event-date">20.5.2O22</div>
                        <div class="public-events-list__event-entry">prosti vstop</div>
                    </div>
                </div>
            </a>
            <a class="public-events-list__item" href="">
                <img class="public-events-list__event-image" src="https://www.blog.uporabnastran.si/wp-content/uploads/2022/08/Festival-Panc-2022-program.jpeg">
                <div class="public-events-list__event-info">
                    <span class="public-events-lists__event-title">15. Panč festival Stand-up komedije</span>
                    <div class="public-events-list__event-date-entry">
                        <div class="public-events-list__event-date">5.5.2O22</div>
                        <div class="public-events-list__event-entry">prosti vstop</div>
                    </div>
                </div>
            </a>
        </div>

    </div>
</main>
-->

@endsection