@extends('layouts.adminLayout')

@section('css')
    <style>
        #choose-location,#open-sidebar-button{
            display: none;
        }
    </style>
@endsection

@section('content')
    @push('title')
        {{__('Unfinished Delivery')}}
    @endpush

    <div id="app">
        <unfinished-delivery-component :translations="{{$translations}}" :delivery="{{$delivery}}" :location="{{$location}}"></unfinished-delivery-component>
    </div>

    

@endsection
