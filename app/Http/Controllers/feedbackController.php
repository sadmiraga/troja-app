<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Settings;

class feedbackController extends Controller
{

    public function public(){

        $settings = Settings::first();
        return view('reviews.public',compact('settings'));
    }
}
