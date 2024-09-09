@extends('layouts.adminLayout')


@section('content')

@push('title')
{{__('Create Category')}}
@endpush

<div id="app" > 
    <newcategory-component :translations="{{$translations}}"></newcategory-component>
</div>



@endsection