<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Needing;
use App\Models\Location;
use App\Models\ProductNeedings;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Exports\NeedingExport;
use Maatwebsite\Excel\Facades\Excel;

class needingController extends Controller
{
    //

    public function export($needing_id){

        $needing = Needing::find($needing_id);
        $location = Location::find($needing->location_id);
        $filename =  $location->name." - ".$needing->storage." - Liste mit Bedarf.xlsx";

        return Excel::download(new NeedingExport($needing_id), $filename);
    }

    public function index(){

        $translations = json_encode([
            'Products' => trans('Products'),
            'Yes' => trans('Yes'),
            'No' => trans('No'),
            'Continue' => trans('Continue'),
            'Employee' => trans('Employee'),
            'Location' => trans('Location'),
            'Date' => trans('Date'),
            'Time' => trans('Time'),
            'Edit' => trans('Edit'),
            'View' => trans('View'),
            'Delete' => trans('Delete'),
            'Continue_confirmation' => trans('Continue confirmation'),
            'Confirm' => trans('Confirm'),
            'Confirmed' => trans('Confirmed'),
            'Confirmation_in_progress' => trans('Confirmation in progress'),
            'confirm_needing_list_explanation' => trans('confirm_needing_list_explanation'),
            'Are_you_sure_you_want_to_confirm_shipping_of_this_needing_list' => trans('Are you sure you want to confirm shipping of this needing list?'),
            'This_will_result_in_losing_all_products_noted_to_needing_list_will_lost' => trans('This will result in losing all products noted to needing list will lost.'),
            'Are_you_sure_you_want_to_delete_needing_list' => trans('Are you sure you want to delete needing list?'),
            'Other_users_will_not_be_able_to_preview_this_needing_list_while_you_edit_it' => trans('Other users will not be able to preview this needing list while you edit it.'),
            'Are_you_sure_you_want_to_edit_needing_list' => trans('Are you sure you want to edit needing list?'),
            'Needing_list_is_not_completed_yet' => trans('Needing list is not completed yet'),
            'Search_needing_lists' => trans('Search needing lists'),
        ]);

        $needings = DB::table('needings')
            ->select(
                'needings.id as id',
                'needings.storage as storage',
                'needings.completed as completed',
                'needings.confirmed_status as confirmed_status',
                'needings.updated_end_time as updated_end_time',
                'users.name as user_name',
                'users.id as user_id',
                'locations.name as location_name',
                'deliveries.id as delivery_id',
                'deliveries.user_id as delivery_user_id',
            )
            ->join('locations', 'locations.id', '=', 'needings.location_id')
            ->leftJoin('deliveries','deliveries.needing_id','needings.id')
            ->join('users', 'users.id', '=', 'needings.user_id')
            ->orderBy('needings.created_at', 'desc')
            ->get();

        $opened_needing = Needing::where('user_id',auth()->user()->id)->where('completed',false)->first();

        $user = auth()->user();

        return view('admin.needings.index',compact('translations','needings','opened_needing','user'));
    }

    public function edit($needing_id){
        $needing = Needing::find($needing_id);
        $needing->completed = false;
        $needing->save();
        
        return redirect()->route('needing.app',$needing->id);
    }

    public function delete($needing_id){

        $needing = Needing::find($needing_id);
        $needing->delete();

        return redirect()->route('needing.index');
    }

    public function view($needing_id){
        
        $products = DB::table('products')
        ->select(
            'products.id as product_id',
            'products.name as name',
            'products.enum as enum',
            'products.packing_size as packing_size',
            'product_needings.quantity as quantity',
            'product_needings.weight as weight',
            'product_needings.liters as liters',
            'product_needings.id as product_needing_id',
            'product_needings.needing_id as needing_id',
        )
        ->join('product_needings', 'product_needings.product_id', '=', 'products.id')
        ->where('product_needings.needing_id',$needing_id)
        ->get();

        $needing = Needing::find($needing_id);

        $translations = json_encode([
            'Bar' => trans('Bar'),
            'Name' => trans('Name'),
            'Edit' => trans('Edit'),
            'Confirm' => trans('Confirm'),
            'Search_products' => trans('Search products'),
            'Needing_value' => trans('Needing value'),
            'Yes' => trans('Yes'),
            'No' => trans('No'),
            'Pieces' => trans('Pieces'),
            'Grams' => trans('Grams'),
            'Liters' => trans('Liters'),
            'confirm_needing_list_explanation' => trans('confirm_needing_list_explanation'),
            'Are_you_sure_you_want_to_confirm_shipping_of_this_needing_list' => trans('Are you sure you want to confirm shipping of this needing list?'),
            'This_will_result_in_losing_all_products_noted_to_needing_list_will_lost' => trans('This will result in losing all products noted to needing list will lost.'),
            'Are_you_sure_you_want_to_delete_needing_list' => trans('Are you sure you want to delete needing list?'),
            'Other_users_will_not_be_able_to_preview_this_needing_list_while_you_edit_it' => trans('Other users will not be able to preview this needing list while you edit it.'),
            'Are_you_sure_you_want_to_edit_needing_list' => trans('Are you sure you want to edit needing list?'),
        ]);

        return view('admin.needings.view',compact('translations','products','needing'));   
    }

    public function searchView(Request $request){

        $query = $request->input('query');
        $needing_id = $request->input('needing_id');

        if($query == "" || $query == null){
            $products = DB::table('products')
            ->select(
                'products.id as product_id',
                'products.name as name',
                'products.enum as enum',
                'products.packing_size as packing_size',
                'product_needings.quantity as quantity',
                'product_needings.weight as weight',
                'product_needings.liters as liters',
                'product_needings.id as product_needing_id',
                'product_needings.needing_id as needing_id',
            )
            ->join('product_needings', 'product_needings.product_id', '=', 'products.id')
            ->where('product_needings.needing_id',$needing_id)
            ->get();
        } else {
            $products = DB::table('products')
            ->select(
                'products.id as product_id',
                'products.name as name',
                'products.enum as enum',
                'products.packing_size as packing_size',
                'product_needings.quantity as quantity',
                'product_needings.weight as weight',
                'product_needings.liters as liters',
                'product_needings.id as product_needing_id',
                'product_needings.needing_id as needing_id',
            )
            ->join('product_needings', 'product_needings.product_id', '=', 'products.id')
            ->where('product_needings.needing_id',$needing_id)
            ->where('products.name','LIKE','%'.$query.'%')
            ->get();
        } 

        return response($products);
    }

    public function start(){
        $translations = json_encode([
            'Bar' => trans('Bar'),
            'Restaurant' => trans('Restaurant'),
            'Create_needing_list' => trans('Create needing list'),
        ]);
        return view('admin.needings.start',compact('translations'));
    }

    public function startCreate(Request $request){
        $location_id = $this->getLocationID();
        $storage = $request->input('storage');
        $user_id = auth()->user()->id;
    
        $needing = new Needing();
        $needing->storage = $storage;
        $needing->confirmed_status = "not_confirmed";
        $needing->completed = false;
        $needing->user_id = $user_id;
        $needing->location_id = $location_id;
        $needing->save();

        return response($needing);
        //return response('success');
    }

    public function cancel(Request $request){

        $needing_id = $request->input('needing_id');

        $needing = Needing::find($needing_id);

        if($needing != null){
            $needingProducts = ProductNeedings::where('needing_id',$needing->id)->delete();
            $needing->delete();
        }else {
            return response('error');
        }

        return response('success');
    }

    public function app($needing_id){

        $needing = Needing::find($needing_id);
        $location = $this->getCurrentLocation();

        //products response
        $response = $this->getNeedingResponse($needing);
        $products = $response['products'];
        $added_products = $response['added_products'];

        $location = Location::find($needing->location_id);

        $translations = json_encode([
            'Products' => trans('Products'),
            'Added_products' => trans('Added products'),
            'Search_products' => trans('Search products'),
            'Pieces' => trans('Pieces'),
            'Liters' => trans('Liters'),
            'Yes' => trans('Yes'),
            'No' => trans('No'),
            'You_successfully_updated_needing_list' => trans('You successfully updated needing list.'),
            'You_successfully_added_products_value_to_needing_list_You_can_update_it_under_needing_list_tab' => trans('You successfully added products value to needing list. You can update it under needing list tab.'),
            'You_successfully_saved_needing_list' => trans('You successfully saved needing list'),
            'Save_Needing_list' => trans('Save Needing list'),
            'Grams' => trans('Grams'),
            'Kilograms' => trans('Kilograms'),
            'Needing_list' => trans('Needing list'),

            'Error_occured' => trans('Error occured'),
            'You_successfully_canceled_needing' => trans('You successfully canceled needing'),
            
            'This_will_result_deleting_needing_list_and_all_data_inside_it' => trans('This will result deleting needing list and all data inside it.'),
            'Are_you_sure_you_want_to_cancel_creation_of_needing_list' => trans('Are you sure you want to cancel creation of needing list'),
        ]);

        return view('admin.needings.app',compact('needing','location','products','added_products','translations'));
    }

    public function getNeedingResponse($needing){
        
        $needing_id = $needing->id;
        $storage = $needing->storage;

        //Products
        $products = DB::table('products')
        ->select(
            'products.id as id',
            'products.name as name',
            'products.enum as enum',
            'products.weightable as weightable',
            'products.packing_weight as packing_weight',
            'products.packing_size as packing_size',
            'products.deleted_at as deleted_at',
            'products.storage as storage',
            'categories.drink_or_food as drink_or_food',
            DB::raw('MAX(product_needings.weight) as needing_weight'),
            DB::raw('MAX(product_needings.quantity) as needing_quantity'),
            DB::raw('MAX(product_needings.liters) as needing_liters'),
            DB::raw('(CASE WHEN MAX(product_needings.weight) IS NULL AND MAX(product_needings.quantity) IS NULL THEN 0 ELSE 1 END) as has_null_values')
        )
        ->join('locations', 'locations.id', '=', 'products.location_id')
        ->join('categories', 'categories.id', '=', 'products.category_id')

        ->leftJoin('product_needings', function ($join) use ($needing_id) {
            $join->on('products.id', '=', 'product_needings.product_id')
                ->where('product_needings.needing_id', $needing_id);
        })
        //inputed data 
        ->whereNull('product_needings.quantity')
        ->whereNull('product_needings.weight')
        ->whereNull('product_needings.liters')
        ->where('locations.id', $this->getLocationID())
        ->where('products.storage',$storage)
        ->whereNull('products.deleted_at')
        ->groupBy(
            'products.id', 
            'products.name', 
            'products.enum', 
            'products.weightable', 
            'products.packing_weight', 
            'products.packing_size', 
            'products.deleted_at', 
            'products.storage', 
            'categories.drink_or_food',
        )
        ->get();


        //ADDED PRODUCTS
        $added_products = DB::table('product_needings')
            ->select(
                'product_needings.product_id as product_id',
                DB::raw('MAX(product_needings.id) as product_needing_id'),
                'products.name as name',
                'products.enum as enum',
                'products.weightable as weightable',
                'products.packing_weight as packing_weight',
                'products.packing_size as packing_size',
                'products.storage as storage',
                DB::raw('SUM(product_needings.weight) as weight'),
                DB::raw('SUM(product_needings.quantity) as quantity'),
                DB::raw('SUM(product_needings.liters) as liters')
            )
            ->join('products', 'products.id', '=', 'product_needings.product_id')
            ->where('product_needings.needing_id', $needing_id)
            ->whereNull('products.deleted_at')
            ->groupBy('product_needings.product_id', 'products.name', 'products.enum', 'products.weightable', 'products.packing_weight','products.packing_size', 'products.storage','products.deleted_at')
            ->get();

        //dd($added_products);
 
        $response = [
            'products' => $products,
            'added_products' => $added_products,
        ];

        return $response;
    }

    public function getAppSearchResponse($needing_id,$storage,$search_query){

        $excluded_ids = ProductNeedings::where('needing_id', $needing_id)
        ->where(function($query) {
            $query->whereNotNull('weight')
                  ->orWhereNotNull('quantity')
                  ->orWhereNotNull('liters');
        })
        ->pluck('product_id')
        ->toArray();


        //Products
        $products = DB::table('products')
        ->select(
            'products.id as id',
            'products.name as name',
            'products.enum as enum',
            'products.weightable as weightable',
            'products.packing_weight as packing_weight',
            'products.packing_size as packing_size',
            'products.deleted_at as deleted_at',
            'products.storage as storage',
            'categories.drink_or_food as drink_or_food',
            //DB::raw('MAX(product_needings.weight) as needing_weight'),
            //DB::raw('MAX(product_needings.quantity) as needing_quantity'),
            //DB::raw('MAX(product_needings.liters) as needing_liters'),
            //DB::raw('(CASE WHEN MAX(product_needings.weight) IS NULL AND MAX(product_needings.quantity) IS NULL THEN 0 ELSE 1 END) as has_null_values')
        )
        ->join('locations', 'locations.id', '=', 'products.location_id')
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->whereNotIn('products.id', $excluded_ids)
        ->where('products.name', 'LIKE', '%' . $search_query . '%')
        ->where('locations.id', $this->getLocationID())
        ->where('products.storage', $storage)
        ->whereNull('products.deleted_at')
        ->groupBy(
            'products.id', 
            'products.name', 
            'products.enum', 
            'products.weightable', 
            'products.packing_weight', 
            'products.packing_size', 
            'products.deleted_at', 
            'products.storage', 
            'categories.drink_or_food'
        )
        ->get();


        //ADDED PRODUCTS
        $added_products = DB::table('product_needings')
            ->select(
                'product_needings.product_id as product_id',
                DB::raw('MAX(product_needings.id) as product_needing_id'),
                'products.name as name',
                'products.enum as enum',
                'products.weightable as weightable',
                'products.packing_weight as packing_weight',
                'products.packing_size as packing_size',
                'products.storage as storage',
                DB::raw('SUM(product_needings.weight) as weight'),
                DB::raw('SUM(product_needings.quantity) as quantity'),
                DB::raw('SUM(product_needings.liters) as liters')
            )
            ->join('products', 'products.id', '=', 'product_needings.product_id')
            ->where('product_needings.needing_id', $needing_id)
            ->whereNull('products.deleted_at')
            //search
            ->where('products.name','LIKE','%'.$search_query.'%')
            ->groupBy('product_needings.product_id', 'products.name', 'products.enum', 'products.weightable', 'products.packing_weight','products.packing_size', 'products.storage','products.deleted_at')
            ->get();
        
        $response = [
            'products' => $products,
            'added_products' => $added_products,
        ];

        return $response;
    }

    public function appSearch(Request $request){
        
        $needing_id = $request->input('needing_id');
        $storage = $request->input('storage');
        $search_query = $request->input('query');

        $response = $this->getAppSearchResponse($needing_id,$storage,$search_query);
        $products = $response['products'];
        $added_products = $response['added_products'];

        $response = [
            'products' => $products,
            'added_products' => $added_products,
        ];

        return $response;
    }

    public function addValue(Request $request){
        
        $query = $request->input('query');
        $needing_id = $request->input('needing_id');
        $needing_enum = $request->input('needing_enum');
        $value = $request->input('value');
        $product_id = $request->input('product_id');
        $needing = Needing::find($needing_id);

        $productNeedings = new ProductNeedings();
        $productNeedings->needing_id = $needing_id;
        $productNeedings->product_id = $product_id;
        if($needing_enum == "g"){
            $productNeedings->weight = $value;
        }
        if($needing_enum == "l"){
            $productNeedings->liters = $value;
        }
        if($needing_enum == "pcs"){
            $productNeedings->quantity = $value;
        }
        $productNeedings->save();


        //products response
        //$response = $this->getAppSearchResponse($needing_id,$needing->storage,$query);
        
        if($query == null || $query == ""){
            $response = $this->getNeedingResponse($needing);
        } else {
            $response = $this->getAppSearchResponse($needing_id,$needing->storage,$query);
        }
        

        return response()->json([
            'products' => $response['products'],
            'added_products' => $response['added_products']
        ]);

    }

    public function addExtraValue(Request $request){
        
        //get data
        $product_needing_id = $request->input('product_needing_id');
        $add_or_remove = $request->input('add_or_remove');
        $query = $request->input('query');
        $needing_enum = $request->input('needing_enum');
        $value = $request->input('value');

        $needing_id = $request->input('needing_id');
        $needing = Needing::find($needing_id);

        //find row
        $product_needing = ProductNeedings::find($product_needing_id);

        //check add or remove 
        $new_value = $value;
        if($add_or_remove == "remove"){
            $new_value = (float)$new_value * -1;
        }

        //PIECES
        if($needing_enum == 'pcs'){
            //calculate
            $temp = $product_needing->quantity + $new_value;
            //set null if there if value is 0 
            if($temp <= 0){
                $product_needing->quantity = null;
            } else {
                $product_needing->quantity = $temp;
            }
        }

        //LITERS
        if($needing_enum == 'l'){
            //calculate
            $temp = $product_needing->liters + $new_value;
            //set null if there if value is 0 
            if($temp <= 0){
                $product_needing->liters = null;
            } else {
                $product_needing->liters = $temp;
            }
        }

        //GRAMS
        if($needing_enum == 'g'){
            //calculate
            $temp = $product_needing->weight + $new_value;
            //set null if there if value is 0 
            if($temp <= 0){
                $product_needing->weight = null;
            } else {
                $product_needing->weight = $temp;
            }
        }
        
        $product_needing->save();


        //cleanup. with NULL.
        $product_needing_cleanup = ProductNeedings::where('needing_id',$needing_id)
                                ->whereNull('quantity')
                                ->whereNull('liters')
                                ->whereNull('weight')
                                ->delete();

        //products response
        if($query == null){
            $response = $this->getNeedingResponse($needing);
        } else {
            $response = $this->getAppSearchResponse($needing,$needing->storage,$query);
        }

        return response()->json([
            'products' => $response['products'],
            'added_products' => $response['added_products']
        ]);  
    }

    public function complete(Request $request){

        
        $needing = Needing::find($request->input('needing_id'));
        $needing->completed = true;
        $needing->updated_end_time = Carbon::now('Europe/Paris')->toDateTimeString();
        $needing->save();


        if ($request->has('from_blade')){
            $fromBladeValue = $request->input('from_blade');
            
            if($fromBladeValue == true){
                return redirect()->route('dashboard');
            }
        }
        
        return response('success');
    }

    //index options 
    public function confirm($needing_id){

        $needing = Needing::find($needing_id);
        $needing->confirmed_status = "in_progress";
        $needing->save();

        $link = route('delivery.create') . "?needing_id=" . $needing_id . "&storage=" . $needing->storage;
        
        return redirect($link);
    }

    public function unfinished($needing_id){
        $needing = Needing::find($needing_id);
        $location = Location::find($needing->location_id);
        return view('admin.needings.unfinished',compact('needing','location'));
    }
    
}
