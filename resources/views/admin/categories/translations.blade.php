@extends('layouts.adminLayout')

@section('content')

@push('title')
<a href="/category/index" style="color:white;">Categories </a> / {{$category->categoryName}} / Translation
@endpush

<div id="app">
    <category-translation-component :category="{{$category}}" :languages="{{json_encode($languages)}}" :translations="{{json_encode($translations)}}" ></category-translation-component>
</div>


@endsection