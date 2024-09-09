<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Event;

class EventController extends Controller
{
    public function index(){
        $events = Event::orderBy('date','desc')->get();
        return view('admin.events.index',compact('events'));
    }

    public function create(){
        return view('admin.events.create');
    }

    public function edit($event_id){
        $event = Event::find($event_id);
        return view('admin.events.edit',compact('event'));
    }

    //test data date = 
    public function store(Request $request){

        $price = $request->input('price');
        if ($price === null) {
            $price = 0; // or another default value
        }
        
        $event = new Event();
        $event->name = $request->input('name');
        $event->date = $request->input('date');
        $event->time = $request->input('time');
        $event->location = $request->input('location');
        $event->description = $request->input('description');
        $event->price = $price;

        $image = $request->file('image');
        if ($request->hasFile('image')) {

            $original_name = $image->getClientOriginalName();
            $imageName = Str::slug($original_name);
            $image->move(public_path('images_dynamic/events'), $imageName);
            $event->image = $imageName;
        }

        $event->save();

        return response("success");
    }
    
    public function update(Request $request){

        //get price 
        $price = $request->input('price');
        if ($price === null) {
            $price = 0;
        }

        //get event
        $event_id = $request->input('event_id');
        $event = Event::find($event_id);

        $event->name = $request->input('name');
        $event->date = $request->input('date');
        $event->time = $request->input('time');
        $event->location = $request->input('location');
        $event->description = $request->input('description');
        $event->price = $price;

        $image = $request->file('image');
        if ($request->hasFile('image')) {

            $original_name = $image->getClientOriginalName();
            $imageName = Str::slug($original_name);
            $image->move(public_path('images_dynamic/events'), $imageName);
            $event->image = $imageName;
        }

        $event->save();

        return response("success");

    }

    public function search(Request $request){

        $query = $request->input('query');
        $events = Event::orderBy('date','desc')->where('name', 'LIKE', $query . '%')->get();
        return response($events);
    }

}
