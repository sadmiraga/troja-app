<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TranslationsController extends Controller
{
    //

    public function createProduct(){
        
        $translations = json_encode([
            'Enter_product_name' => trans('Enter product name'),
            'Choose_category' => trans('Choose category'),
        ]);

        return response($translations);

    }
}
