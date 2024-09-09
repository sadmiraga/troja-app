<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Location;

class ApiController extends Controller
{
    //

    public function getLocations()
    {
        $locations = Location::get();
        return response($locations);
    }

    public function getCurrentLocationID()
    {
        $location = session('location');
        return response($location);
    }

    public function getCurrentLocation()
    {
        $location_id = session('location');
        $location = Location::find($location_id);
        return $location;
    }


    //get categories with SELECTED LOCATIONS.
    public function getCategories(Request $request)
    {
        $type = $request->type;
        
        $selectedLocationIds = $request->input('selected_location_ids', []);
        $locationCount = count($selectedLocationIds);

        /*
        $categories = Category::whereIn('location_id', $selectedLocationIds)
                            ->whereNull('deleted_at')
                            ->select('categoryName', DB::raw('COUNT(DISTINCT location_id) as locationCount'))
                            ->groupBy('categoryName')
                            ->havingRaw('COUNT(DISTINCT location_id) = ?', [$locationCount])
                            ->get();
        */


        $categories = DB::table('categories')
        ->select(
            'categoryName',
            DB::raw('MIN(id) as id'), // Get the smallest id for each categoryName
            DB::raw('COUNT(DISTINCT location_id) as locationCount')
        )
        ->whereIn('location_id', $selectedLocationIds)
        ->whereNull('deleted_at')
        ->where('drink_or_food',$type)
        ->groupBy('categoryName')
        ->havingRaw('COUNT(DISTINCT location_id) = ?', [$locationCount])
        ->get();
            

        //dd($categories);
        return response(json_encode($categories));
    }



}
