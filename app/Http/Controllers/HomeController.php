<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

     /*
    public function __construct()
    {
        $this->middleware('auth');
    }
    */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function changeLang($locale){
        
        app()->setLocale(strtolower($locale));
        session()->put('locale', $locale);

        $locale = App::getLocale();

        //return redirect()->route('meni');
        return redirect()->back();
        // Store user's locale preference in a cookie
        //return redirect()->route('dashboard')->withCookie(cookie('locale', $locale, 43200)); // 43200 minutes = 30 days
    }



    public function adminLayout(){
        return view('layouts.adminLayout');
    }

    public function publicLayout(){
        return view('layouts.publicLayout');
    }

    public function support(){
        $prev_url = $_SERVER['HTTP_REFERER'];
        $location = $this->getCurrentLocation();

        $translations = json_encode([
            'Enter_page_name_where_problem_occured' => trans('Enter page name where problem occured'),
            'Describe_your_problem' => trans('Describe your problem'),
            'Send_support_ticket' => trans('Send support ticket'),
            'You_successfully_submited_support_ticket_We_will_resolve_the_problem_and_contact_you_ass_soon_as_possible' => trans('You successfully submited support ticket. We will resolve the problem and contact you ass soon as possible.'),

        ]);


        return view('support',compact('prev_url','location','translations'));
    }

    public function createTicket(Request $request){

        $link = $request->link;

        $ticket = new Ticket();
        $ticket->link = $link;
        $ticket->location_id = $this->getLocationID();
        $ticket->user_id = auth()->user()->id;
        $ticket->message = $request->description;
        $ticket->name = $request->name;
        $ticket->save();

        $user = User::find($ticket->user_id);

        Mail::send('emails.support', ["ticket" => $ticket,"user"=>$user], function ($message) use ($request) {
            $message->to("sadmirvela@gmail.com")->subject('chabli - SUPPORT TICKET');
        });
        return response('success');
    }


    
    public function bottleCalculator(){
        return view('microservices.bottle-calculator');
    }
    



    public function backupDB(){
        
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
    
        $filename = "backup-" . date('Y-m-d_H-i-s') . ".sql";
        $fullPath = public_path("backups/".$filename);
        $command = "mysqldump -u $dbUser -p'$dbPass' $dbName > " . escapeshellarg($fullPath);
    
        exec($command);
    
        return response()->json(['message' => 'Database backup saved in public folder.', 'filename' => $filename]);
    }


}
