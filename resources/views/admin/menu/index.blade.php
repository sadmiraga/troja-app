@extends('layouts.adminLayout')

@section('content')

@push('title')
Menu Items
@endpush

<div id="app">
    <admin-menu-items-component :menu_items="{{json_encode($menu_items)}}"></admin-menu-items-component>
</div>


@endsection