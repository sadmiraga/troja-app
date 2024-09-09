@extends('layouts.adminLayout')

@section('content')

@push('title')
Pijače
@endpush

<div id="app">
    <drinks-component :drinks="{{json_encode($drinks)}}" :food="{{json_encode($food)}}"></drinks-component>
</div>



@endsection