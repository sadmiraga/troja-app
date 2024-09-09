@extends('layouts.adminLayout')

@section('css')
<style>
    #help-button button{
        display: none !important;
    }
</style>
@endsection


@section('content')

@push('title')
{{__('Import Delivery')}}
@endpush

<div id="app" > 
    <import-delivery-component></import-delivery-component>
</div>



@endsection