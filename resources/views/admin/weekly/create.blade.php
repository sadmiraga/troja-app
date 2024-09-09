@extends('layouts.adminLayout')


@section('content')

@push('title')
Dodaj tedensko ponudbo
@endpush

<div id="app">
    <create-weekly-component :categories="{{json_encode($categories)}}" :allergens="{{json_encode($allergens)}}"></create-weekly-component>
</div>

<!-- html code -->
<!-- 
<div class="drinks-food-create__container">
    <div class="drinks-food-create-edit__form-container">
        <input type="text" class="drinks-food-create-edit__input" placeholder="Vnesite ime artikla" />
        <div class="drinks-food-create-edit__input-with-symbol-container">
            <input type="text" class="drinks-food-create-edit__input-with-symbol" placeholder="Vnesite ceno artikla" />

            <div class="drinks-food-create-edit__input-symbol">€</div>
        </div>
        <input type="date" class="drinks-food-create-edit__input" placeholder="Izberite datum" />
        <textarea name="description" id="description" cols="30" rows="10" class="drinks-food-create-edit__input drinks-food-create-edit__textarea" placeholder="Vnesi opis izdelka"></textarea>
        <div>
            <div class="drinks-food-create-edit__input-label">
                <label for="category">Izberite kategorijo artikla</label>
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
        <div>
            <div class="drinks-food-create-edit__weight-label">
                <label for="weight">Teža hrane. Ni obvezno polje.</label>
            </div>

            <div class="drinks-food-create-edit__input-with-symbol-container">
                <input type="text" class="drinks-food-create-edit__input-with-symbol" value="0,00" name="weight" />

                <div class="drinks-food-create-edit__input-symbol">g</div>
            </div>
        </div>
    </div>
    <div class="drinks-food-create-edit__bottom-buttons">
        <div class="drinks-food-create-edit__photo-upload-container">
            <div class="drinks-food-create-edit__input-label">Slika artikla</div>
            <label for="photo">
                <div class="drinks-food-create-edit__photo-upload" role="button">
                    <div>Dodaj sliko</div>
                    <div class="drinks-food-create-edit__photo-upload-icon">
                        <svg width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.944 6.612C16.507 3.17 13.56 0.5 10 0.5C7.244 0.5 4.85 2.111 3.757 4.65C1.609 5.292 0 7.32 0 9.5C0 12.257 2.243 14.5 5 14.5H16C18.206 14.5 20 12.706 20 10.5C19.9985 9.60361 19.6966 8.73358 19.1427 8.02883C18.5888 7.32408 17.8147 6.82526 16.944 6.612ZM11 9.5V12.5H9V9.5H6L10 4.5L14 9.5H11Z" fill="currentColor" />
                        </svg>
                    </div>
                </div>
                <input type="file" name="photo" id="photo">
            </label>
        </div>
        <button class="drinks-food-create-edit__add-allergens-button">
            Dodaj alergene
        </button>
    </div>
</div>
-->

@endsection