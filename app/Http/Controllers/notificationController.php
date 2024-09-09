<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class notificationController extends Controller
{
    //

    public function submitForm(Request $request){

        //dd($request->all());
        //dd($request->input('date'));
        
        $submission = new Submission();
        $submission->first_name = $request->input('first_name');
        $submission->last_name = $request->input('last_name');
        $submission->email = $request->input('email');
        $submission->phone = $request->input('phone');
        $submission->company = $request->input('company');
        $submission->number_of_guests = $request->input('number_of_guests');
        $submission->date = $request->input('date');
        $submission->notes = $request->input('notes');
        $submission->save();

        //$message->to("sadmirvela@gmail.com")->subject('Rezervacija FNX');

        Mail::send('emails.booking', ["submission"=>$submission], function ($message) {
            $message->to("info@fnx.si")->subject('Rezervacija FNX');
        });

        return response('success');
    }
}
