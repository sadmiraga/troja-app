@extends('layouts.adminLayout')

@section('content')

@push('title')
Tedenska ponudba
@endpush

<div id="app">
    <index-weekly-component :food="{{json_encode($food)}}"></index-weekly-component>
</div>


@endsection