@extends('layouts.adminLayout')


@section('content')

@push('title')
Settings / Style
@endpush

<div id="app" > 
    <div class="categories-create-edit-container">

        <form method="POST" action="{{ route('settings.save.style') }}" enctype="multipart/form-data">


            <!-- LOGO -->
            <div class="form-group mb-3 mt-5 row">
                <label class="form-label col-3 col-form-label">Logo</label>
                <div class="col">
                    <input type="file" id="logo" name="logo" class="form-control">
                </div>
            </div>

            <!-- Instagram -->
            <div class="form-group mb-3 mt-5 row">
                <label class="form-label col-3 col-form-label">Instagram Link</label>
                <div class="col">
                    <input type="text" value="<?php if($settings->instagram != null){ echo $settings->instagram; } ?>" id="dark_color" name="instagram" class="form-control" placeholder="Enter Instagram link">
                </div>
            </div>

            <!-- Facebook -->
            <div class="form-group mb-3 mt-5 row">
                <label class="form-label col-3 col-form-label">Facebook Link</label>
                <div class="col">
                    <input type="text" value="<?php if($settings->facebook != null){ echo $settings->facebook; } ?>" id="dark_color" name="facebook" class="form-control" placeholder="Enter facebook link">
                </div>
            </div>

            <!-- Primary Color -->
            <div class="form-group mb-3 mt-5 row">
                <label class="form-label col-3 col-form-label">Primary Color</label>
                <div class="col">
                    <input type="text" value="<?php if($settings != null){ echo $settings->primary_color; } ?>" id="primary_color" name="primary_color" class="form-control" placeholder="Enter hexa value for Primary color">
                </div>
            </div>

            <!-- Secondary Color -->
            <div class="form-group mb-3 mt-5 row">
                <label class="form-label col-3 col-form-label">Secondary Color</label>
                <div class="col">
                    <input type="text" value="<?php if($settings != null){ echo $settings->secondary_color; } ?>" id="secondary_color" name="secondary_color" class="form-control" placeholder="Enter hexa value for Secondary color">
                </div>
            </div>

            <!-- Tertiary Color -->
            <div class="form-group mb-3 mt-5 row">
                <label class="form-label col-3 col-form-label">Secondary Color</label>
                <div class="col">
                    <input type="text" value="<?php if($settings != null){ echo $settings->tertiary_color; } ?>" id="tertiary_color" name="tertiary_color" class="form-control" placeholder="Enter hexa value for Tertiary color">
                </div>
            </div>

            <!-- Accent Color -->
            <div class="form-group mb-3 mt-5 row">
                <label class="form-label col-3 col-form-label">Accent Color</label>
                <div class="col">
                    <input type="text" value="<?php if($settings != null){ echo $settings->accent_color; } ?>" id="accent_color" name="accent_color" class="form-control" placeholder="Enter hexa value for Accent color">
                </div>
            </div>


            <!-- Accent Opacity Color -->
            <div class="form-group mb-3 mt-5 row">
                <label class="form-label col-3 col-form-label">Accent Opacity Color</label>
                <div class="col">
                    <input type="text" value="<?php if($settings != null){ echo $settings->accent_opacity_color; } ?>" id="accent_opacity_color" name="accent_opacity_color" class="form-control" placeholder="Enter hexa value for Accent color">
                </div>
            </div>


            <!-- Light Color -->
            <div class="form-group mb-3 mt-5 row">
                <label class="form-label col-3 col-form-label">Light Color</label>
                <div class="col">
                    <input type="text" value="<?php if($settings != null){ echo $settings->light_color; } ?>" id="light_color" name="light_color" class="form-control" placeholder="Enter hexa value for Accent color">
                </div>
            </div>


            <!-- Dark Color -->
            <div class="form-group mb-3 mt-5 row">
                <label class="form-label col-3 col-form-label">Dark Color</label>
                <div class="col">
                    <input type="text" value="<?php if($settings != null){ echo $settings->dark_color; } ?>" id="dark_color" name="dark_color" class="form-control" placeholder="Enter hexa value for Accent color">
                </div>
            </div>

            


            <!-- Buttons -->
            <div class="drinks-food-create-edit__bottom-buttons mt-5">
                <button class="drinks-food-create-edit__add-allergens-button">
                    Shrani Nastavitve
                </button>
            </div>
            
            
            

            
        </form>
    </div>
</div>



@endsection