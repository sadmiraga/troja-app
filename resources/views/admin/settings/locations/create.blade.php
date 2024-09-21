@extends('layouts.adminLayout')


@section('content')

@push('title')
Settings / Create Location
@endpush

<div id="app" > 
    <div class="categories-create-edit-container">

        <form method="POST" action="{{ route('settings.locations.store') }}" enctype="multipart/form-data">

            <!-- Name -->
            <div class="form-group mb-3 mt-5 row">
                <label class="form-label col-3 col-form-label">Location Name</label>
                <div class="col">
                    <input type="text"  id="name" name="name" class="form-control" placeholder="Enter the short name of location">
                </div>
            </div>

            <!-- Address -->
            <div class="form-group mb-3 mt-5 row">
                <label class="form-label col-3 col-form-label">Address</label>
                <div class="col">
                    <input type="text"  id="address" name="address" class="form-control" placeholder="Enter the address of location">
                </div>
            </div>


            <!-- LOGO -->
            <div class="form-group mb-3 mt-5 row">
                <label class="form-label col-3 col-form-label">Location Image</label>
                <div class="col">
                    <input type="file" id="image" name="image" class="form-control">
                </div>
            </div>
            


            <!-- Buttons -->
            <div class="drinks-food-create-edit__bottom-buttons mt-5">
                <button type="submit" class="drinks-food-create-edit__add-allergens-button">
                    Ustvari Lokacijo
                </button>
            </div>
            
            
            

            
        </form>
    </div>
</div>



@endsection