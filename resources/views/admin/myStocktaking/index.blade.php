@extends('layouts.adminLayout')

@push('title')
{{__('My stocktakings')}}
<script src="{{ asset('js/goback.js') }}" defer></script>
@endpush

@section('content')

<div id="app">
    <my-stocktakings :stocktakings=" {{ json_encode($stocktakings) }} " :translations="{{$translations}}" :open_stocktaking_id="{{$open_stocktaking_id}}" ></my-stocktakings>
</div>


@endsection