@extends('layouts.adminLayout')

@push('title')
{{__('Choose delivery storage')}}
@endpush

@section('content')

<div id="app">
    <start-delivery-component :translations="{{$translations}}" ></start-delivery-component>
</div>

@endsection