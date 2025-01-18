@extends('layouts.adminLayout')

@push('title')
{{__('Choose stocktaking method')}}
<script src="{{ asset('js/goback.js') }}" defer></script>

<style>
    @media only screen and (max-width:700px){

        .public-events-list{
            display: flex;
            gap: 1rem;
        }

        .public-events-list .card-button{
            width: 50% !important;
            height: 120px;
            padding-top: 20px;
        }
    }
</style>
@endpush

@section('content')


<div id="app">
    <start-stocktaking :translations="{{$translations}}" :settings="{{json_encode($settings)}}" ></start-stocktaking>
</div>


@endsection