@extends('layouts.adminLayout')

@push('title')
    {{ __('Choose location') }}
@endpush

@section('css')
<style>
    #choose-location{
        display: none;
    }
</style>
@endsection

@section('content')
    <div class="container">

        <div class="public-events-index-container">
            <div class="public-events-list">

                @foreach($locations as $location)
                    <a href="{{route('choose.location',$location->id)}}"
                        class="public-events-list__item location-card" 
                        style="background-image: url({{$location->image_url}});">

                        <div class="location-footer">
                            <span class="location-name">{{$location->name}}</span>

                            <div class="card-button-next">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                    fill="none">
                                    <path
                                        d="M4.79999 12.0001L8.79999 8.0001L4.79999 4.0001L5.59999 2.4001L11.2 8.0001L5.59999 13.6001L4.79999 12.0001Z"
                                        fill="white" />
                                </svg>
                            </div>
                            
                        </div>
                    </a>
                @endforeach

            </div>
        </div>


    </div>
@endsection
