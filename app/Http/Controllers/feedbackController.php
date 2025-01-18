<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\{Settings,Review};

class feedbackController extends Controller
{

    public function public(){
        $locale = App::getLocale();
        $settings = Settings::first();
        return view('reviews.public',compact('settings'));
    }

    public function reviewList(){
        $reviews = Review::all();
        return view('reviews.reviewList',compact('reviews'));
    }

    public function store(Request $request){
    

        $review = new Review();
        $review->stars = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return response('success');    
    }
}
