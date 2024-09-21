@extends('layouts.adminLayout')

@section('content')

@push('title')
Settings / Locations
@endpush

<div id="app">
    <div class="container">
        <div class="categories-index-container">
            
            <!-- search and create -->
            <div class="search-bar-container">
                <div class="search-bar">
                    <input
                        type="text"
                        name="search"
                        id="search"
                        disabled
                        placeholder="Search locations"
                        style="background-color: white;"
                    />
                    <svg
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        class="search-bar__icon"
                    >
                        <path
                            d="M11.0769 6.76923C11.0769 5.58333 10.6554 4.56891 9.8125 3.72596C8.96955 2.88301 7.95513 2.46154 6.76923 2.46154C5.58333 2.46154 4.56891 2.88301 3.72596 3.72596C2.88301 4.56891 2.46154 5.58333 2.46154 6.76923C2.46154 7.95513 2.88301 8.96955 3.72596 9.8125C4.56891 10.6554 5.58333 11.0769 6.76923 11.0769C7.95513 11.0769 8.96955 10.6554 9.8125 9.8125C10.6554 8.96955 11.0769 7.95513 11.0769 6.76923ZM16 14.7692C16 15.1026 15.8782 15.391 15.6346 15.6346C15.391 15.8782 15.1026 16 14.7692 16C14.4231 16 14.1346 15.8782 13.9038 15.6346L10.6058 12.3462C9.45833 13.141 8.17949 13.5385 6.76923 13.5385C5.85256 13.5385 4.97596 13.3606 4.13942 13.0048C3.30288 12.649 2.58173 12.1683 1.97596 11.5625C1.37019 10.9567 0.889423 10.2356 0.533654 9.39904C0.177885 8.5625 0 7.6859 0 6.76923C0 5.85256 0.177885 4.97596 0.533654 4.13942C0.889423 3.30288 1.37019 2.58173 1.97596 1.97596C2.58173 1.37019 3.30288 0.889423 4.13942 0.533654C4.97596 0.177885 5.85256 0 6.76923 0C7.6859 0 8.5625 0.177885 9.39904 0.533654C10.2356 0.889423 10.9567 1.37019 11.5625 1.97596C12.1683 2.58173 12.649 3.30288 13.0048 4.13942C13.3606 4.97596 13.5385 5.85256 13.5385 6.76923C13.5385 8.17949 13.141 9.45833 12.3462 10.6058L15.6442 13.9038C15.8814 14.141 16 14.4295 16 14.7692Z"
                            fill="currentColor"
                        />
                    </svg>
                </div>
                <div>
                    <a href="{{route('settings.locations.create')}}">
                        <button class="search-bar__button">
                            <svg viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 6.5H8V0.5H6V6.5H0V8.5H6V14.5H8V8.5H14V6.5Z" fill="currentColor" />
                            </svg></button
                    ></a>
                </div>
            </div>

            <!-- Locations list -->
            <div class="categories-list">

                @foreach($locations as $location)
                <div class="category">
                    <!-- Ovako izgleda kategorija -->
                    <div class="category__title-container">
                        <!-- <div class="category__icon"></div>--> 
                            
                        <div class="category__title">
                            <!-- Ime kategorije -->
                            {{$location->name}}
                            @if($location->address != null)
                                <span class="location-address">- {{$location->address}}</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <a href="{{route('settings.locations.edit',$location->id)}}">
                            <button class="category__edit-button">Edit</button>
                        </a>
                        <a href="">
                            <button class="category__edit-button">Delete</button>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
        </div>
    </div>
</div>


@endsection