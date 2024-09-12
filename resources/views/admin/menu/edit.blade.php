@extends('layouts.adminLayout')

@section('content')

@push('title')
Edit - {{$menu_item->name}}
@endpush

<div id="app">
    <edit-menu-items-component 
    :menu_item="{{$menu_item}}"
    :food_categories="{{json_encode($food_categories)}}" 
    :drink_categories="{{json_encode($drink_categories)}}" 
    :allergens="{{json_encode($allergens)}}"
    :db_selected_allergens="{{json_encode($db_selected_allergens)}}"
    >
</edit-menu-items-component>
</div>


@endsection