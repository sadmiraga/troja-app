<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\FoodAllergen;
use App\Models\Allergen;

use Illuminate\Support\Facades\DB;

use Pdf;


class FoodController extends Controller
{
    public function index()
    {
        $categories = Category::where('drink_or_food', 'food')->get();
        $food = Food::where('weekly_offer', false)->get();
        return view('admin.food.index');
    }

    public function create()
    {
        $categories = Category::where('drink_or_food', 'food')->get();
        $allergens = Allergen::all();
        return view('admin.food.create', compact('categories', 'allergens'));
    }

    public function store(Request $request)
    {

        $food = new Food();
        $food->name = $request->input('name');
        $food->price = $request->input('price');
        $food->weight = $request->input('weight');
        $food->description = $request->input('description');
        $food->category_id = $request->input('category_id');
        $food->weekly_offer = false;
        $food->available_date = null;
        $food->weekly_category_id = null;
        $food->save();

        $selected_allergens = $request->input('selected_allergens');

        //add allergens 
        foreach ($selected_allergens as $selected_allergen) {

            if ($selected_allergen['selected'] == true) {
                $food_allergen = new FoodAllergen();
                $food_allergen->food_id = $food->id;
                $food_allergen->allergen_id = $selected_allergen['id'];
                $food_allergen->save();
            }
        }

        return response('success');
    }

    public function edit($food_id)
    {
        $categories = Category::where('drink_or_food', 'food')->get();
        $allergens = Allergen::all();
        $food = Food::find($food_id);
        $db_selected_allergens = FoodAllergen::where('food_id', $food->id)->get();
        return view('admin.food.edit', compact('categories', 'allergens', 'food', 'db_selected_allergens'));
    }

    public function update(Request $request)
    {
        $food_id = $request->input('food_id');

        $food = Food::find($food_id);
        $food->name = $request->input('name');
        $food->price = $request->input('price');
        $food->weight = $request->input('weight');
        $food->description = $request->input('description');
        $food->category_id = $request->input('category_id');
        $food->save();

        //update allergens
        FoodAllergen::where('food_id', $food->id)->delete();

        $selected_allergens = $request->input('selected_allergens');

        //add allergens 
        //add allergens 
        foreach ($selected_allergens as $selected_allergen) {
            if ($selected_allergen['selected'] == true) {
                $drink_allergens = new FoodAllergen();
                $drink_allergens->food_id = $food->id;
                $drink_allergens->allergen_id = $selected_allergen['id'];
                $drink_allergens->save();
            }
        }

        return response('success');
    }

    public function delete($food_id)
    {
        $food = Food::find($food_id);
        $food->delete();
        return redirect()->back();
    }


    public function search(Request $request)
    {
        $search_query = $request->input('query');

        $query = DB::table('food')
            ->select(
                'food.id as id',
                'food.name as name',
                'food.price as price',
                'food.weight as weight',
                'categories.categoryName as category_name'
            )
            ->join('categories', 'food.category_id', '=', 'categories.id')
            ->orderBy('food.created_at', 'desc')
            ->where('food.weekly_offer', false);

        if ($search_query != null) {
            $query->where('food.name', 'LIKE', $search_query . '%');
        }
        $food = $query->get();

        return response($food);
    }

    public function export()
    {

        $food = DB::table('food')
            ->join('categories', 'food.category_id', '=', 'categories.id')
            ->select('food.*') // specify the columns you need from the 'food' table
            ->where('weekly_offer', false) // where condition for weekly_offer
            ->orderBy('categories.position', 'asc')  // ordering by the position column in descending order
            ->get()
            ->map(function ($foodItem) {
                // Initialize an empty string to store the allergens
                $allergens_value = "";

                // Get the allergens related to this food item
                $food_allergens = FoodAllergen::where('food_id', $foodItem->id)->get();

                // Loop through each allergen and add its shortcode to the string
                foreach ($food_allergens as $food_allergen) {
                    $allergen = Allergen::find($food_allergen->allergen_id);
                    $allergens_value = $allergens_value . $allergen->shortcode . ", ";
                }

                // Remove the trailing comma and space
                $allergens_value = substr($allergens_value, 0, -2);

                // Add the allergens string to the food object
                $foodItem->allergens = $allergens_value;

                return $foodItem;
            })
            ->groupBy('category_id'); // Group by category id

        $allergens = Allergen::all();


        $pdf = PDF::loadView('pdf.food', ['foods' => $food,'allergens'=>$allergens])->setOptions(['isRemoteEnabled' => true, 'defaultFont' => 'sans-serif']);
        return $pdf->download('Hrana.pdf');
    }
}
