@extends('layouts.adminLayout')

@push('title')
{{__('Delivery')}}
@endpush

@section('content')

<div id="app">
    <delivery-app-component ></delivery-app-component>
</div>

@endsection