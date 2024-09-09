@extends('layouts.adminLayout')

@section('content')

@push('title')
{{__('Invite user')}}
<script src="{{ asset('js/goback.js') }}" defer></script>
@endpush

<div id="app">
    <invite-user :user_types="{{json_encode($user_types)}}" :translations="{{$translations}}"></invite-user>
</div>



@endsection