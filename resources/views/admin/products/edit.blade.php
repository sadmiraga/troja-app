@extends('layouts.adminLayout')


@section('content')

@push('title')
{{__('Edit Product')}} ( {{$product->name}} )
@endpush

<div id="app">
    <edit-product :product="{{$product}}" :translations="{{$translations}}" :product_count="{{$product_count}}" :locations="{{json_encode($locations)}}" :category="{{$category}}"></edit-product>
</div>



@endsection