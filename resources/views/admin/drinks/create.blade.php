@extends('layouts.adminLayout')


@section('content')

@push('title')
Dodaj pijačo
@endpush


<div id="app">
    <new-drink-component :categories="{{json_encode($categories)}}" :allergens="{{json_encode($allergens)}}"></new-drink-component>
</div>



@endsection