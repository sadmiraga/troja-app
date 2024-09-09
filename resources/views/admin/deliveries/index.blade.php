@extends('layouts.adminLayout')

@push('title')
{{__('Deliveries')}}
<script src="{{ asset('js/goback.js') }}" defer></script>
@endpush

@section('content')



<div id="app">
    <deliveries-component :deliveries="{{json_encode($deliveries)}}" 
                        :translations="{{$translations}}" 
                        :open_delivery_id="{{$open_delivery_id}}"
                        :user="{{auth()->user()}}"
    ></deliveries-component>
</div>

@endsection 