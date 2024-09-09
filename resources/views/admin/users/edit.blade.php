@extends('layouts.adminLayout')

@push('title')
{{__('Edit User')}}   ( {{$user->name}} )
<script src="{{ asset('js/goback.js') }}" defer></script>
@endpush

@section('content')

<div id="app">
    <edit-user 
    :user_types="{{ json_encode($user_types) }}" 
    :user="{{ json_encode($user) }}" 
    :translations="{{ $translations }}" 
    :permissions="{{ json_encode($permissions) }}">
</edit-user>
</div>

@endsection