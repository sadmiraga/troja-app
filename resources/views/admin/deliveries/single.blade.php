@extends('layouts.adminLayout')

@push('title')
{{__('Delivery')}} {{ formatDateOnly($delivery->created_at) }}
<script src="{{ asset('js/goback.js') }}" defer></script>
@endpush
 
@section('content')


<div id="app">
    <single-delivery-component :delivery="{{$delivery}}" :products="{{json_encode($products)}}" :translations="{{$translations}}"></single-delivery-component>
</div>

@endsection