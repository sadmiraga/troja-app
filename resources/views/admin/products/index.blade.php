@extends('layouts.adminLayout')

@push('title')
{{__('Products')}}
<script src="{{ asset('js/goback.js') }}" defer></script>
@endpush

@section('content')


<div id="app">
    <products-component :products="{{json_encode($products)}}" :translations="{{$translations}}" :settings="{{json_encode($settings)}}"></products-component>
</div>

@endsection