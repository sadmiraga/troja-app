@extends('layouts.adminLayout')


@section('content')

@push('title')
Uredi pijačo
@endpush

<div id="app">
    <edit-drink-component :drink="{{ $drink }}" :categories="{{ json_encode($categories) }}" :allergens="{{ json_encode($allergens) }}" :db_selected_allergens="{{ json_encode($db_selected_allergens) }}">
    </edit-drink-component>
</div>
@endsection