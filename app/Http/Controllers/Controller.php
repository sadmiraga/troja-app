<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\{Location,Delivery, Stocktaking};
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function convertGramsToLiters($productWeight) {
        $density = 930; // Density in kg/m^3. This is an approximation!
    
        $weight = floatval($productWeight);
    
        $liters = ($weight / $density);
    
        return $liters;
    }
    
    public function getLiters($product) {
        $result = 0;
    
        
        if ($product->quantity != null) {
            $chunk = $product->quantity * floatval($product->packing_size);
            $result += $chunk;
        }
    
        if ($product->weight != null) {
            $weightedLiters = $this->convertGramsToLiters($product->weight);
            $result += $weightedLiters;
        }
    
        if ($product->liters != null) {
            $result = floatval($result) + floatval($product->liters);
        }
    
        return floor($result * 10) / 10;
    }
    

    public function getOpenStocktakingID(){
        $user = auth()->user();
        $stocktaking = Stocktaking::where("user_id", $user->id)->where('completed',false)->first();

        if($stocktaking == null){
            $stocktaking_id = 0;
        } else {
            $stocktaking_id = $stocktaking->id;
        }

        return $stocktaking_id;
    }

    public function getOpenDeliveryID(){
        $user = auth()->user();
        
        $delivery = Delivery::where('user_id',$user->id)->where('completed',false)->first();

        if($delivery == null){
            $delivery_id = 0;
        } else {
            $delivery_id = $delivery->id;
        }

        return $delivery_id;
    }

    public function getCurrentLocation(){

        $location_id = session('location');
        $location = Location::find($location_id);
        return $location;
    }

    public function getLocationID(){
        $location_id = session('location');
        $location = Location::find($location_id);
        return $location->id;
    }

    public function getStocktakingPrice($stocktaking_id){

        $stocktaking = Stocktaking::find($stocktaking_id);
        $price = 0;
        
        $products = DB::table('product_stocktakings')
            ->select(
                'products.id as id',
                'products.name as name',
                'products.enum as enum',
                'products.price as price',
                'products.weightable as weightable',
                'products.packing_weight as packing_weight',
                'products.packing_size as packing_size',
                'products.storage as storage',
                DB::raw('SUM(product_stocktakings.weight) as weight'),
                DB::raw('SUM(product_stocktakings.quantity) as quantity'),
                DB::raw('SUM(product_stocktakings.liters) as liters')
            )
            ->join('products', 'products.id', '=', 'product_stocktakings.product_id')
            ->where('product_stocktakings.stocktaking_id', $stocktaking_id)
            ->groupBy('products.id','product_stocktakings.product_id', 'products.name', 'products.enum', 'products.weightable', 'products.packing_weight', 'products.storage','products.packing_size','products.price')
            ->get();

        foreach($products as $product){

            //pcs
            if($product->enum == "pcs"){
                $price += $product->quantity * $product->price;
            }

            //liters
            if($product->enum == "l"){
                //pcs
                if($product->quantity != null){
                    //dd($product->quantity);
                    $price += $product->quantity * $product->price;
                    //dd($price);
                }
                //resto
                if($product->weight != null){
                    $liters = $this->convertGramsToLiters($product->weight);
                    $ratio = $liters / $product->packing_size;
                    $liters_price = $ratio * $product->price;

                    $price += $liters_price;
                }
            }

            //dd($price);

            //grams
            if($product->enum == "g"){
                //pcs
                if($product->quantity != null){
                    $price += $product->quantity * $product->price;
                }
                //weight
                if($product->weight != null && $product->packing_size != null){
                    $weighted = $product->weight / $product->packing_size;
                    $temp = $weighted * $product->price;
                    $price += $temp;
                }
            } 
            
        }
    

        return $price;
    }

    
}
