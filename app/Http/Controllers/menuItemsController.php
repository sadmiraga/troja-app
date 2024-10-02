<?php

namespace App\Http\Controllers;

use App\Models\MenuItemAllergen;
use Illuminate\Http\Request;
use App\Models\{Category, Allergen, MenuItem};

//use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Image;

class menuItemsController extends Controller
{
    //
    public function index()
    {
        $menu_items = DB::table('menu_items')
        ->select(
            'menu_items.id as id',
            'menu_items.name as name',
            'menu_items.drink_or_food as drink_or_food',
            'menu_items.price as price',
            'menu_items.night_price as night_price',
            'menu_items.image as image',
            'menu_items.description as description',
            'menu_items.packing_size as packing_size',
            'menu_items.category_id as category_id',
            'categories.categoryName as category_name',
        )
        ->join('categories', 'categories.id', '=', 'menu_items.category_id')

        ->orderBy('menu_items.created_at', 'desc')
        ->get();


        //dd($menu_items);
        return view('admin.menu.index',compact('menu_items'));
    }

    public function search(Request $request){

        $search_query = $request->input('query');

        $menu_items = DB::table('menu_items')
        ->select(
            'menu_items.id as id',
            'menu_items.name as name',
            'menu_items.drink_or_food as drink_or_food',
            'menu_items.price as price',
            'menu_items.night_price as night_price',
            'menu_items.image as image',
            'menu_items.description as description',
            'menu_items.packing_size as packing_size',
            'menu_items.category_id as category_id',
            'categories.categoryName as category_name',
        )
        ->join('categories', 'categories.id', '=', 'menu_items.category_id')
        ->where(function($query) use ($search_query) {
            $query->where('menu_items.name', 'LIKE', '%'.$search_query.'%')
                  ->orWhere('categories.categoryName', 'LIKE', '%'.$search_query.'%');
        })
        ->orderBy('menu_items.created_at', 'desc')
        ->get();

        return response($menu_items);
    }

    public function edit($menu_item_id){

        $menu_item = MenuItem::find($menu_item_id);
        $food_categories = Category::where('drink_or_food', "food")->get();
        $drink_categories = Category::where('drink_or_food', "drink")->get();
        $allergens = Allergen::all();


        $db_selected_allergens = MenuItemAllergen::where('menu_item_id', $menu_item->id)->get();

        //dd($db_selected_allergens);

        return view('admin.menu.edit',compact('menu_item','food_categories','drink_categories','allergens','db_selected_allergens'));
    }

    public function delete($menu_item_id){

        $menu_item = MenuItem::find($menu_item_id);

        try {
            $imagePath = public_path('images_dynamic/menu_items/' . $menu_item->image);
            // Check if the file exists before attempting to delete
            if (file_exists($imagePath) && $menu_item->image != null) {
                unlink($imagePath);
            }
        } catch (Exception $e) {
            // You can log the error or handle it silently here
            // Log::error($e->getMessage());
        }
        
        $menu_item->delete();

        return redirect()->route('menu_items.index');
    }


    public function create($type)
    {
        if ($type == "drinks") {
            $type = "drink";
        }

        $food_categories = Category::where('drink_or_food', "food")->get();
        $drink_categories = Category::where('drink_or_food', "drink")->get();

        //$categories = Category::where('drink_or_food', $type)->get();
        $allergens = Allergen::all();
        return view('admin.menu.create', compact('food_categories','drink_categories', 'allergens', 'type'));
    }

    public function update(Request $request){

        
        $night_price = $request->input('night_price');
        $price = $request->input('price');
        $packing_size = $request->input('packing_size');

        $item_id = $request->input('item_id');

        $menu_item = MenuItem::find($item_id);
        $menu_item->name = $request->input('name');
        $menu_item->drink_or_food = $request->input('type');
        $menu_item->description = $request->input('description');
        
        $menu_item->category_id = $request->input('category_id');
        $menu_item->price = $request->input('price');

         //night price
         if ($night_price = ! null && $night_price != "null") {
            $menu_item->night_price = $request->input('night_price');
        }

        //packing size 
        if ($packing_size = ! null && $packing_size != "null") {
            $menu_item->packing_size = doubleval($request->input('packing_size'));
        }

        $image = $request->file('media');
        if ($request->hasFile('media')) {
            
            //delete old image.
            try {
                $imagePath = public_path('images_dynamic/menu_items/' . $menu_item->image);
                // Check if the file exists before attempting to delete
                if (file_exists($imagePath) && $menu_item->image != null) {
                    unlink($imagePath);
                }
            } catch (Exception $e) {
                // Log::error($e->getMessage());
            }

            $imageName = Str::slug($request->input('name') . $image->getClientOriginalName()) . '.webp'; // Change extension to webp

            //upload image & save in DB
            $image->move(public_path('images_dynamic/menu_items'), $imageName);
            $menu_item->image = $imageName;

            //OPTIMIZE image.
            
            /*
            $original_image_path = public_path('images_dynamic/menu_items/' . $imageName);
            $image = Image::make($original_image_path);
            $image->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->encode('webp', 75);
            $image->save($original_image_path);
            */
        }

        $menu_item->save();


        MenuItemAllergen::where('menu_item_id', $menu_item->id)->delete();
        
        $selected_allergens = json_decode($request->input('selected_allergens'), true);

        //add allergens 
        foreach ($selected_allergens as $selected_allergen) {

            if ($selected_allergen['selected'] == true) {
                $menu_item_allergen = new MenuItemAllergen();
                $menu_item_allergen->menu_item_id = $menu_item->id;
                $menu_item_allergen->allergen_id = $selected_allergen['id'];
                $menu_item_allergen->save();
            }
        }

        return response('success');
    }


    public function store(Request $request)
    {

        $night_price = $request->input('night_price');
        $packing_size = $request->input('packing_size');

        $menu_item = new MenuItem();
        $menu_item->name = $request->input('name');

        //description
        $description = $request->input('description');
        if($description == "null"){
            $description = null;
        }
        $menu_item->description = $description;

        $category_id = $request->input('category_id');
        $type = $request->input('type');
        
        //category null.
        if($category_id == "null" && ($type == "food" || $type == "drink")){
            $category_id = null;
        }
        
        if($type == "shisha"){
            $category_id = 0;
        }

        $menu_item->category_id = $category_id;
        $menu_item->drink_or_food = $type;
        $menu_item->price = $request->input('price');

        if($packing_size != null && $packing_size != "null"){
            $menu_item->packing_size =   $packing_size; 
        }

        //night price
        if ($night_price = ! null && $night_price != "null") {
            $menu_item->night_price = $request->input('night_price');
        }
        

        $image = $request->file('media');
        if ($request->hasFile('media')) {
            $imageName = Str::slug($request->input('name') . $image->getClientOriginalName()) . '.webp'; // Change extension to webp

            //upload image & save in DB
            $image->move(public_path('images_dynamic/menu_items'), $imageName);
            $menu_item->image = $imageName;

            //OPTIMIZE image.
            /*
            $original_image_path = public_path('images_dynamic/menu_items/' . $imageName);
            $image = Image::make($original_image_path);
            $image->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->encode('webp', 75);
            $image->save($original_image_path);
            */
        }

        $menu_item->save();

        //Allergens.
        $selected_allergens = json_decode($request->input('selected_allergens'), true);

        //add allergens 
        foreach ($selected_allergens as $selected_allergen) {

            if ($selected_allergen['selected'] == true) {
                $menu_item_allergen = new MenuItemAllergen();
                $menu_item_allergen->menu_item_id = $menu_item->id;
                $menu_item_allergen->allergen_id = $selected_allergen['id'];
                $menu_item_allergen->save();
            }
        }

        return response('success');
    }
}
