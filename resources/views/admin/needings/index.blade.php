@extends('layouts.adminLayout')

@push('title')
{{__('Needing')}}
<script src="{{ asset('js/goback.js') }}" defer></script>
@endpush

@section('content')


<div id="app">
    <needings-component :translations="{{$translations}}"
                        :needings="{{json_encode($needings)}}"
                        :opened_needing="{{json_encode($opened_needing)}}"
                        :user="{{$user}}"
    ></needings-component>
</div>

@endsection