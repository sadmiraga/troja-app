<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;

use Carbon\Carbon;

class EventController extends Controller
{
    public function index(){
        $today = Carbon::now()->toDateString(); 
        $events = Event::where('date', '>', $today)->orderBy('date','asc')->get();
        return view('public.events',compact('events'));
    }
}
