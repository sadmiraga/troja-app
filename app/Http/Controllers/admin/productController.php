<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Location;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class productController extends Controller
{

    public function search(Request $request){

        $search_query = $request->input('query');
        
        $products = DB::table('products')
            ->select(
                'products.id as id',
                'products.name as name',
                'products.price as price',
                'products.description as description',
                'products.enum as enum',
                'products.weightable as weightable',
                'products.packing_weight as packing_weight',
                'products.packing_size as packing_size',
                'products.storage as storage',
                'products.location_id as location_id',
                'products.category_id as category_id',
                'categories.categoryName as category_name',
                DB::raw('(SELECT COUNT(*) FROM products AS p WHERE p.name = products.name) as product_count'),
                DB::raw('CASE WHEN (SELECT COUNT(*) FROM products AS p WHERE p.name = products.name) >= 5 THEN "global" ELSE "local" END as type')
            )
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->whereNull('products.deleted_at')
            ->where('products.location_id', $this->getLocationID())
            ->where(function($query) use ($search_query) {
                $query->where('products.name', 'LIKE', '%'.$search_query.'%')
                      ->orWhere('categories.categoryName', 'LIKE', '%'.$search_query.'%');
            })

            ->orderBy('products.created_at', 'desc')
            ->get();

        return response($products);
    }

    public function getLocations(Request $request){
        
        $product_id = $request->input('product_id');
        $product = Product::find($product_id);

        $locations = DB::table('products')
        ->select(
            'locations.id as id',
            'locations.name as name',
        )
        ->join('locations', 'locations.id', '=', 'products.location_id')
        ->where('products.name',$product->name)
        ->whereNull('products.deleted_at')
        ->get();

        return response(json_encode($locations));
     
    }

    public function index()
    {
        $products = DB::table('products')
            ->select(
                'products.id as id',
                'products.name as name',
                //'products.price as price',
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

        $translations = json_encode([
            'Bar' => trans('Bar'),
            'Edit' => trans('Edit'),
            'Confirm' => trans('Confirm'),
            'Yes' => trans('Yes'),
            'Price' => trans('Price'),
            'No' => trans('No'),
            'Delete' => trans('Delete'),
            'Restaurant' => trans('Restaurant'),
            'Search_products' => trans('Search products'),
            'Locations' => trans('Locations'),
            'products_in_different_locations' => trans('products in different locations.'),
            'This_will_result_deleting'=> trans('This will result deleting'),
            'Are_you_sure_you_want_to_delete_this_product' => trans('Are you sure you want to delete this product'),
            'Delete_from_locations' => trans('Delete from: (locations)'),
        ]);

        //dd($products);
        return view('admin.products.index', compact('products','translations'));
    }

    public function create($storage)
    {
        $translations = json_encode([
            'Create_Product' => trans('Create Product'),
            'Enter_product_name' => trans('Enter product name'),
            'Enter_product_description' => trans('Enter product description'),
            'Choose_location' => trans('Choose location'),
            'Choose_storage' => trans('Choose storage'),
            'Choose_category' => trans('Choose category'),
            'Choose_enum' => trans('Choose enum'),
            'Product_is_weightable' => trans('Product is weightable'),
            'Enter_packing_weight' => trans('Enter packing weight'),
            'Enter_packing_size' => trans('Enter packing size'),
            'Piece' => trans('Piece'),
            'Liter' => trans('Liter'),
            'Gram' => trans('Gram'),
            'All_locations' => trans('All locations'),
            'Bar' => trans('Bar'),
            'Yes' => trans('Yes'),
            'No' => trans('No'),
            'Food_or_drink' => trans('Food or drink ?'),
            'food' => trans('food'),
            'drink' => trans('drink'),
            'Choose_type' => trans('Choose type'),
            'If_product_is_weightable_you_must_enter_product_packing_weight' => trans('If product is weightable you must enter product packing weight.'),
            'You_successfully_created_new_product' => trans('You successfully created new product'),
            'what_is_enum' => trans('what_is_enum'),
            'Restaurant' => trans('Restaurant'),
            'Enter_packing_weight_for_product' => trans('Enter packing weight for product.'),
            'Add_product_to_locations' => trans('Add product to locations:'),
            'You_already_have_product_with_that_name_in_selected_location'=> trans('You already have product with that name in selected location'),
            'You_have_unsaved_changes_are_you_sure_you_want_to_exit' => trans('You have unsaved changes are you sure you want to exit?'),
            'Price' => trans('Price'),
            'Product_product_price' => trans('Product price'),
            'Enter_product_price' => trans('Enter product price'),
        ]);

        return view('admin.products.create', compact('storage', 'translations'));
    }
    public function store(Request $request)
    {

        //dd($request->all());
        
        $new_name = strtolower($request->input('name'));
        

        $category = Category::find($request->input('category_id'));
        $selected_locations = $request->input('selected_locations');

        $product_count = Product::where('name',$new_name)->whereIn('location_id',$selected_locations)->count();
        
        if($product_count > 0){
            return response('duplicate');
        }

        foreach($selected_locations as $location_id){

            $category_localized = Category::where('categoryName',$category->categoryName)
                                ->where('location_id',$location_id)
                                ->first();

            $product = new Product();
            //data
            //$product->food_or_drink = $request->input('type');
            $product->location_id = $location_id;
            $product->category_id = $category_localized->id;
            $product->name = $request->input('name');
            //$product->price = $request->input('price');
            $product->description = $request->input('description');
            $product->enum = $request->input('enum_type');
            $product->weightable = $request->input('weightable');
            $product->packing_weight = $request->input('packing_weight');
            $product->packing_size = $request->input('packing_size');
            $product->storage = $request->input('storage');
            $product->save();
        }
        
        return response('success');

    }

    public function edit($product_id)
    {
        $product = Product::find($product_id);

        $category = Category::find($product->category_id);
        

        $product_count = Product::where('name', $product->name)->count();

        $translations = json_encode([
            'Create_Product' => trans('Create Product'),
            'Enter_product_name' => trans('Enter product name'),
            'Enter_product_description' => trans('Enter product description'),
            'Choose_location' => trans('Choose location'),
            'Choose_storage' => trans('Choose storage'),
            'Choose_category' => trans('Choose category'),
            'Choose_enum' => trans('Choose enum'),
            'Product_is_weightable' => trans('Product is weightable'),
            'Enter_packing_weight' => trans('Enter packing weight'),
            'Enter_packing_size' => trans('Enter packing size'),
            'Piece' => trans('Piece'),
            'Liter' => trans('Liter'),
            'Gram' => trans('Gram'),
            'Yes' => trans('Yes'),
            'You_unlinked_products_from_locations_and_left_the_same_nameThis_is_not_allowed' => trans('You unlinked products from locations and left the same name.This is not allowed.'),
            'No' => trans('No'),
            'All_locations' => trans('All locations'),
            'Bar' => trans('Bar'),
            'Name' => trans('Name'),
            'Description' => trans('Description'),
            'Restaurant' => trans('Restaurant'),
            'Edit_on_all_locations' => trans('Edit on all locations'),
            'Save' => trans('Save'),
            'You_successfully_updated_products' => trans('You successfully updated products'),
            'Update_on_locations' => trans('Update on locations'),
            'You_have_unsaved_changes_are_you_sure_you_want_to_exit' => trans('You have unsaved changes are you sure you want to exit?'),
            'Food_or_drink' => trans('Food or drink ?'),
            'food' => trans('food'),
            'drink' => trans('drink'),
            'Choose_type' => trans('Choose type'),
            'Price' => trans('Price'),
            'Product_product_price' => trans('Product price'),
        ]);

        //dd($product);

        $locations = DB::table('products')
        ->select(
            'locations.id as id',
            'locations.name as name',
        )
        ->join('locations', 'locations.id', '=', 'products.location_id')
        ->where('products.name',$product->name)
        ->whereNull('products.deleted_at')
        ->get();

        return view('admin.products.edit',compact('product','translations','product_count','locations','category'));
    }

    public function delete($product_id){

        $product = Product::find($product_id);
        $product_count = Product::where('name', $product->name)->count();

        //global edit.
        if($product_count > 1){
            $products = Product::where('name',$product->name)->get();
            foreach($products as $product){
                $product->delete();
            }
        } else {
            //single edit 
            $product->delete();
        }
        return redirect()->route('product.index');
    }

    public function deleteMultiple(Request $request){
        
        $selected_locations = $request->input('selected_locations');
        $product_id = $request->input('product_id');

        $product = Product::find($request->input('product_id'));
        
        $products = Product::where('name',$product->name)
                    ->whereIn('location_id',$selected_locations)
                    ->delete();
        return response('success');
    }


    public function update(Request $request)
    {

        //selected locations
        $selected_locations = $request->input('selected_locations');
        $product = Product::find($request->input('product_id'));

        $category = Category::find($request->category_id);
        

        foreach($selected_locations as $location){

            $category_localized = Category::where('categoryName',$category->categoryName)->where('location_id',$location)->first();
    
            $product_update = Product::where('location_id',$location)->where('name',$product->name)->first();

            $product_update->food_or_drink = $request->input('type');
            $product_update->name = $request->input('name');
            $product_update->price = $request->input('price');
            $product_update->description = $request->input('description');
            $product_update->enum = $request->input('enum_type');
            $product_update->weightable = $request->input('weightable');
            $product_update->packing_weight = $request->input('packing_weight');
            $product_update->packing_size = $request->input('packing_size');
            $product_update->storage = $request->input('storage');

            $product_update->category_id = $category_localized->id;
            $product_update->save();

        }

        return response('success');
    }

    public function updateProduct($request,$product_id){

        $product = Product::find($product_id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->enum = $request->input('enum_type');
        $product->weightable = $request->input('weightable');
        $product->packing_weight = $request->input('packing_weight');
        $product->packing_size = $request->input('packing_size');
        $product->storage = $request->input('storage');
        //$product->location_id = $location->id;
        $product->category_id = $request->input('category_id');
        $product->save();
    }
}
