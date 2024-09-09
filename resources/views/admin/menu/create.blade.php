@extends('layouts.adminLayout')

@section('content')

@push('title')
Crete Menu Item
@endpush

<div id="app">
    <create-menu-items-component
    :food_categories="{{json_encode($food_categories)}}" 
    :drink_categories="{{json_encode($drink_categories)}}" 
    :allergens="{{json_encode($allergens)}}"
    type="{{ $type }}">
    </create-menu-items-component>
</div>


@endsection