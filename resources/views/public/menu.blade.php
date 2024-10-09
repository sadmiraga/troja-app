@extends('layouts.publicLayout')

@section('title_tag')
{{$location->name}}
@endsection

@section('content')


<div id="app">
    <menu-component :drink_categories="{{json_encode($drink_categories)}}" 
                    :food_categories="{{json_encode($food_categories)}}"
                    :menu_items="{{json_encode($menu_items)}}"
                    :allergens="{{json_encode($allergens)}}"
                    :settings="{{$settings}}"
                    :languages="{{$languages}}"
                    locale="{{$locale}}"
                    :translations="{{$translations}}"
                    ></menu-component>
</div>

@endsection