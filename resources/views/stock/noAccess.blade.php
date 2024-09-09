@extends('layouts.adminLayout')


@push('title')
    {{ __('No access') }}
    <script src="{{ asset('js/goback.js') }}" defer></script>
@endpush

@section('css')
    <style>
        #choose-location,#open-sidebar-button{
            display: none;
        }
    </style>
@endsection

@section('content')

<div class="text-center m-auto w-50 ">
    <h3 class="p-bold mt-5">{{__('You dont have access to this page')}}</h3>

    <div class="drinks-food-create-edit__bottom-buttons two-button-wrapper d-flex justify-content-center mt-5">

        <!-- YES -->
        <a class="w-50" href="{{route('dashboard')}}">
            <button class="drinks-food-create-edit__add-allergens-button" style="border: 2px solid #1C6979;">
                {{__('Go back to dashboard')}}
            </button>
        </a>

    </div>
    
</div>

@endsection