@extends('layouts.adminLayout')

@section('content')

@push('title')
Meni / Ponudba
@endpush

<div id="app">
    <admin-menu-items-component :menu_items="{{json_encode($menu_items)}}" :settings="{{$settings}}"></admin-menu-items-component>
</div>


@endsection