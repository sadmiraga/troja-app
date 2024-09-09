<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Allergen, Drink, DrinkAllergen, Category, Food};
use Pdf;

class DrinkController extends Controller
{
    public function index()
    {
        $drinks = DB::table('drinks')
            ->select(
                'drinks.id as id',
                'drinks.name as drink_name',
                'drinks.price as price',
                'drinks.packing_size as packing_size',
                'categories.categoryName as category_name'
            )
            ->join('categories', 'drinks.category_id', '=', 'categories.id')
            ->orderBy('drinks.created_at', 'desc')
            ->get();

        $food = DB::table('food')
            ->select(
                'food.id as id',
                'food.name as name',
                'food.price as price',
                'food.weight as weight',
                'categories.categoryName as category_name'
            )
            ->join('categories', 'food.category_id', '=', 'categories.id')
            ->where('food.weekly_offer', false)
            ->orderBy('food.created_at', 'desc')
            ->get();

        return view('admin.drinks.index', compact('drinks', 'food'));
    }

    public function create()
    {
        $categories = Category::where('drink_or_food', 'drink')->get();
        $allergens = Allergen::all();
        return view('admin.drinks.create', compact('categories', 'allergens'));
    }
    public function store(Request $request)
    {
        $drink = new Drink();
        $drink->name = $request->input('name');
        $drink->price = $request->input('price');

        $drink->packing_size = $request->input('packing_size');
        $drink->description = $request->input('description');

        $drink->category_id = $request->input('category_id');
        $drink->save();

        $selected_allergens = $request->input('selected_allergens');

        //middle bracket []

        //add allergens 
        foreach ($selected_allergens as $selected_allergen) {

            if ($selected_allergen['selected'] == true) {

                $drink_allergens = new DrinkAllergen();
                $drink_allergens->drink_id = $drink->id;
                $drink_allergens->allergen_id = $selected_allergen['id'];
                $drink_allergens->save();
            }
        }
        return response('success');
    }
    public function edit($drink_id)
    {
        $categories = Category::where('drink_or_food', 'drink')->get();
        $drink = Drink::find($drink_id);
        $allergens = Allergen::all();
        $db_selected_allergens = DrinkAllergen::where('drink_id', $drink->id)->get();
        return view('admin.drinks.edit', compact('categories', 'drink', 'allergens', 'db_selected_allergens'));
    }

    public function update(Request $request)
    {

        $drink_id = $request->input('drink_id');

        //update drink
        $drink = Drink::find($drink_id);
        $drink->name = $request->input('name');
        $drink->price = $request->input('price');
        $drink->description = $request->input('description');
        $drink->packing_size = $request->input('packing_size');
        $drink->category_id = $request->input('category_id');
        $drink->save();

        //update allergens 
        DrinkAllergen::where('drink_id', $drink->id)->delete();

        $selected_allergens = $request->input('selected_allergens');

        //add allergens 
        foreach ($selected_allergens as $selected_allergen) {

            if ($selected_allergen['selected'] == true) {

                $drink_allergens = new DrinkAllergen();
                $drink_allergens->drink_id = $drink->id;
                $drink_allergens->allergen_id = $selected_allergen['id'];
                $drink_allergens->save();
            }
        }
        return response('success');
    }

    public function search(Request $request)
    {

        $search_query = $request->input('query');

        $query = DB::table('drinks')
            ->select(
                'drinks.id as id',
                'drinks.name as drink_name',
                'drinks.price as price',
                'drinks.packing_size as packing_size',
                'categories.categoryName as category_name'
            )
            ->join('categories', 'drinks.category_id', '=', 'categories.id')
            ->orderBy('drinks.created_at', 'desc');

        if ($search_query != null) {
            $query->where('drinks.name', 'LIKE', $search_query . '%');
        }

        $drinks = $query->get();

        return response($drinks);
    }

    public function allergens()
    {
        return view('admin.drinks.allergens');
    }

    public function delete($drink_id)
    {
        $drink = Drink::find($drink_id);
        $drink->delete();
        return redirect()->back();
    }

    public function export()
    {
        $drinks = DB::table('drinks')
        ->join('categories', 'drinks.category_id', '=', 'categories.id')
        ->select('drinks.*') // specify the columns you need from the 'drinks' table
        ->orderBy('categories.position', 'asc')  // ordering by the position column in descending order
        ->get()
        ->map(function ($drink) {
            // Initialize an empty string to store the allergens
            $allergens_value = "";
    
            // Get the allergens related to this drink
            $drink_allergens = DrinkAllergen::where('drink_id', $drink->id)->get();
    
            // Loop through each allergen and add its shortcode to the string
            foreach ($drink_allergens as $drink_allergen) {
                $allergen = Allergen::find($drink_allergen->allergen_id);
                $allergens_value = $allergens_value . $allergen->shortcode . ", ";
            }
    
            // Remove the trailing comma and space
            $allergens_value = substr($allergens_value, 0, -2);
    
            // Add the allergens string to the drink object
            $drink->allergens = $allergens_value;
            
            return $drink;
        })
        ->groupBy('category_id'); // Group by category id

    
        $allergens = Allergen::all();

        $pdf = PDF::loadView('pdf.drinks', ['drinks' => $drinks,'allergens'=>$allergens])
            ->setOptions(['isRemoteEnabled' => true, 'defaultFont' => 'sans-serif']);
        return $pdf->download('Pijace.pdf');
    }
}
