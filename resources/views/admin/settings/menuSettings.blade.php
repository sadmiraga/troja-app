@extends('layouts.adminLayout')


@section('content')

@push('title')
Menu Settings
@endpush


<div id="app">
    <menu-settings-component :settings="{{$settings}}"></menu-settings-component>
</div>



@endsection