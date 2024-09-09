@extends('layouts.adminLayout')

@push('title')
{{__('Users')}}
<script src="{{ asset('js/goback.js') }}" defer></script>
@endpush

@section('content')

<div id="app">
    <users-component :users="{{json_encode($users)}}" :translations="{{$translations}}"></users-component>
</div>

@endsection