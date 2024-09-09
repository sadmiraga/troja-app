@extends('layouts.adminLayout')

@push('title')
    {{ __('Support ticket') }}
@endpush

@section('css')
    <style>
        #help-button{
            display: none !important;
        }
    </style>
@endsection

@section('content')

<!-- go back function -->
<script>
    var goBackButton = document.getElementById("back-button");
    goBackButton.addEventListener('click', this.goBack);
    function goBack(){
        window.history.back();
    }
</script>

<div id="app">
    <support-component :prev_url="{{json_encode($prev_url)}}" :location="{{$location}}" :translations="{{$translations}}"></support-component>
</div>
@endsection