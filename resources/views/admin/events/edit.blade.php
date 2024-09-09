@extends('layouts.adminLayout')


@section('content')

@push('title')
Uredi dogodek
@endpush

<div id="app">
    <edit-event-component :event="{{ $event }}"></edit-event-component>
</div>

<!-- 
<div class="drinks-food-create__container">
    <div class="drinks-food-create-edit__form-container">
        <input type="text" class="drinks-food-create-edit__input" value="15. Panč festival Stand-up komedije" />
        <input type="date" class="drinks-food-create-edit__input" placeholder="Izberite datum" value="2022-05-20" />
        <div class="drinks-food-create-edit__input-with-symbol-container">
            <input type="text" class="drinks-food-create-edit__input-with-symbol" placeholder="Vnesite lokacijo dogodka" />

            <div class="drinks-food-create-edit__input-symbol">
                <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 10.833C9.38071 10.833 10.5 9.71372 10.5 8.33301C10.5 6.9523 9.38071 5.83301 8 5.83301C6.61929 5.83301 5.5 6.9523 5.5 8.33301C5.5 9.71372 6.61929 10.833 8 10.833Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7.99992 1.6665C6.23181 1.6665 4.53612 2.36888 3.28587 3.61913C2.03563 4.86937 1.33325 6.56506 1.33325 8.33317C1.33325 9.90984 1.66825 10.9415 2.58325 12.0832L7.99992 18.3332L13.4166 12.0832C14.3316 10.9415 14.6666 9.90984 14.6666 8.33317C14.6666 6.56506 13.9642 4.86937 12.714 3.61913C11.4637 2.36888 9.76803 1.6665 7.99992 1.6665V1.6665Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>

            </div>
        </div>
        <textarea name="description" id="description" cols="30" rows="10" class="drinks-food-create-edit__input drinks-food-create-edit__textarea" placeholder="Vnesi opis dogodka"></textarea>
        <div>
            <div class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
                <label for="weight">Vstopnina</label>
                <div class="drinks-food-allergens__allergen-switch">
                    <label class="switch">
                        <input type="checkbox" checked>
                        <div class="slider round"></div>
                    </label>
                </div>
            </div>
            <div class="drinks-food-create-edit__input-with-symbol-container">
                <input type="text" class="drinks-food-create-edit__input-with-symbol" placeholder="Vnesi ceno vstopnice" value="5,00" name="entryFee" />

                <div class="drinks-food-create-edit__input-symbol">€</div>
            </div>
        </div>
    </div>
    <div class="drinks-food-create-edit__bottom-buttons">
        <div class="drinks-food-create-edit__photo-upload-container">
            <div class="drinks-food-create-edit__input-label">Slika dogodka</div>
            <label for="photo">
                <div class="drinks-food-create-edit__photo-upload" role="button">
                    <div>Spremeni sliko</div>
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
            Shrani dogodek
        </button>
    </div>
</div>
-->

@endsection