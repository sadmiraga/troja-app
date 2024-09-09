<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class adminController extends Controller
{
    //
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }


    public function noAccess(){
        return view('stock.noAccess');
    }
}
