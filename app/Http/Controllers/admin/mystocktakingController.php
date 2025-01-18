<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductStocktaking;
use App\Models\Stocktaking;
use App\Models\Location;
use App\Models\Settings;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class mystocktakingController extends Controller
{
    //

    public function index()
    {
        $stocktakings = Stocktaking::all();

        $stocktakings = DB::table('stocktakings')
            ->select(
                'stocktakings.id as id',
                'stocktakings.start as start',
                'stocktakings.end as end',
                'stocktakings.completed as completed',
                'locations.name as location_name',
            )
            ->join('locations', 'locations.id', '=', 'stocktakings.location_id')
            ->where('stocktakings.user_id', '=', auth()->user()->id)
            ->orderBy('stocktakings.created_at', 'desc')
            ->get();

        $translations = json_encode([
            'Start_new_stocktaking' => trans('Start new stocktaking'),
            'Location' => trans('Location'),
            'Time' => trans('Time'),
            'Yes' => trans('Yes'),
            'No' => trans('No'),
            'Date' => trans('Date'),
            'You_cant_edit_this_stocktaking' => trans("You can't edit this stocktaking"),
            'Are_you_sure_you_want_to_update_this_stocktaking' => trans('Are you sure you want to update this stocktaking?'),
            'Click_here_to_continue_unfinished_stocktaking' => trans('Click here to continue unfinished stocktaking'),
        ]);

        $open_stocktaking_id = $this->getOpenStocktakingID();

        return view('admin.myStocktaking.index', compact('stocktakings', 'translations','open_stocktaking_id'));
    }
    public function create()
    {
        $translations = json_encode([
            'Scale' => trans('Scale'),
            'Paper_scale' => trans('Paper scale'),
            'Kilograms' => trans('Kilograms'),
            'Grams' => trans('Grams'),
            'Bar' => trans('Bar'),
            'Restaurant' => trans('Restaurant'),
            'Start_stocktaking' => trans('Start stocktaking'),
        ]);

        $settings = Settings::first();

        return view('admin.myStocktaking.create',compact('translations','settings'));
    }
    public function store(Request $request)
    {
        //set data
        $current_timestamp =   Carbon::now('Europe/Paris')->toDateTimeString();
        $location_id = $this->getLocationID();
        $unit = $request->input('unit');
        

        $stocktaking = new Stocktaking();
        $stocktaking->start = $current_timestamp;
        $stocktaking->updated = false;
        $stocktaking->method = $request->input('method');
        $stocktaking->storage = $request->input('storage');
        $stocktaking->location_id = $location_id;
        $stocktaking->user_id = auth()->user()->id;

        if ($unit === 0) {
            $stocktaking->unit = null;
        } else {
            $stocktaking->unit = $unit;
        }

        $stocktaking->save();
        return response($stocktaking->id);
    }

    public function appSearch(Request $request){
        
        $stocktaking_id = $request->input('stocktaking_id');
        $stocktaking = Stocktaking::find($stocktaking_id);
        $method = $stocktaking->method;
        $search_query = $request->input('query');

        $response = $this->getSearchAppStocktakingResponse($stocktaking,$stocktaking_id,$method,$search_query);

        return $response;
    }

    public function getStocktakingResponse($stocktaking_id)
    {

        $stocktaking = Stocktaking::find($stocktaking_id);
        $method = $stocktaking->method;

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
                DB::raw('MAX(product_stocktakings.weight) as stocktaking_weight'),
                DB::raw('MAX(product_stocktakings.quantity) as stocktaking_quantity'),
                DB::raw('MAX(product_stocktakings.liters) as stocktaking_liters'),
                DB::raw('(CASE WHEN MAX(product_stocktakings.weight) IS NULL AND MAX(product_stocktakings.quantity) IS NULL THEN 0 ELSE 1 END) as has_null_values')
            )
            ->join('locations', 'locations.id', '=', 'products.location_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->leftJoin('product_stocktakings', function ($join) use ($stocktaking_id) {
                $join->on('products.id', '=', 'product_stocktakings.product_id')
                    ->where('product_stocktakings.stocktaking_id', $stocktaking_id);
            })
            ->where('locations.id', $this->getLocationID())
            ->where('products.storage',$stocktaking->storage)
            ->whereNull('products.deleted_at')
            ->where(function ($query) use($method) {

                if($method == 'scale'){
                    // Weightable products that haven't been weighed
                    $query->where('products.weightable', 1)
                    ->whereNull('product_stocktakings.weight');
                }

                //PAPIRNA SKALA.
                if($method == 'paper'){
                    // Weightable products that haven't been weighed
                    $query->where('products.weightable', 1)
                    ->where('categories.drink_or_food', 'drink')
                    ->whereNull('product_stocktakings.liters');
                }
                    
                //or Drinks that haven't been counted
                $query->orWhere(function ($q) {
                    $q->where('categories.drink_or_food', 'drink')
                    ->whereNull('product_stocktakings.quantity');
                });

                //or FOOD that haven't been counted
                $query->orWhere(function ($q) {
                    $q->where('categories.drink_or_food', 'food')
                    ->where('products.enum','pcs')
                    ->whereNull('product_stocktakings.quantity');
                });
                

                // OR Products measured in grams that haven't been weighed
                $query->orWhere(function ($q) {
                    $q->where('products.enum', 'g')
                    ->whereNull('product_stocktakings.weight');
                });

            })->groupBy(
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
        $added_products = DB::table('product_stocktakings')
            ->select(
                'product_stocktakings.product_id as product_id',
                DB::raw('MAX(product_stocktakings.id) as product_stocktaking_id'),
                'products.name as name',
                'products.enum as enum',
                'products.weightable as weightable',
                'products.packing_weight as packing_weight',
                'products.storage as storage',
                DB::raw('SUM(product_stocktakings.weight) as weight'),
                DB::raw('SUM(product_stocktakings.quantity) as quantity'),
                DB::raw('SUM(product_stocktakings.liters) as liters')
            )
            ->join('products', 'products.id', '=', 'product_stocktakings.product_id')
            ->where('product_stocktakings.stocktaking_id', $stocktaking_id)
            ->whereNull('products.deleted_at')
            ->groupBy('product_stocktakings.product_id', 'products.name', 'products.enum', 'products.weightable', 'products.packing_weight', 'products.storage','products.deleted_at')
            ->get();

        $response = [
            'products' => $products,
            'added_products' => $added_products,
        ];

        return $response;
    }

    public function getSearchAppStocktakingResponse($stocktaking,$stocktaking_id,$method,$search_query){
        $products = DB::table('products')
            ->select(
                'products.id as id',
                'products.name as name',
                'products.enum as enum',
                'products.weightable as weightable',
                'products.packing_weight as packing_weight',
                'products.packing_size as packing_size',
                'products.storage as storage',
                'categories.drink_or_food as drink_or_food',
                DB::raw('MAX(product_stocktakings.weight) as stocktaking_weight'),
                DB::raw('MAX(product_stocktakings.quantity) as stocktaking_quantity'),
                DB::raw('MAX(product_stocktakings.liters) as stocktaking_liters'),
                DB::raw('(CASE WHEN MAX(product_stocktakings.weight) IS NULL AND MAX(product_stocktakings.quantity) IS NULL THEN 0 ELSE 1 END) as has_null_values')
            )
            ->join('locations', 'locations.id', '=', 'products.location_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->leftJoin('product_stocktakings', function ($join) use ($stocktaking_id) {
                $join->on('products.id', '=', 'product_stocktakings.product_id')
                    ->where('product_stocktakings.stocktaking_id', $stocktaking_id);
            })
            ->where('locations.id', $this->getLocationID())
            ->where('products.storage',$stocktaking->storage)
            ->whereNull('products.deleted_at')
            ->where('products.name','LIKE','%'.$search_query.'%')
            ->where(function ($query) use($method) {

                if($method == 'scale'){
                    // Weightable products that haven't been weighed
                    $query->where('products.weightable', 1)
                    ->whereNull('product_stocktakings.weight');
                }

                //PAPIRNA SKALA.
                if($method == 'paper'){
                    // Weightable products that haven't been weighed
                    $query->where('products.weightable', 1)
                    ->where('categories.drink_or_food', 'drink')
                    ->whereNull('product_stocktakings.liters');
                }
                    
                //or Drinks that haven't been counted
                $query->orWhere(function ($q) {
                    $q->where('categories.drink_or_food', 'drink')
                    ->whereNull('product_stocktakings.quantity');
                });

                //or FOOD that haven't been counted
                $query->orWhere(function ($q) {
                    $q->where('categories.drink_or_food', 'food')
                    ->where('products.enum','pcs')
                    ->whereNull('product_stocktakings.quantity');
                });
                

                // OR Products measured in grams that haven't been weighed
                $query->orWhere(function ($q) {
                    $q->where('products.enum', 'g')
                    ->whereNull('product_stocktakings.weight');
                });
            })->groupBy(
                'products.id', 
                'products.name', 
                'products.enum', 
                'products.weightable', 
                'products.packing_weight', 
                'products.deleted_at', 
                'products.packing_size', 
                'products.storage', 
                'categories.drink_or_food'
            )
            ->get();

            //ADDED PRODUCTS 
            $added_products = DB::table('product_stocktakings')
            ->select(
                'product_stocktakings.product_id as product_id',
                DB::raw('MAX(product_stocktakings.id) as product_stocktaking_id'),
                'products.name as name',
                'products.enum as enum',
                'products.weightable as weightable',
                'products.packing_weight as packing_weight',
                'products.storage as storage',
                DB::raw('SUM(product_stocktakings.weight) as weight'),
                DB::raw('SUM(product_stocktakings.quantity) as quantity'),
                DB::raw('SUM(product_stocktakings.liters) as liters')
            )
            ->join('products', 'products.id', '=', 'product_stocktakings.product_id')
            ->where('product_stocktakings.stocktaking_id', $stocktaking_id)
            ->where('products.name','LIKE','%'.$search_query.'%')
            ->groupBy('product_stocktakings.product_id', 'products.name', 'products.enum', 'products.weightable', 'products.packing_weight', 'products.storage','products.deleted_at')
            ->get();
        $response = [
            'products' => $products,
            'added_products' => $added_products,
        ];

        return $response;
    }

    public function cancel(Request $request){
        
        $stocktaking_id = $request->input('stocktaking_id');

        $stocktaking = Stocktaking::find($stocktaking_id);

        if($stocktaking != null){
            //delete all records
            $stocktakingProducts = ProductStocktaking::where('stocktaking_id',$stocktaking_id)->delete();
            //delete stocktaking
            $stocktaking->delete();
        }


        return response('success');
    }

    public function delete($stocktaking_id)
    {
        $stocktaking = Stocktaking::find($stocktaking_id);

        if($stocktaking != null){
            //delete all records
            $stocktakingProducts = ProductStocktaking::where('stocktaking_id',$stocktaking_id)->delete();
            //delete stocktaking
            $stocktaking->delete();
        }

        return redirect('dashboard');
    }
    public function save($stocktaking_id)
    {
        $stocktaking = Stocktaking::find($stocktaking_id);
        $stocktaking->completed = true;

        if($stocktaking->updated == true){
            $stocktaking->update_end = Carbon::now('Europe/Paris')->toDateTimeString();    
        } else {
            $stocktaking->end = Carbon::now('Europe/Paris')->toDateTimeString();
        }
        
        $stocktaking->save();
        return redirect()->route('mystocktaking.index');
    }

    public function update($stocktaking_id)
    {
        $stocktaking = Stocktaking::find($stocktaking_id);

        if($stocktaking != null){
            $current_timestamp =   Carbon::now('Europe/Paris')->toDateTimeString();
            $stocktaking->completed = false;
            $stocktaking->updated = true;
            $stocktaking->update_start = $current_timestamp;
            $stocktaking->save();
            return redirect()->route('mystocktaking.app',$stocktaking->id);
        }
        
        return redirect('no-access');
        
    }

    //APP 
    public function app($stocktaking_id)
    {
        $stocktaking = Stocktaking::find($stocktaking_id);

        //response
        $response = $this->getStocktakingResponse($stocktaking->id);
        $products = $response['products'];
        $added_products = $response['added_products'];

        $location = Location::find($stocktaking->location_id);
        
        $translations = json_encode([
            'Products' => trans('Products'),
            'Added_products' => trans('Added products'),
            'Search_products' => trans('Search products'),
            'Pieces' => trans('Pieces'),
            'Liters' => trans('Liters'),
            'Yes' => trans('Yes'),
            'No' => trans('No'),
            'You_successfully_canceled_stocktaking' => trans('You successfully canceled stocktaking.'),
            'This_will_result_deleting_stocktaking_and_all_data_inside_it' => trans('This will result deleting stocktaking and all data inside it.'),
            'Are_you_sure_you_want_to_cancel_stocktaking' => trans('Are you sure you want to cancel stocktaking?'),
            'Stocktaking_weight' => trans('Stocktaking weight'),
            'Complete_stocktaking' => trans('Complete stocktaking'),

            'Packing_weight_is_greater_than_inputed_weight_That_cant_be_possible' => trans('Packing weight is greater than inputed weight That cant be possible'),
            'added_quantity_success_message' => trans('You successfully added quantity of product to stocktakong You can add more more quantity for this product under added products'),
            'added_weight_success_message' => trans('You successfully added resto for of the product to stocktaking. You can add more under added products'),
            'quantity_success_message' => trans("You successfully added quantity for product to stocktaking"),
            'weight_success_message' => trans("You successfully added resto to stocktaking"),
            'liters_success_message' => trans("You successfully added liters to stocktaking")
        ]);

        return view('admin.myStocktaking.app', compact('stocktaking', 'products', 'added_products','translations','location'));
    }

    //PIECE
    public function addPcs(Request $request)
    {
        //dd($request->all());
        $stocktaking = Stocktaking::find($request->input('stocktaking_id'));
        $product_id = $request->input('product_id');

        $stocktaking_products = ProductStocktaking::where('stocktaking_id', $stocktaking->id)->where('product_id', $product_id)->first();

        if(($stocktaking_products == null)){
            $stocktakingProduct = new ProductStocktaking();
            $stocktakingProduct->stocktaking_id = $stocktaking->id;
            $stocktakingProduct->product_id = $product_id;
            $stocktakingProduct->quantity = $request->pcs;
            $stocktakingProduct->save();
        } else {
            $stocktaking_products->quantity = $request->pcs;
            $stocktaking_products->save();
        }

        if($request->input('query') == null){
            $response = $this->getStocktakingResponse($stocktaking->id);
        } else {
            $response = $this->getSearchAppStocktakingResponse($stocktaking,$stocktaking->id,$stocktaking->method,$request->input('query'));
        }
        
        return response()->json([
            'products' => $response['products'],
            'added_products' => $response['added_products']
        ]);
    }

    public function addExtraPcs(Request $request)
    {

        $stocktaking_product = ProductStocktaking::find($request->input('product_stocktaking_id'));

        $test_value = $stocktaking_product->quantity + $request->pcs;

        if($test_value <= 0){
            $test_value = null;
        }

        $stocktaking_product->quantity = $test_value;
        $stocktaking_product->save();

        $stocktaking_id = $stocktaking_product->stocktaking_id;
        $stocktaking = Stocktaking::find($stocktaking_id);

        $this->cleanAddedProducts($stocktaking_id);

        if($request->input('query') == null){
            $response = $this->getStocktakingResponse($stocktaking->id);
        } else {
            $response = $this->getSearchAppStocktakingResponse($stocktaking,$stocktaking->id,$stocktaking->method,$request->input('query'));
        }

        return response()->json([
            'products' => $response['products'],
            'added_products' => $response['added_products']
        ]);
    }

    //WEIGHT
    public function addWeight(Request $request)
    {
        $product_id = $request->input('product_id');
        $stocktaking_id = $request->input('stocktaking_id');
        $weight = $request->input('weight');
        $stocktaking = Stocktaking::find($stocktaking_id);

        //get packing weight
        $product  = Product::find($product_id);
        $packing_weight = $product->packing_weight;

        //get value of liquid without package 
        $weight = $weight - $packing_weight;

        $stocktaking_products = ProductStocktaking::where('stocktaking_id', $stocktaking_id)->where('product_id', $product_id)->first();


        if ($stocktaking_products == null) {
            $stocktakingProduct = new ProductStocktaking();
            $stocktakingProduct->stocktaking_id = $stocktaking_id;
            $stocktakingProduct->product_id = $request->product_id;
            $stocktakingProduct->weight = $weight;
            $stocktakingProduct->save();
        } else {
            $stocktaking_products->weight = $weight;
            $stocktaking_products->save();
        }

        if($request->input('query') == null){
            $response = $this->getStocktakingResponse($stocktaking->id);
        } else {
            $response = $this->getSearchAppStocktakingResponse($stocktaking,$stocktaking->id,$stocktaking->method,$request->input('query'));
        }
        
        return response()->json([
            'products' => $response['products'],
            'added_products' => $response['added_products']
        ]);
    }
    public function addExtraWeight(Request $request)
    {


        //dd($request->all());
        $weight = $request->input('weight');
        $add_or_remove = $request->input('add_or_remove');

        $product = Product::find($request->product_id);

        //add
        if($add_or_remove == "add"){
            //packing weight
            if ($product->weightable) {
                $packing_weight = $product->packing_weight;
                $weight = $weight - $packing_weight;
            }
        }

        //remove
        /*
        if($add_or_remove == "remove"){
            $weight = (float)$weight * -1;
        } 
        */   
        

        $stocktaking_product = ProductStocktaking::find($request->product_stocktaking_id);
        
        $new_weight = $stocktaking_product->weight + $weight;

        if($new_weight <= 0){
            $new_weight = null;
        }

        $stocktaking_product->weight = $new_weight;
        $stocktaking_product->save();

        $stocktaking = Stocktaking::find($stocktaking_product->stocktaking_id);

        $this->cleanAddedProducts($stocktaking->id);

        if($request->input('query') == null){
            $response = $this->getStocktakingResponse($stocktaking->id);
        } else {
            $response = $this->getSearchAppStocktakingResponse($stocktaking,$stocktaking->id,$stocktaking->method,$request->input('query'));
        }

        return response()->json([
            'products' => $response['products'],
            'added_products' => $response['added_products']
        ]);
    }

    //LITERS 
    public function addLiters(Request $request){

        $product_id = $request->input('product_id');
        $liters = $request->input('liters');
        $stocktaking_id = $request->input('stocktaking_id');


        $stocktaking_products = ProductStocktaking::where('stocktaking_id', $stocktaking_id)->where('product_id', $product_id)->first();

        if($stocktaking_products == null) {
            $stocktakingProduct = new ProductStocktaking();
            $stocktakingProduct->stocktaking_id = $stocktaking_id;
            $stocktakingProduct->product_id = $product_id;
            $stocktakingProduct->liters = $liters;
            $stocktakingProduct->save();
        } else {
            $stocktaking_products->liters = $liters;
            $stocktaking_products->save();
        }

        $stocktaking = Stocktaking::find($stocktaking_id);

        if($request->input('query') == null){
            $response = $this->getStocktakingResponse($stocktaking->id);
        } else {
            $response = $this->getSearchAppStocktakingResponse($stocktaking,$stocktaking->id,$stocktaking->method,$request->input('query'));
        }
        
        return response()->json([
            'products' => $response['products'],
            'added_products' => $response['added_products']
        ]);

    }

    public function addExtraLiters(Request $request){
        
        $liters = $request->input('liters');
        $product_stocktaking_id = $request->input('product_stocktaking_id');
        $stocktaking_id = $request->input('stocktaking_id');

        $stocktaking_product = ProductStocktaking::find($product_stocktaking_id);

        //new value craft.
        $new_value = $stocktaking_product->liters + $liters;

        if($new_value <= 0){
            $new_value = null;
        }

        $stocktaking_product->liters = $new_value;
        $stocktaking_product->save();

        $stocktaking = Stocktaking::find($stocktaking_id);

        $this->cleanAddedProducts($stocktaking->id);

        if($request->input('query') == null){
            $response = $this->getStocktakingResponse($stocktaking->id);
        } else {
            $response = $this->getSearchAppStocktakingResponse($stocktaking,$stocktaking->id,$stocktaking->method,$request->input('query'));
        }
        
        return response()->json([
            'products' => $response['products'],
            'added_products' => $response['added_products']
        ]);

    }

    public function cleanAddedProducts($stocktaking_id){
        $productStocktaking = ProductStocktaking::where('stocktaking_id',$stocktaking_id)
                            ->whereNull('quantity')
                            ->whereNull('weight')
                            ->whereNull('liters')
                            ->delete();
    }

}
