@extends('layouts.adminLayout')

@push('title')
{{__('Categories')}}
<script src="{{ asset('js/goback.js') }}" defer></script>
@endpush

@section('content')

<div id="app">
    <categories-component :categories="{{json_encode($categories)}}" :translations="{{$translations}}"></categories-component>
</div>

@endsection