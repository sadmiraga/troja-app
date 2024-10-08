@extends('layouts.adminLayout')

@push('title')
  {{ $location->name }}  /  {{__('Stocktaking')}}  /  {{ $stocktaking->storage }} 
@endpush

@section('buttonCorner')
    <button id="cancel-stocktaking" class="btn btn-danger cancel-button">
        <span>{{__('Cancel')}}</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16" id="close"><path fill="white" d="M2.39705176,2.55378835 L2.46966991,2.46966991 C2.73593648,2.20340335 3.15260016,2.1791973 3.44621165,2.39705176 L3.53033009,2.46966991 L8,6.939 L12.4696699,2.46966991 C12.7625631,2.1767767 13.2374369,2.1767767 13.5303301,2.46966991 C13.8232233,2.76256313 13.8232233,3.23743687 13.5303301,3.53033009 L9.061,8 L13.5303301,12.4696699 C13.7965966,12.7359365 13.8208027,13.1526002 13.6029482,13.4462117 L13.5303301,13.5303301 C13.2640635,13.7965966 12.8473998,13.8208027 12.5537883,13.6029482 L12.4696699,13.5303301 L8,9.061 L3.53033009,13.5303301 C3.23743687,13.8232233 2.76256313,13.8232233 2.46966991,13.5303301 C2.1767767,13.2374369 2.1767767,12.7625631 2.46966991,12.4696699 L6.939,8 L2.46966991,3.53033009 C2.20340335,3.26406352 2.1791973,2.84739984 2.39705176,2.55378835 L2.46966991,2.46966991 L2.39705176,2.55378835 Z"></path></svg>
    </button>
@endsection

@section('css')
    <style>
        #choose-location, #sidebar, .btn-primary{
            display: none !important;
        }
    </style>
@endsection



@section('content')
    <div id="app">
        <stocktaking-app :stocktaking="{{$stocktaking}}" 
                        :products="{{json_encode($products)}}" 
                        :added_products="{{json_encode($added_products)}}"
                        :translations="{{$translations}}"></stocktaking-app>
    </div>
@endsection