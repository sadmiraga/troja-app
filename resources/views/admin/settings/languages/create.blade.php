@extends('layouts.adminLayout')


@section('content')

@push('title')
Settings / Add Language
@endpush

<div id="app" > 
    <div class="categories-create-edit-container">

        <form method="POST" action="{{ route('settings.languages.store') }}" enctype="multipart/form-data">

            <!-- Name -->
            <div class="form-group mb-3 mt-5 row">
                <label class="form-label col-3 col-form-label">Language Name</label>
                <div class="col">
                    <input type="text"  id="name" name="name" class="form-control" placeholder="Vpiši ime jezika">
                </div>
            </div>


            <!-- Name -->
            <div class="form-group mb-3 mt-5 row">
                <label class="form-label col-3 col-form-label">Language Shortcode</label>
                <div class="col">
                    <input type="text"  id="shortcode" name="shortcode" class="form-control" placeholder="Vpiši ime jezika">
                </div>
            </div>


            <textarea name="icon" class="category-create-edit__input" rows="15" v-model="icon" placeholder="Add SVG code for ICON" style="height:fit-content;">
            </textarea>
            


            <!-- Buttons -->
            <div class="drinks-food-create-edit__bottom-buttons mt-5">
                <button type="submit" class="drinks-food-create-edit__add-allergens-button">
                    Ustvari jezik
                </button>
            </div>
            
        </form>
    </div>
</div>



@endsection