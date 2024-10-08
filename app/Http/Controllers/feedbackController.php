<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Settings;

class feedbackController extends Controller
{

    public function public(){
        $locale = App::getLocale();
        $settings = Settings::first();
        return view('reviews.public',compact('settings'));
    }
}
