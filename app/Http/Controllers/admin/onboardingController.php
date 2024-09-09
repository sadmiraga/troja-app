<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Stocktaking;
use App\Models\{UserType,Delivery,Needing};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




use Illuminate\Support\Facades\Config;

class onboardingController extends Controller
{

    //after LOGIn
    public function onboarding()
    {
        //get current user
        $user = Auth::user();

        if($user == null){
            return redirect()->route("login");
        }

        // get unfinished stocktaking
        $stocktaking = Stocktaking::where('completed', false)->where('user_id', $user->id)->first();

        if($stocktaking != null){

            //set location from previous location 
            session(['location' => $stocktaking->location_id]);

            //choose action with previous stocktaking 
            return redirect()->route('continue.stocktaking',$stocktaking->id);
        }

        //check if there is unfinished delivery
        $open_delivery_id  = $this->getOpenDeliveryID();

        if($open_delivery_id != 0){
            
            $delivery = Delivery::find($open_delivery_id);

            //set location from previous location 
            session(['location' => $delivery->location_id]);

            return redirect()->route('delivery.unfinished',$open_delivery_id);
        }

        //check if there is unfinished needing list. 
        $opened_needing = Needing::where('user_id',auth()->user()->id)->where('completed',false)->first();
        
        if($opened_needing != null){
            //set location from previous location 
            session(['location' => $opened_needing->location_id]);

            return redirect()->route('needing.unfinished',$opened_needing->id);
        }


        //default action.
        return redirect()->route('locations'); //chose location

    }

    public function continueStocktaking($stocktaking_id){
        $stocktaking = Stocktaking::find($stocktaking_id);
        $location = Location::find($stocktaking->location_id);
        return view('admin.onboarding.continueStocktaking',compact('stocktaking','location'));
    }



    public function locations()
    {
        $locations = Location::all();
        return view('admin.locations.index', compact('locations'));
    }

    //chose location 
    public function chooselocation($location_id)
    {
        session(['location' => $location_id]);
        $location = session('location');
        return redirect()->route('dashboard');
    }


    public function dashboard()
    {
        $location_id = session('location');   
        if($location_id == null){
            return redirect()->route('locations');
        }

        $user  = auth()->user();
        $user_type = UserType::find($user->user_type_id);
        $location = $this->getCurrentLocation();
        return view('admin.dashboard',compact('location','user','user_type','location'));
    }

    public function changeLang($lang){
        app()->setLocale($lang);
        return 'LANGAUGE SUCCESSFULLY CHANGED';
    }
}
