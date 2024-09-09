@extends('layouts.adminLayout')

@push('title')
{{__('Compare')}} {{__('Stocktaking')}} {{formatDateOnly($stocktaking->start)}}
<script src="{{ asset('js/goback.js') }}" defer></script>
@endpush

@section('content')

<div id="app">
    <compare-stocktaking :stocktaking_id="{{ $stocktaking->id }}" :translations="{{ $translations }}" ></compare-stocktaking>
</div>

@endsection