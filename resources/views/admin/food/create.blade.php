@extends('layouts.adminLayout')


@section('content')

@push('title')
Dodaj hrano
@endpush


<div id="app">
    <new-food-component :categories="{{json_encode($categories)}}" :allergens="{{json_encode($allergens)}}"></new-food-component>
</div>





@endsection