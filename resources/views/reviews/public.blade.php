@extends('layouts.publicLayout')

@section('content')

<div id="app">
    <rate-us-component :settings="{{$settings}}"></rate-us-component>
</div>

@endsection