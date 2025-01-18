@extends('layouts.adminLayout')

@push('title')
Reviews
<script src="{{ asset('js/goback.js') }}" defer></script>
@endpush

@section('content')

<div id="app">
    <reviews-component :reviews="{{json_encode($reviews)}}"></reviews-component>
</div>

@endsection