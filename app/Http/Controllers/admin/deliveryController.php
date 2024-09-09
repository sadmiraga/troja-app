<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\DeliveryProduct;
use App\Models\Location;
use App\Models\Product;
use App\Models\Needing;
use App\Models\ProductNeedings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\DeliveryExport;
use App\Imports\deliveryImport;

class deliveryController extends Controller
{
    public function index(){

        $deliveries = DB::table('deliveries')
        ->select(
            'deliveries.id as id',
            'deliveries.created_at as created_at',
            'deliveries.updated_at as updated_at',
            'deliveries.end as end',
            'deliveries.completed as completed',
            'deliveries.storage as storage',
            'deliveries.user_id as user_id',
            'users.name as user_name',
            'locations.name as location_name',
        )
        ->join('locations', 'locations.id', '=', 'deliveries.location_id')
        ->join('users', 'users.id', '=', 'deliveries.user_id')
        ->orderBy('deliveries.created_at', 'desc')
        ->get();

        $translations = json_encode([
            'Employee' => trans('Employee'),
            'Location' => trans('Location'),
            'Date' => trans('Date'),
            'Time' => trans('Time'),
            'Yes' => trans('Yes'),
            'No' => trans('No'),
            'No' => trans('No'),

            'You_successfully_deleted_delivery' => trans('You successfully deleted delivery.'),
            'You_cant_edit_this_delivery' => trans('You cant edit this delivery'),
            'Edit' => trans('Edit'),
            'View' => trans('View'),
            'Delete' => trans('Delete'),
            'Delivery_is_not_completed_yet' => trans('Delivery is not completed yet'),
            'Are_you_sure_you_wanto_to_delete_this_delivery' => trans('Are you sure you wanto to delete this delivery?'),


            "You_cant_edit_or_inspect_this_delivery" => trans("You can't edit or inspect this delivery."),
            "Are_you_sure_you_want_to_update_this_delivery" => trans('Are you sure you want to update this delivery?'),
            'Search_deliveries' => trans('Search deliveries'),
            'Continue_Delivery' => trans('Continue Delivery'),

        ]);

        $open_delivery_id = $this->getOpenDeliveryID();

        return view('admin.deliveries.index',compact('deliveries','translations','open_delivery_id'));
    }

    public function delete(Request $request){

        $delivery = Delivery::find($request->input('delivery_id'));

        if($delivery != null){
            $delivery_products = DeliveryProduct::where('delivery_id',$delivery->id)->delete();
            if($delivery->needing_id != null){
                $needing = Needing::find($delivery->needing_id);
                $needing->confirmed_status = "not_confirmed";
                $needing->save();
            }
            $delivery->delete();
        }

        return response('success');
    }
    public function search(Request $request) {
        $query = $request->input('query');

        //return default query.
        if($query == null){
            $deliveries = DB::table('deliveries')
                ->select(
                    'deliveries.id as id',
                    'deliveries.created_at as created_at',
                    'deliveries.updated_at as updated_at',
                    'deliveries.completed as completed',
                    'deliveries.user_id as user_id',
                    'users.name as user_name',
                    'locations.name as location_name',
                )
                ->join('locations', 'locations.id', '=', 'deliveries.location_id')
                ->join('users', 'users.id', '=', 'deliveries.user_id')
                ->orderBy('deliveries.created_at', 'desc')
                ->get();

            return response($deliveries);
        }
    
        // Check if query matches date format
        if (preg_match('/^(\d{1,2})\.(\d{1,2})\.(\d{4})$/', $query, $matches)) {
            // Reformat the date for SQL
            $searchDate = $matches[3] . '-' . str_pad($matches[2], 2, '0', STR_PAD_LEFT) . '-' . str_pad($matches[1], 2, '0', STR_PAD_LEFT);
            
            $deliveries = DB::table('deliveries')
                ->select(
                    'deliveries.id as id',
                    'deliveries.created_at as created_at',
                    'deliveries.updated_at as updated_at',
                    'deliveries.completed as completed',
                    'deliveries.user_id as user_id',
                    'users.name as user_name',
                    'locations.name as location_name',
                )
                ->join('locations', 'locations.id', '=', 'deliveries.location_id')
                ->join('users', 'users.id', '=', 'deliveries.user_id')
                ->whereDate('deliveries.created_at', '=', $searchDate)
                ->orderBy('deliveries.created_at', 'desc')
                ->get();
        } else {
            $deliveries = DB::table('deliveries')
                ->select(
                    'deliveries.id as id',
                    'deliveries.created_at as created_at',
                    'deliveries.updated_at as updated_at',
                    'deliveries.completed as completed',
                    'deliveries.user_id as user_id',
                    'users.name as user_name',
                    'locations.name as location_name',
                )
                ->join('locations', 'locations.id', '=', 'deliveries.location_id')
                ->join('users', 'users.id', '=', 'deliveries.user_id')
                ->leftJoin('delivery_products', 'delivery_products.delivery_id', '=', 'deliveries.id')
                ->leftJoin('products', 'products.id', '=', 'delivery_products.product_id')
                ->where('products.name', 'LIKE', '%' . $query . '%')
                ->groupBy('deliveries.id', 'deliveries.created_at', 'users.name', 'locations.name','deliveries.updated_at','deliveries.completed','deliveries.user_id')
                ->orderBy('deliveries.created_at', 'desc')
                ->get();
        }
    
        return response($deliveries);
    }

    public function unfinished($delivery_id){
        $delivery = Delivery::find($delivery_id);

        $location = Location::find($delivery->location_id);

        $translations = json_encode([
            'Product' => trans('Product'),
            'Quantity' => trans('Quantity'),
            'Save' => trans('Save'),
            'Delete' => trans('Delete'),
            'Date' => trans('Date'),
            'Time' => trans('Time'),
            'Yes' => trans('Yes'),
            'No' => trans('No'),
            'Storage' => trans('Storage'),
            'Location' => trans('Location'),
            //'Location' => trans('Location'),
            'This_will_result_deleting_delivery_and_all_data_inside_of_it' => trans('This will result deleting delivery and all data inside of it.'),
            'Are_you_sure_you_want_to_delete_unfinsihed_delivery' => trans('Are you sure you want to delete unfinsihed delivery?'),
            'We_recommend_at_least_previewing_data_in_delivery_and_then_completing_it' => trans('We recommend at least previewing data in delivery and then completing it.'),
            'Are_you_sure_you_want_to_save_unfinsihed_deivery' => trans('Are you sure you want to save unfinsihed deivery?'),
            'Continue_delivery' => trans('Continue delivery'),
            'Search_products' => trans('Search products'),
        ]);


        return view('admin.deliveries.unfinished',compact('delivery','location','translations'));
    }

    public function single($delivery_id){

        $delivery = Delivery::find($delivery_id);
    
        $productsInDelivery = DB::table('delivery_products')
        ->where('delivery_id', $delivery->id)
        ->where('quantity',null)
        ->orWhere('weight',null)
        ->pluck('product_id');

        $products = DB::table('delivery_products')
        ->select(
            'delivery_products.quantity as quantity',
            'delivery_products.weight as weight',
            'products.name as product_name',
            'products.id as product_id',
        )
        ->leftJoin('products', 'products.id', '=', 'delivery_products.product_id')
        ->where('delivery_products.delivery_id',$delivery_id)
        ->get();

        $translations = json_encode([
            'Product' => trans('Product'),
            'Quantity' => trans('Quantity'),
            'Search_products' => trans('Search products'),
        ]);

        return view('admin.deliveries.single',compact('delivery','products','translations'));
    }

    public function singleSearch(Request $request){

        $delivery_id = $request->input('delivery_id');
        $query = $request->input('query');


        $productsInDelivery = DB::table('delivery_products')
        ->where('delivery_id', $delivery_id)
        ->where('quantity',null)
        ->orWhere('weight',null)
        ->pluck('product_id');

        $products = DB::table('delivery_products')
        ->select(
            'delivery_products.quantity as quantity',
            'delivery_products.weight as weight',
            'products.name as product_name',
            'products.id as product_id',
        )
        ->leftJoin('products', 'products.id', '=', 'delivery_products.product_id')
        ->where('delivery_products.delivery_id',$delivery_id)
        ->where('products.name','LIKE','%'.$query.'%')
        ->get();

        return response($products);
    }

    public function create(){
        $translations = json_encode([
            'Bar' => trans('Bar'),
            'Storage_for_this_delivery_is' => trans('Storage for this delivery is'),
            'Storage_is_already_choosen_inside_needing_list' => trans('Storage is already choosen inside needing list.'),
            'Needing_list_shipping_confirmation' => trans('Needing list shipping confirmation.'),
            'Restaurant' => trans('Restaurant'),
            'Start_delivery' => trans('Start delivery'),
        ]);
        return view('admin.deliveries.start',compact('translations'));
    }

    public function store(Request $request){

        $current_timestamp = Carbon::now('Europe/Paris')->toDateTimeString();

        $delivery = new Delivery();
        $delivery->start = $current_timestamp;
        $delivery->updated = false;
        $delivery->user_id = auth()->user()->id;
        $delivery->location_id = $this->getLocationID();
        $delivery->storage = $request->input('storage');
        $delivery->needing_id = $request->input('needing_id');

        $delivery->save();
        return response($delivery->id);
    }

    public function app($delivery_id){
    
        $delivery = Delivery::find($delivery_id);


        $response = $this->getDeliveryResponse($delivery->id);

        $products = $response['products'];
        $added_products = $response['added_products'];
        $needings = $response['needings'];
    

        $translations = json_encode([
            'Products' => trans('Products'),
            'Yes' => trans('Yes'),
            'No' => trans('No'),
            'You_successfully_canceled_delivery' => trans('You successfully canceled delivery.'),
            'You_successfully_added_product_data_to_delivery_list_You_can_update_this_under_the_added_products_tab' => trans('You successfully added product data to delivery list. You can update this under the added products tab.'),
            'You_successfully_updated_delivery_list' => trans('You successfully updated delivery list'),
            'Save_delivery' => trans('Save delivery'),
            'No_added_products' => trans('No added products'),
            'Grams' => trans('Grams'),
            'Liters' => trans('Liters'),
            'Pieces' => trans('Pieces'),
            'Needing_products_list' => trans('Needing products list'),
            'All_products' => trans('All products'),
            'Needing_list' => trans('Needing list'),
            'This_will_result_deleting_delivery_and_all_data_inside_it' => trans('This will result deleting delivery and all data inside it'),
            'Are_you_sure_you_want_to_cancel_delivery' => trans('Are you sure you want to cancel delivery'),
            'Added_products' => trans('Added products'),
            'Search_products' => trans('Search products'),
            'Stocktaking_weight' => trans('Stocktaking weight'),
            'Complete_Delivery' => trans('Complete Delivery'),
        ]);
        
        return view('admin.deliveries.app',compact('products','translations','delivery','added_products','needings'));
    }

    public function export($delivery_id){

        $delivery = Delivery::find($delivery_id);
        $location = Location::find($delivery->location_id);

        $word = trans('Delivery');
        $extension = "-"."Lieferung".".xlsx";

        $filename =  $location->name." - ".$delivery->storage.$extension;

        return Excel::download(new DeliveryExport($delivery->id), $filename);
    }

    public function import(){

        return view('admin.deliveries.import');
    }

    public function importExcel(Request $request){

        $date = $request->input('date');
        $time = $request->input('time');

        //check if file exist
        if ( !$request->hasFile('file') && !$request->file('file')->isValid()){
            return response([
                'status' => 'error'
            ]);
        }

        //products model
        $products = DB::table('products')->select(
            'products.id as id',
            'products.name as name',
            'products.price as price',
            'products.enum as enum',
            'products.description as description',
            'products.enum as enum',
            'products.weightable as weightable',
            'products.packing_weight as packing_weight',
            'products.packing_size as packing_size',
            'products.storage as storage',
            'products.location_id as location_id',
            'products.category_id as category_id',
            'categories.categoryName as category_name',
            DB::raw('(SELECT COUNT(*) FROM products AS p WHERE p.name = products.name AND p.deleted_at IS NULL) as product_count'),
            DB::raw('CASE WHEN (SELECT COUNT(*) FROM products AS p WHERE p.name = products.name) >= 5 THEN "global" ELSE "local" END as type')
        )
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->where('products.location_id', $this->getLocationID())
        ->whereNull('products.deleted_at')
        ->orderBy('products.created_at', 'desc')
        ->get();

        //array of values from register DELIVERY
        $register_list = [];
        $register_counter = 0;
        $register_unlinked_list = [];
        $unlinked_counter = 0;
        $array = Excel::toArray(new deliveryImport, $request->file('file'));
        $array = $array[0];
        
        //loop items from excel
        $counter = 0;

        //create linked and linked arrays.
        foreach($array as $item){

            //skip heading
            if($counter != 0){
                
                $name = $item[0];
                $value = $item[1];
                
                $product = $this->findProductByName($products,$name);

                //failed to find product
                if($product == null){
                    
                    $temp = [
                        'name' => $name,
                        'value' => $value,
                    ];
                    $register_unlinked_list[$unlinked_counter] = $temp;
                    $unlinked_counter++;
                }

                //success finding product
                if($product != null){
                    
                    $temp = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'enum' => $product->enum,
                        'packing_size'=>$product->packing_size,
                        'value'=>$value
                    ];

                    $register_list[$register_counter] = $temp;
                    $register_counter++;
                }
                
            }

            $counter ++;
        }
        
        //create new delivery 
        $delivery = new Delivery();
        $delivery->start = $date;
        $delivery->end = $date;
        $delivery->location_id = $this->getLocationID();
        $delivery->storage = "bar";
        $delivery->updated = false;
        $delivery->user_id = auth()->user()->id;
        $delivery->save();

        foreach($register_list as $item){

            $enum = $item['enum'];
            $value = $item['value'];
            
            //create deliver product record.
            $deliveryProduct = new DeliveryProduct();
            $deliveryProduct->delivery_id = $delivery->id;
            $deliveryProduct->product_id = $item['id'];
            //grams
            if($enum == "g"){
                $deliveryProduct->weight = $value;
            }
            //liters
            if($enum == "l"){
                $deliveryProduct->liters = $value;
            }
            //pcs
            if($enum == "pcs"){
                $deliveryProduct->quantity = $value;
            }
            $deliveryProduct->save();
        }

        return response([
            'status' => 'success',
            'linked'=> $register_counter-1,
            'unlinked'=> $unlinked_counter-1,
            'unlinked_products' => $register_unlinked_list,
            'delivery_id' => $delivery->id
        ]);


        //dd("UNLINKED",$register_unlinked_list,"Linked",$register_list);
    }

    public function findProductByName($products, $name) {
        // Use the firstWhere method to find the first product with the matching name
        $product = $products->firstWhere('name', $name);
    
        // If a product is found, return the product, otherwise return null or handle as needed
        return $product;
    }


    //send value
    public function sendValue(Request $request){
        
        //get request Data
        $product_id = $request->input('product_id');
        $value = $request->input('value');
        $enum = $request->input('enum');
        $delivery_id = $request->input('delivery_id');
        $query = $request->input('query');

        //create deliver product record.
        $deliveryProduct = new DeliveryProduct();
        $deliveryProduct->delivery_id = $delivery_id;
        $deliveryProduct->product_id = $product_id;

        //grams
        if($enum == "g"){
            $deliveryProduct->weight = $value;
        }
        //liters
        if($enum == "l"){
            $deliveryProduct->liters = $value;
        }
        //pcs
        if($enum == "pcs"){
            $deliveryProduct->quantity = $value;
        }
        $deliveryProduct->save();

        if($query == null){
            $response = $this->getDeliveryResponse($delivery_id);
        } else {
            $response = $this->getAppSearchResponse($delivery_id,$query);
        }
        
        return response()->json([
            'products' => $response['products'],
            'added_products' => $response['added_products'],
            'needings' => $response['needings']
        ]);
    }

    //send extra value
    public function sendExtraValue(Request $request){
        
        //get data from request
        $product_id = $request->input('product_id');
        $value = $request->input('value');
        $enum = $request->input('enum');
        $delivery_id = $request->input('delivery_id');
        $add_or_remove = $request->input('add_or_remove');
        $delivery_product_id = $request->input('delivery_product_id');
        $query = $request->input('query');

        //find delivert product row
        $productDelivery = DeliveryProduct::find($delivery_product_id);

        //check add or remove 
        $new_value = $value;
        if($add_or_remove == "remove"){
            $new_value = (float)$new_value * -1;
        }

        //pcs
        if($enum == "pcs"){
            $temp = $productDelivery->quantity + $new_value;
            //set null if there if value is 0 
            if($temp <= 0){
                $productDelivery->quantity = null;
            } else {
                $productDelivery->quantity = $temp;
            }
        }

        //LITERS
        if($enum == 'l'){
            //calculate
            $temp = $productDelivery->liters + $new_value;
            //set null if there if value is 0 
            if($temp <= 0){
                $productDelivery->liters = null;
            } else {
                $productDelivery->liters = $temp;
            }
        }

        //GRAMS
        if($enum == 'g'){
            //calculate
            $temp = $productDelivery->weight + $new_value;
            //set null if there if value is 0 
            if($temp <= 0){
                $productDelivery->weight = null;
            } else {
                $productDelivery->weight = $temp;
            }
        }

        $productDelivery->save();

        //cleanup. with NULL.
        $product_deliveries = DeliveryProduct::where('id',$delivery_product_id)
            ->whereNull('quantity')
            ->whereNull('liters')
            ->whereNull('weight')
            ->delete();

        if($query == null){
            $response = $this->getDeliveryResponse($delivery_id);
        } else {
            $response = $this->getAppSearchResponse($delivery_id,$query);
        }

        return response()->json([
            'products' => $response['products'],
            'added_products' => $response['added_products'],
            'needings' => $response['needings']
        ]);

    }

    public function searchApp(Request $request){

        //get data
        $query = $request->input('query');
        $delivery_id = $request->input('delivery_id');

        $response = $this->getAppSearchResponse($delivery_id,$query);

        $products = $response['products'];
        $added_products = $response['added_products'];
        $needings = $response['needings'];

        $response = [
            'products' => $products,
            'added_products' => $added_products,
            'needings' => $needings,
        ];
        
        return $response;
    }
    

    public function complete(Request $request){
        $current_timestamp = Carbon::now('Europe/Paris')->toDateTimeString();

        $delivery = Delivery::find($request->delivery_id);
        $delivery->completed = true;

        //confirm needing list if possible.
        if($delivery->needing_id != null){
            $needing = Needing::find($delivery->needing_id);
            $needing->confirmed_status = "confirmed";
            $needing->save();
        }

        if($delivery->updated == true){
            $delivery->update_end = $current_timestamp;    
        } else {
            $delivery->end = $current_timestamp;
        }
        
        $delivery->save();
        return response('success');
    }    

    public function edit($delivery_id){
        return view('admin.deliveries.edit');
    }

    public function update(Request $request){
        dd($request->all());
    }

    public function editApp($delivery_id){
        $delivery = Delivery::find($delivery_id);
        if($delivery != null){

            $current_timestamp =   Carbon::now('Europe/Paris')->toDateTimeString();

            $delivery->completed = false;
            $delivery->updated = true;
            $delivery->update_start = $current_timestamp;
            $delivery->save();
            return redirect()->route('delivery.app',$delivery->id);
        }
        return redirect('no-access');
    }

    public function getAppSearchResponse($delivery_id,$search_query){
        
        $delivery = Delivery::find($delivery_id);

        //GET NEEDINGS
        $excluded_ids = DeliveryProduct::where('delivery_id', $delivery_id)
        ->where(function($query) {
            $query->whereNotNull('weight')
                  ->orWhereNotNull('quantity')
                  ->orWhereNotNull('liters');
        })
        ->pluck('product_id')
        ->toArray();

        $needings = DB::table('products')
        ->select(
            'products.id as product_id',
            'products.name as name',
            'products.enum as enum',
            'products.packing_size as packing_size',
            'product_needings.quantity as quantity',
            'product_needings.weight as weight',
            'product_needings.liters as liters',
            'product_needings.id as product_needing_id',
        )
        ->join('product_needings', 'product_needings.product_id', '=', 'products.id')
        ->where('product_needings.needing_id',$delivery->needing_id)
        
        ->where('products.name','LIKE','%'.$search_query.'%')
        ->whereNotIn('products.id', $excluded_ids)
        ->get();

        //check products inside delivery
        $productsInDelivery = DB::table('delivery_products')
                    ->join('products', 'products.id', '=', 'delivery_products.product_id')
                    ->where('delivery_products.delivery_id', $delivery_id)
                    ->pluck('products.id')
                    ->toArray();

        //PRODUCTS
        $products = DB::table('products')
                ->select(
                    'products.id as id',
                    'products.name as name',
                    'products.enum as enum',
                    'products.storage as storage',
                    'products.weightable as weightable',
                    'products.storage as storage',
                    'categories.drink_or_food as drink_or_food'
                )->join('locations', 'locations.id', '=', 'products.location_id')
                ->join('categories', 'categories.id', '=', 'products.category_id') 
                ->where('products.name','LIKE','%'.$search_query.'%')
                ->where('products.storage',$delivery->storage)
                ->whereNull('products.deleted_at')
                ->where('locations.id', $this->getLocationID())
                ->whereNotIn('products.id', $productsInDelivery)
                ->get();

        //ADDED PRODUCTS 
        $added_products = DB::table('delivery_products')
                ->select(
                    'delivery_products.quantity as quantity',
                    'delivery_products.weight as weight',
                    'delivery_products.liters as liters',
                    'products.id as product_id',
                    'products.name as name',
                    'products.enum as enum',
                    'products.weightable as weightable',
                    'products.packing_size as packing_size',
                    'products.packing_weight as packing_weight',
                    'products.storage as storage',
                    'delivery_products.id as delivery_product_id'
                )->join('products', 'products.id', '=', 'delivery_products.product_id')
                ->where('delivery_products.delivery_id',$delivery_id)
                ->whereNull('products.deleted_at')
                ->where('products.name','LIKE','%'.$search_query.'%')
                ->get();

        $response = [
            'products' => $products,
            'added_products' => $added_products,
            'needings' => $needings,
        ];

        return $response;
    }

    public function getDeliveryResponse($delivery_id){

        $delivery = Delivery::find($delivery_id);
    
        //GET NEEDINGS
        $excluded_ids = DeliveryProduct::where('delivery_id', $delivery->id)
        ->where(function($query) {
            $query->whereNotNull('weight')
                  ->orWhereNotNull('quantity')
                  ->orWhereNotNull('liters');
        })
        ->pluck('product_id')
        ->toArray();

        $needings = DB::table('products')
        ->select(
            'products.id as product_id',
            'products.name as name',
            'products.enum as enum',
            'products.packing_size as packing_size',
            'product_needings.quantity as quantity',
            'product_needings.weight as weight',
            'product_needings.liters as liters',
            'product_needings.id as product_needing_id',
        )
        ->join('product_needings', 'product_needings.product_id', '=', 'products.id')
        ->where('product_needings.needing_id',$delivery->needing_id)
        ->whereNotIn('products.id', $excluded_ids)
        ->get();

        //GET PRODUCTS 
        $productsInDelivery = DB::table('delivery_products')
        ->join('products', 'products.id', '=', 'delivery_products.product_id')
        ->where('delivery_products.delivery_id', $delivery_id)
        ->pluck('products.id')
        ->toArray();

        //products in needings 
        $products_in_needing = $needings->pluck('product_id')->toArray();

        $products = DB::table('products')
        ->select(
            'products.id as id',
            'products.name as name',
            'products.enum as enum',
            'products.weightable as weightable',
            'products.storage as storage',
            'products.packing_size as packing_size',
            'products.packing_weight as packing_weight',
            'categories.drink_or_food as drink_or_food'
        )->join('locations', 'locations.id', '=', 'products.location_id')
        ->join('categories', 'categories.id', '=', 'products.category_id') 
        ->where('locations.id', $this->getLocationID())
        ->where('products.storage',$delivery->storage)
        ->whereNull('products.deleted_at')
        ->whereNotIn('products.id', $productsInDelivery)
        ->whereNotIn('products.id', $products_in_needing)
        ->get();

        //ADDED PRODUCTS 
        $added_products = DB::table('delivery_products')
        ->select(
            'delivery_products.quantity as quantity',
            'delivery_products.weight as weight',
            'delivery_products.liters as liters',
            'products.id as product_id',
            'products.name as name',
            'products.enum as enum',
            'products.weightable as weightable',
            'products.packing_size as packing_size',
            'products.packing_weight as packing_weight',
            'products.storage as storage',
            'delivery_products.id as delivery_product_id'
        )->join('products', 'products.id', '=', 'delivery_products.product_id')
        ->where('delivery_products.delivery_id',$delivery_id)
        ->where('products.deleted_at')
        ->whereNull('products.deleted_at')
        ->get();

        $reponse = [
            'products' => $products,
            'added_products' => $added_products,
            'needings' => $needings,
        ];

        return $reponse;
    }

}
