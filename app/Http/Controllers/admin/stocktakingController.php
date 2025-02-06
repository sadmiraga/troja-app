<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stocktaking;
use App\Models\Location;
use App\Models\User;
use App\Models\ProductStocktaking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Exports\StocktakingExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Imports\compareImport;

class stocktakingController extends Controller
{
    //

    public function index(){

        $stocktakings = DB::table('stocktakings')
            ->select(
                'stocktakings.id as id',
                'stocktakings.start as start',
                'stocktakings.end as end',
                'stocktakings.completed as completed',
                'locations.id as location_id',
                'locations.name as location_name',
                'users.name as user_name',
            )
            ->join('users', 'stocktakings.user_id', '=', 'users.id')
            ->join('locations', 'stocktakings.location_id', '=', 'locations.id')
            ->orderBy('stocktakings.start', 'desc')
            ->get();

        $translations = json_encode([
            'Search_stocktaking' => trans('Search stocktaking'),
            'Employee' => trans('Employee'),
            'Location' => trans('Location'),
            'Date' => trans('Date'),
            'Time' => trans('Time'),
            "You_cant_inspect_this_stocktaking" => trans("You can't inspect this stocktaking."),
        ]);

        //dd($stocktakings);

        return view('admin.stocktaking.index',compact('stocktakings','translations'));
    }

    public function compare($stocktaking_id){

        $stocktaking = Stocktaking::find($stocktaking_id);

        $translations = json_encode([
            'Cash_register' => trans('Cash register'),
            'Compare' => trans('Compare'),
            'Product' => trans('Product'),
            'Difference' => trans('Difference'),
            'Cash_Register_Stock' => trans('Cash Register Stock'),
            'Application_Stock' => trans('Application Stock'),
        ]);

        return view('admin.stocktaking.compare',compact('stocktaking','translations'));
    }

    public function compareExe(Request $request){
    

        $register = $request->input('register');
        $stocktaking_id = $request->input('stocktaking_id');
        $file = $request->file('file');


        //Microgram
        if($register == "microgram"){
            $comparasion = $this->microgram($register,$stocktaking_id,$file);
        }

        if($register == "pos-elektroncek"){
            $comparasion = $this->posElektroncek($register,$stocktaking_id,$file);
            //dd($comparasion);
        }

        return response(json_encode($comparasion));
        
    }


    public function posElektroncek($register, $stocktaking_id, $file)
    {
        $excel_array = Excel::toArray(new compareImport, $file);
        $data = $excel_array[0]; // Vzamemo prvo stran Excel datoteke
        
        $processed_data = [];
        
        // Preskočimo prve 4 vrstice (metadata)
        for ($i = 4; $i < count($data); $i++) {
            $row = $data[$i];
            
            // Preverimo, če ima vrstica vse potrebne podatke
            if (!empty($row[3]) && !empty($row[4])) { // Šifra artikla in naziv
                $processed_data[] = [
                    'sifra_artikla' => $row[3],
                    'artikel' => $row[4], 
                    'enota' => strtolower($row[5]),
                    'zaloga' => floatval($row[6])
                ];
            }
        }
        
        $products = DB::table('product_stocktakings')
            ->select(
                'products.id as id',
                'products.name as name',
                'products.enum as enum',
                'products.code as code',
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
            ->groupBy('products.id','product_stocktakings.product_id', 'products.name', 'products.enum', 'products.code', 'products.weightable', 'products.packing_weight', 'products.storage','products.packing_size')
            ->get();


        $comparison_result = [];

        //dd($processed_data);

        foreach($products as $product) {

            //dd($product->code);
            // Poiščemo ujemajoči izdelek iz Excela po šifri
            $excel_product = null;
            foreach($processed_data as $data) {
                if($data['sifra_artikla'] == $product->code) {
                    $excel_product = $data;
                    break;
                }
            }
            
            if($excel_product) {

                $comparison_result[] = [
                    'id' => $product->id,
                    'code' => $product->code,
                    'name' => $product->name,
                    'enum' => $product->enum,
                    'packing_size' => $product->packing_size,
                    'stocktaking_quantity' => $product->quantity,
                    'stocktaking_weight' => $product->weight,
                    'stocktaking_liters' => $product->liters,
                    'excel_unit' => $excel_product['enota'],
                    'excel_stock' => $excel_product['zaloga'],
                ];
            }
        }

        return $comparison_result;
    }


    public function microgram($register,$stocktaking_id,$file){

        
        //check if file exist
        if ( !$file && !$file->file('file')->isValid()){
            return response()->json(['error' => 'No file or invalid file uploaded'], 400);
        }

        // IMPORTANTE
        $register_list = [];
        // name | enum | zaloga

        $array = Excel::toArray(new compareImport, $file);
        $array = $array[0];

        $temp = 0;
        foreach($array as $item){

            if($temp != 0){

                $parts = explode(' ', $item[1]);
                $unit = $parts[1];

                $number = $parts[0];

                //stock
                if($unit == "kg"){
                    $number = doubleval($number) * 1000;
                }

                //name
                $name = $item[0];
                if (substr($name, -1) == ' ') {
                    // Remove the trailing space
                    $name = rtrim($name);
                }
                
                $register_item = [
                    'name' => $name,
                    'enum' => $unit,
                    'stock' => $number
                ];

                $register_list[] = $register_item;
            }
            $temp ++;
        }


        $products = DB::table('product_stocktakings')
            ->select(
                'products.id as id',
                'products.name as name',
                'products.enum as enum',
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
            ->groupBy('products.id','product_stocktakings.product_id', 'products.name', 'products.enum', 'products.weightable', 'products.packing_weight', 'products.storage','products.packing_size')
            ->get();

        $comparasion = [];

        
        foreach($products as $product){
            
            $stocktaking_value = null;
            
            if($product->enum == "pcs"){
                $stocktaking_value = $product->quantity;
            }
            

            if($product->enum == "l"){
                $stocktaking_value = $this->getLiters($product);
            }

            $register_product = $this->findItemByName($register_list,$product->name);

            if($register_product != null){
                $register_value = $register_product['stock'];
            } else {
                $register_value = null;
            }

            $temp = [
                'id' => $product->id,
                'name' => $product->name,
                'enum' => $product->enum,
                'stocktaking_value' => $stocktaking_value,
                'register_value' => $register_value,
            ];

            $comparasion[] = $temp;
        }

        return $comparasion;
    }

    public function findItemByName($items, $name) {
        
        foreach ($items as $item) {
            //dd($item['name'],$name);
            if ($item['name'] == $name) {
                return $item;
            }
        }
    
        // Return null or an empty array if the item is not found
        return null;
    }
    public function search(Request $request) {
        $query = $request->input('query');
    
        // Check if query matches date format
        if (preg_match('/^(\d{1,2})\.(\d{1,2})\.(\d{4})$/', $query, $matches)) {
            // Reformat the date for SQL
            $searchDate = $matches[3] . '-' . str_pad($matches[2], 2, '0', STR_PAD_LEFT) . '-' . str_pad($matches[1], 2, '0', STR_PAD_LEFT);
    
            $stocktakings = DB::table('stocktakings')
                ->select(
                    'stocktakings.id as id',
                    'stocktakings.start as start',
                    'stocktakings.end as end',
                    'stocktakings.completed as completed',
                    'locations.id as location_id',
                    'locations.name as location_name',
                    'users.name as user_name'
                )
                ->join('users', 'stocktakings.user_id', '=', 'users.id')
                ->join('locations', 'stocktakings.location_id', '=', 'locations.id')
                ->whereDate('stocktakings.start', '=', $searchDate)
                ->orderBy('stocktakings.start', 'desc')
                ->get();
        } else {
            $stocktakings = DB::table('stocktakings')
                ->select(
                    'stocktakings.id as id',
                    'stocktakings.start as start',
                    'stocktakings.end as end',
                    'stocktakings.completed as completed',
                    'locations.id as location_id',
                    'locations.name as location_name',
                    'users.name as user_name'
                )
                ->join('users', 'stocktakings.user_id', '=', 'users.id')
                ->join('locations', 'stocktakings.location_id', '=', 'locations.id')
                ->join('product_stocktakings', 'product_stocktakings.stocktaking_id', '=', 'stocktakings.id')
                ->join('products', 'products.id', '=', 'product_stocktakings.product_id')
                ->where('products.name', 'LIKE', '%' . $query . '%')
                ->groupBy('stocktakings.id', 'stocktakings.start', 'stocktakings.end', 'stocktakings.completed', 'locations.id', 'locations.name', 'users.name')
                ->orderBy('stocktakings.start', 'desc')
                ->get();
        }
    
        return response($stocktakings);
    }

    public function single($stocktaking_id){
        
        $stocktaking = Stocktaking::find($stocktaking_id);

        $products = DB::table('product_stocktakings')
            ->select(
                'products.id as id',
                'products.name as name',
                'products.enum as enum',
                //'products.price as price',
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

        $translations = json_encode([
            'Search_products' => trans('Search products'),
            'Product' => trans('Product'),
            'Pieces' => trans('Pieces'),
            'Weighted' => trans('Weighted'),
            'Stock' => trans('Stock'),
            'Yes' => trans('Yes'),
            'No' => trans('No'),
            'Price' => trans('Price'),
            'Are_you_sure_you_want_to_delete_this_stocktaking' => trans('Are you sure you want to delete this stocktaking'),
        ]);

        $stocktaking_price = $this->getStocktakingPrice($stocktaking->id);

        return view('admin.stocktaking.single',compact('stocktaking','products','translations','stocktaking_price'));
    }

    /* here */
    public function singleSearch(Request $request){

        $stocktaking_id = $request->input('stocktaking_id');
        $query = $request->input('query');

        

        $products = DB::table('product_stocktakings')
        ->select(
            'products.id as id',
            'products.name as name',
            'products.enum as enum',
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
        ->where('products.name','LIKE','%'.$query.'%')
        ->groupBy('products.id','product_stocktakings.product_id', 'products.name', 'products.enum', 'products.weightable', 'products.packing_weight', 'products.storage','products.packing_size')
        ->get();


        return response($products);
    }

    public function export($stocktaking_id){

        $stocktaking = Stocktaking::find($stocktaking_id);
        $location = Location::find($stocktaking->location_id);
        $user = User::find($stocktaking->user_id);

        $filename = trans("Inventura")."-".$location->name."-".$stocktaking->storage."-".$user->name.".xlsx";

        return Excel::download(new StocktakingExport($stocktaking_id), $filename);
    }

    public function exportPDF($stocktaking_id) {
        // Pridobitev invetnure
        $stocktaking = Stocktaking::find($stocktaking_id);
        
        $products = DB::table('product_stocktakings')
        ->select(
            'products.id as id',
            'products.name as name',
            'products.enum as enum',
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
        ->groupBy('products.id','product_stocktakings.product_id', 'products.name', 'products.enum', 'products.weightable', 'products.packing_weight', 'products.storage','products.packing_size')
        ->get();
        
        // Pridobitev povezanih podatkov (lokacija in uporabnik)
        $location = Location::find($stocktaking->location_id);
        $user = User::find($stocktaking->user_id);



        // Priprava imena datoteke (uporabite prevedeno besedo za 'Inventura' in druge podatke)
        $filename = trans("Inventura") . "-" . $location->name . "-" . $stocktaking->storage . "-" . $user->name . ".pdf";

        // Priprava podatkov za view datoteko
        $data = [
            'stocktaking'  => $stocktaking,
            'location'     => $location,
            'user'         => $user,
            'products'     => $products,
        ];

        // Ustvarjanje PDF z uporabo pripravljene view datoteke
        // Prepričajte se, da imate nameščen paket barryvdh/laravel-dompdf in njegovo konfiguracijo
        $pdf = \PDF::loadView('exports.export_pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }

    public function delete($stocktaking_id){

        $stocktaking = Stocktaking::find($stocktaking_id);

        if($stocktaking != null){
            //delete all records
            $stocktakingProducts = ProductStocktaking::where('stocktaking_id',$stocktaking_id)->delete();
            //delete stocktaking
            $stocktaking->delete();
        }

        return redirect()->route('stocktaking.index');
    }


}
