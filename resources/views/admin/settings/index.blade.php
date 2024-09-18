@extends('layouts.adminLayout')

@push('title')
Settings
<script src="{{ asset('js/goback.js') }}" defer></script>
@endpush

@section('content')


<div id="app">
    <h1> LOGO OF restaurant. </h1>
    <h1> Locations. </h1>
    <h1> Languages for MENU. </h1>

    <h1> Enable/disable food. </h1>
    <h1> Enable/disable drink. </h1>

    <h1> Enable/disable Weekly menus. </h1>

</div>

@endsection