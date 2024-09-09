@extends('layouts.adminLayout')


@section('content')

@push('title')
Uredi hrano
@endpush

<div id="app">
    <edit-food-component :food="{{ $food }}" :categories="{{ json_encode($categories) }}" :allergens="{{ json_encode($allergens) }}" :db_selected_allergens="{{ json_encode($db_selected_allergens) }}"></edit-food-component>
</div>

<!-- HTML CODE 
<div class="drinks-food-edit__container">
    <div class="drinks-food-create-edit__photo-container">
        <a href="https://images.unsplash.com/photo-1550547660-d9450f859349?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=465&q=80" target="_blank">
            <img src="https://images.unsplash.com/photo-1550547660-d9450f859349?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=465&q=80" />
        </a>
    </div>
    <div class="drinks-food-create-edit__form-container --edit-form-margin">
        <input type="text" class="drinks-food-create-edit__input" name="name" value="Classic burger" />
        <textarea name="description" id="description" cols="30" rows="10" class="drinks-food-create-edit__input drinks-food-create-edit__textarea">Mmmmmmmmmmmm mnogo dobar burger mmmm</textarea>
        <div class="drinks-food-create-edit__input-with-symbol-container">
            <input type="text" class="drinks-food-create-edit__input-with-symbol" name="price" value="1,8" />

            <div class="drinks-food-create-edit__input-symbol">€</div>
        </div>
        <div class="drinks-food-create-edit__dropdown-container">
            <select name="category" id="category" class="drinks-food-create-edit__dropdown">
                <option value="1">Burgerji</option>
            </select>

            <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg" class="drinks-food-create-edit__dropdown-arrow">
                <path d="M2 0L7 5L12 0L14 1L7 8L0 1L2 0Z" fill="currentColor" />
            </svg>
        </div>
    </div>

    <button class="drinks-food-create-edit__bottom-button">
        Shrani
    </button>
</div> -->

@endsection