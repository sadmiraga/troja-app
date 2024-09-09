@extends('layouts.adminLayout')

@section('content')

@push('title')
Hrana
@endpush

<div class="drinks-food-navbar">
    <div class="drinks-food-navbar__links">
        <a href="/drink/index" class="drinks-food-navbar__link">
            Pijače
        </a>
        <a href="/food/index" class="drinks-food-navbar__link drinks-food-navbar__link--active">
            Hrana
        </a>
    </div>
</div>

<div class="drinks-food-index-container">
    <div class="search-bar-container">
        <div class="search-bar">
            <input type="text" name="search" id="search" placeholder="Išči po artiklih">
            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="search-bar__icon">
                <path d="M11.0769 6.76923C11.0769 5.58333 10.6554 4.56891 9.8125 3.72596C8.96955 2.88301 7.95513 2.46154 6.76923 2.46154C5.58333 2.46154 4.56891 2.88301 3.72596 3.72596C2.88301 4.56891 2.46154 5.58333 2.46154 6.76923C2.46154 7.95513 2.88301 8.96955 3.72596 9.8125C4.56891 10.6554 5.58333 11.0769 6.76923 11.0769C7.95513 11.0769 8.96955 10.6554 9.8125 9.8125C10.6554 8.96955 11.0769 7.95513 11.0769 6.76923ZM16 14.7692C16 15.1026 15.8782 15.391 15.6346 15.6346C15.391 15.8782 15.1026 16 14.7692 16C14.4231 16 14.1346 15.8782 13.9038 15.6346L10.6058 12.3462C9.45833 13.141 8.17949 13.5385 6.76923 13.5385C5.85256 13.5385 4.97596 13.3606 4.13942 13.0048C3.30288 12.649 2.58173 12.1683 1.97596 11.5625C1.37019 10.9567 0.889423 10.2356 0.533654 9.39904C0.177885 8.5625 0 7.6859 0 6.76923C0 5.85256 0.177885 4.97596 0.533654 4.13942C0.889423 3.30288 1.37019 2.58173 1.97596 1.97596C2.58173 1.37019 3.30288 0.889423 4.13942 0.533654C4.97596 0.177885 5.85256 0 6.76923 0C7.6859 0 8.5625 0.177885 9.39904 0.533654C10.2356 0.889423 10.9567 1.37019 11.5625 1.97596C12.1683 2.58173 12.649 3.30288 13.0048 4.13942C13.3606 4.97596 13.5385 5.85256 13.5385 6.76923C13.5385 8.17949 13.141 9.45833 12.3462 10.6058L15.6442 13.9038C15.8814 14.141 16 14.4295 16 14.7692Z" fill="currentColor" />
            </svg>

        </div>
        <div>
            <a href="/food/create">
                <button class="search-bar__button">
                    <svg viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 6.5H8V0.5H6V6.5H0V8.5H6V14.5H8V8.5H14V6.5Z" fill="currentColor" />
                    </svg>
                </button>
            </a>
        </div>
    </div>

    <div class="drinks-food-list">
        <a class="drinks-food-list__item --food-item" href="/food/edit/1">
            <div class="drinks-food-list__text-container">
                <h4 class="drinks-food-list__title">
                    Classic burger
                </h4>
                <div class="drinks-food-list__category">
                    Burgerji
                </div>
                <div class="drinks-food-list__price-label">
                    <span class="drinks-food-list__price">8,5 €</span>
                </div>
            </div>
        </a>
        <a class="drinks-food-list__item --food-item" href="/food/edit/2">
            <img class="drinks-food-list__picture" src="https://images.unsplash.com/photo-1586190848861-99aa4a171e90?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=580&q=80" />
            <div class="drinks-food-list__text-container">
                <h4 class="drinks-food-list__title">
                    Cheese burger
                </h4>
                <div class="drinks-food-list__category">
                    Burgerji
                </div>
                <div class="drinks-food-list__price-label">
                    <span class="drinks-food-list__price">9,5 €</span>
                </div>
            </div>
        </a>
        <a class="drinks-food-list__item --food-item" href="/food/edit/3">
            <img class="drinks-food-list__picture" src="https://images.unsplash.com/photo-1572802419224-296b0aeee0d9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=815&q=80" />
            <div class="drinks-food-list__text-container">
                <h4 class="drinks-food-list__title">
                    Tartuf burger
                </h4>
                <div class="drinks-food-list__category">
                    Burgerji
                </div>
                <div class="drinks-food-list__price-label">
                    <span class="drinks-food-list__price">11,5 €</span>
                </div>
            </div>
        </a>
        <a class="drinks-food-list__item --food-item" href="/food/edit/4">
            <img class="drinks-food-list__picture" src="https://images.unsplash.com/photo-1606755962773-d324e0a13086?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=387&q=80" />
            <div class="drinks-food-list__text-container">
                <h4 class="drinks-food-list__title">
                    Chicken burger
                </h4>
                <div class="drinks-food-list__category">
                    Burgerji
                </div>
                <div class="drinks-food-list__price-label">
                    <span class="drinks-food-list__price">8,5 €</span>
                </div>
            </div>
        </a>
        <a class="drinks-food-list__item --food-item" href="/food/edit/5">
            <img class="drinks-food-list__picture" src="https://images.unsplash.com/photo-1582196016295-f8c8bd4b3a99?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=580&q=80" />
            <div class="drinks-food-list__text-container">
                <h4 class="drinks-food-list__title">
                    Black angus burger
                </h4>
                <div class="drinks-food-list__category">
                    Burgerji
                </div>
                <div class="drinks-food-list__price-label">
                    <span class="drinks-food-list__price">10,5 €</span>
                </div>
            </div>
        </a>
        <a class="drinks-food-list__item --food-item" href="/food/edit/6">
            <img class="drinks-food-list__picture" src="https://images.unsplash.com/photo-1626170808927-569c46a66cc0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=387&q=80" />
            <div class="drinks-food-list__text-container">
                <h4 class="drinks-food-list__title">
                    BBQ burger
                </h4>
                <div class="drinks-food-list__category">
                    Burgerji
                </div>
                <div class="drinks-food-list__price-label">
                    <span class="drinks-food-list__price">9,5 €</span>
                </div>
            </div>
        </a>
        <a class="drinks-food-list__item --food-item" href="/food/edit/7">
            <img class="drinks-food-list__picture" src="https://images.unsplash.com/photo-1606755962773-d324e0a13086?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=387&q=80" />
            <div class="drinks-food-list__text-container">
                <h4 class="drinks-food-list__title">
                    Chicken burger
                </h4>
                <div class="drinks-food-list__category">
                    Burgerji
                </div>
                <div class="drinks-food-list__price-label">
                    <span class="drinks-food-list__price">8,5 €</span>
                </div>
            </div>
        </a>
    </div>
</div>

@endsection