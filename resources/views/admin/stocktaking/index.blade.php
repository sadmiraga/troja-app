@extends('layouts.adminLayout')

@push('title')
{{__('Stocktaking archive')}}
<script src="{{ asset('js/goback.js') }}" defer></script>
@endpush

@section('content')

<div id="app">
    <stocktaking-archive :stocktakings="{{json_encode($stocktakings)}}" :translations="{{$translations}}" ></stocktaking-archive>
</div>

@endsection