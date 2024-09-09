@extends('layouts.adminLayout')

@push('title')
{{__('Stocktaking')}} {{formatDateOnly($stocktaking->start)}}
<script src="{{ asset('js/goback.js') }}" defer></script>
@endpush

@section('content')

<div id="app">
    <inspect-stocktaking :stocktaking="{{$stocktaking}}" :products="{{json_encode($products)}}" :translations="{{$translations}}" ></inspect-stocktaking>
</div>

@endsection