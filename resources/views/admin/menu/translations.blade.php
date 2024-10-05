@extends('layouts.adminLayout')

@section('content')

@push('title')
<a href="/menu_items" style="color:white;">Menu Items </a> / {{$menu_item->name}} / Translation
@endpush

<div id="app">
    <menu-item-translations-component :menu_item="{{$menu_item}}" :languages="{{json_encode($languages)}}" :translations="{{json_encode($translations)}}" ></menu-item-translations-component>
</div>


@endsection