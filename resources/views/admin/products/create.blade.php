@extends('layouts.adminLayout')


@section('content')

@push('title')
{{__('Create Product')}}
@endpush


<div id="app" > 
    <create-product :storage="{{json_encode($storage)}}" :translations="{{ $translations }}" ></create-product>
</div>



@endsection