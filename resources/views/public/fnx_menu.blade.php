@extends('layouts.publicLayout')

@section('content')

<div id="app">
    <menu-component :drink_categories="{{json_encode($drink_categories)}}" 
                    :food_categories="{{json_encode($food_categories)}}"
                    :food="{{json_encode($food)}}"
                    :drinks="{{json_encode($drinks)}}"
                    :weekly_offers="{{json_encode($weekly_offers)}}"
                    :default_food="{{json_encode($default_food)}}"
                    :default_drinks="{{json_encode($default_drinks)}}"
                    :allergens="{{json_encode($allergens)}}"
                    ></menu-component>
</div>

<!-- 
<nav id="nav-public" class="nav-public--menu">
    <div class="logo-button-container">
        <img src="https://i.imgur.com/3LLHxS4.png" alt="logo" class="nav__logo--menu">
        <button class="btn btn-primary" onclick="openSidebar()">
            <svg width="16" height="9" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg" class="open-sidebar-button">
                <path d="M0 0H16V1.34737H0V0ZM0 3.36842H16V4.71579H0V3.36842ZM0 6.73684H16V8.08421H0V6.73684Z" fill="currentColor" />
            </svg>
        </button>
    </div>
    <div class="category-types">
        <a href="" class="category-type">Hrana</a>
        <a href="" class="category-type --active">Pijača</a>
        <a href="" class="category-type">Tedenska ponudba</a>
    </div>

</nav>
<div class="categories-container">
    <div class="categories">
        <a href="" class="category --active">Brezalkoholne pijače</a>
        <a href="" class="category">Alkoholne pijače</a>
        <a href="" class="category">Piva</a>
        <a href="" class="category">Čajevi</a>
        <a href="" class="category">Alkoholne pijače</a>
        <a href="" class="category">Piva</a>
        <a href="" class="category">Čajevi</a>
        <a href="" class="category">Alkoholne pijače</a>
        <a href="" class="category">Piva</a>
        <a href="" class="category">Čajevi</a>
    </div>
</div>
<main id="main-public--menu">
    <div class="types-list">
        <div class="type">
            <h2 class="type-title">Cocktails</h2>
            <div class="items-list">
                <a class="item" href="#">
                    <img class="item__picture" src="https://bellyfull.net/wp-content/uploads/2021/07/Tequilla-Sunrise-blog-768x1024.jpg" />
                    <div class="item__text-container">
                        <h4 class="item__title">
                            Tequila sunrise
                        </h4>
                        <div class="item__description">
                            Tequila, pomarančni sok, grenadine
                        </div>
                        <div class="item__size-price-container">
                            <div class="item__size">
                                0.3 l
                            </div>
                            <div class="item__price">
                                7,0 €
                            </div>
                        </div>
                    </div>
                </a>
                <a class="item" href="#">
                    <img class="item__picture" src="https://bellyfull.net/wp-content/uploads/2021/07/Tequilla-Sunrise-blog-768x1024.jpg" />
                    <div class="item__text-container">
                        <h4 class="item__title">
                            Tequila sunrise
                        </h4>
                        <div class="item__description">
                            Tequila, pomarančni sok, grenadine
                        </div>
                        <div class="item__size-price-container">
                            <div class="item__size">
                                0.3 l
                            </div>
                            <div class="item__price">
                                7,0 €
                            </div>
                        </div>
                    </div>
                </a>
                <a class="item" href="#">
                    <img class="item__picture" src="https://bellyfull.net/wp-content/uploads/2021/07/Tequilla-Sunrise-blog-768x1024.jpg" />
                    <div class="item__text-container">
                        <h4 class="item__title">
                            Tequila sunrise
                        </h4>
                        <div class="item__description">
                            Tequila, pomarančni sok, grenadine
                        </div>
                        <div class="item__size-price-container">
                            <div class="item__size">
                                0.3 l
                            </div>
                            <div class="item__price">
                                7,0 €
                            </div>
                        </div>
                    </div>
                </a>
                <a class="item" href="#">
                    <img class="item__picture" src="https://bellyfull.net/wp-content/uploads/2021/07/Tequilla-Sunrise-blog-768x1024.jpg" />
                    <div class="item__text-container">
                        <h4 class="item__title">
                            Tequila sunrise
                        </h4>
                        <div class="item__description">
                            Tequila, pomarančni sok, grenadine
                        </div>
                        <div class="item__size-price-container">
                            <div class="item__size">
                                0.3 l
                            </div>
                            <div class="item__price">
                                7,0 €
                            </div>
                        </div>
                    </div>
                </a>
                <a class="item" href="#">
                    <img class="item__picture" src="https://bellyfull.net/wp-content/uploads/2021/07/Tequilla-Sunrise-blog-768x1024.jpg" />
                    <div class="item__text-container">
                        <h4 class="item__title">
                            Tequila sunrise
                        </h4>
                        <div class="item__description">
                            Tequila, pomarančni sok, grenadine
                        </div>
                        <div class="item__size-price-container">
                            <div class="item__size">
                                0.3 l
                            </div>
                            <div class="item__price">
                                7,0 €
                            </div>
                        </div>
                    </div>
                </a>
                <a class="item" href="#">
                    <img class="item__picture" src="https://bellyfull.net/wp-content/uploads/2021/07/Tequilla-Sunrise-blog-768x1024.jpg" />
                    <div class="item__text-container">
                        <h4 class="item__title">
                            Tequila sunrise
                        </h4>
                        <div class="item__description">
                            Tequila, pomarančni sok, grenadine
                        </div>
                        <div class="item__size-price-container">
                            <div class="item__size">
                                0.3 l
                            </div>
                            <div class="item__price">
                                7,0 €
                            </div>
                        </div>
                    </div>
                </a>
                <a class="item" href="#">
                    <img class="item__picture" src="https://bellyfull.net/wp-content/uploads/2021/07/Tequilla-Sunrise-blog-768x1024.jpg" />
                    <div class="item__text-container">
                        <h4 class="item__title">
                            Tequila sunrise
                        </h4>
                        <div class="item__description">
                            Tequila, pomarančni sok, grenadine
                        </div>
                        <div class="item__size-price-container">
                            <div class="item__size">
                                0.3 l
                            </div>
                            <div class="item__price">
                                7,0 €
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="type">
            <h2 class="type-title">Beers</h2>
            <div class="items-list">
                <a class="item" href="#">
                    <img class="item__picture" src="https://images.unsplash.com/photo-1618183479302-1e0aa382c36b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=387&q=80" />
                    <div class="item__text-container">
                        <h4 class="item__title">
                            Beer
                        </h4>
                        <div class="item__description">
                            Beer, beer and beer
                        </div>
                        <div class="item__size-price-container">
                            <div class="item__size">
                                0.5 l
                            </div>
                            <div class="item__price">
                                5,0 €
                            </div>
                        </div>
                    </div>
                </a>
                <a class="item" href="#">
                    <img class="item__picture" src="https://images.unsplash.com/photo-1618183479302-1e0aa382c36b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=387&q=80" />
                    <div class="item__text-container">
                        <h4 class="item__title">
                            Beer
                        </h4>
                        <div class="item__description">
                            Beer, beer and beer
                        </div>
                        <div class="item__size-price-container">
                            <div class="item__size">
                                0.5 l
                            </div>
                            <div class="item__price">
                                5,0 €
                            </div>
                        </div>
                    </div>
                </a>
                <a class="item" href="#">
                    <img class="item__picture" src="https://images.unsplash.com/photo-1618183479302-1e0aa382c36b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=387&q=80" />
                    <div class="item__text-container">
                        <h4 class="item__title">
                            Beer
                        </h4>
                        <div class="item__description">
                            Beer, beer and beer
                        </div>
                        <div class="item__size-price-container">
                            <div class="item__size">
                                0.5 l
                            </div>
                            <div class="item__price">
                                5,0 €
                            </div>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
</main>
-->

@endsection