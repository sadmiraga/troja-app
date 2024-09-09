@extends('layouts.adminLayout')

@push('title') 
{{ $needing->storage }} /  {{__('Needing list')}}
<script src="{{ asset('js/goback.js') }}" defer></script>
@endpush

@section('content')

<div id="app">
    <single-needing :translations="{{$translations}}" :products="{{json_encode($products)}}" :needing="{{$needing}}" ></single-needing>
</div>



@endsection