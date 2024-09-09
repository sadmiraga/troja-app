@extends('layouts.adminLayout')

@push('title')
{{__('Create Needing list')}}
<script src="{{ asset('js/goback.js') }}" defer></script>
@endpush

@section('content')

<div id="app">
    <start-needing-component :translations="{{$translations}}"></start-needing-component>
</div>

@endsection