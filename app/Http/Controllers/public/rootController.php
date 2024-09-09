<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class rootController extends Controller
{
    public function index(){

        return redirect()->route('onboarding');

        return redirect()->route('category.index');

        $today = Carbon::now()->toDateString(); 
        $events = Event::where('date', '>', $today)->orderBy('date','asc')->get();
        return view('landing.home',compact('events'));
    }

    public function renting(){
        $today = Carbon::now()->toDateString(); 
        $events = Event::where('date', '>', $today)->orderBy('date','asc')->get();
        return view('landing.renting',compact('events'));
    }

    public function catering(){
        return view('landing.catering');
    }

    public function admin(){
        
        if(Auth::check()) {
            return redirect()->route('category.index');
        } else {
            return redirect()->route('login');
        }

        
    }
}
