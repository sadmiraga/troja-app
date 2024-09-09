@extends('layouts.adminLayout')

@push('title')
{{__('Edit Category')}}
<script src="{{ asset('js/goback.js') }}" defer></script>
@endpush

@section('content')


<div id="app">
    <editcategory-component :category="{{$category}}" :translations="{{$translations}}" :category_count="{{$category_count}}" :locations="{{json_encode($locations)}}" ></editcategory-component>
</div>



@endsection