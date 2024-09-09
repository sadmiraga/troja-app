<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\{WeeklyCategory, Food, Allergen, FoodAllergen};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Pdf;


class WeeklyController extends Controller
{
    public function index()
    {
        $food = DB::table('food')
            ->select(
                'food.id as id',
                'food.name as name',
                'food.price as price',
                'food.weight as weight',
                'food.description as description',
                'food.available_date as available_date',
                'weekly_categories.name as category_name',
            )
            ->join('weekly_categories', 'food.weekly_category_id', '=', 'weekly_categories.id')
            ->orderBy('food.available_date', 'desc')
            ->where('weekly_offer', true)
            ->get();

        //dd($food);

        return view('admin.weekly.index', compact('food'));
    }

    public function create()
    {
        $categories = WeeklyCategory::all();
        $allergens = Allergen::all();
        return view('admin.weekly.create', compact('categories', 'allergens'));
    }

    public function edit($food_id)
    {

        $categories = WeeklyCategory::all();
        $allergens = Allergen::all();
        $food = Food::find($food_id);
        $db_selected_allergens = FoodAllergen::where('food_id', $food->id)->get();
        return view('admin.weekly.edit', compact('categories', 'allergens', 'food', 'db_selected_allergens'));
    }

    public function store(Request $request)
    {

        $food = new Food();
        $food->name = $request->input('name');
        $food->price = $request->input('price');
        $food->weight = $request->input('weight');
        $food->description = $request->input('description');

        $food->weekly_offer = true;
        $food->available_date = $request->input('date');
        $food->weekly_category_id = $request->input('weekly_category_id');
        $food->save();

        $selected_allergens = $request->input('selected_allergens');

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

    public function update(Request $request)
    {



        $food_id = $request->input('food_id');
        $food = Food::find($food_id);
        $food->name = $request->input('name');
        $food->price = $request->input('price');
        $food->weight = $request->input('weight');
        $food->description = $request->input('description');
        $food->available_date = $request->input('date');
        $food->weekly_category_id = $request->input('weekly_category_id'); // this
        $food->save();

        FoodAllergen::where('food_id', $food->id)->delete();

        $selected_allergens = $request->input('selected_allergens');

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

    public function export($wich)
    {
        $currentDate = Carbon::now();

        if ($wich === 'next') {
            $currentDate->addWeek();
        }

        $startOfWeek = $currentDate->copy()->startOfWeek();
        $endOfWeek = $startOfWeek->copy()->addDays(6);

        $weekly_offers = DB::table('food')
            ->select(
                'food.id as id',
                'food.name as name',
                'food.price as price',
                'food.weight as weight',
                'food.description as description',
                'food.available_date as available_date',
                'weekly_categories.name as category_name',
                'weekly_categories.icon as category_icon',
                'weekly_categories.icon_absolute_link as category_icon_link',
            )
            ->join('weekly_categories', 'food.weekly_category_id', '=', 'weekly_categories.id')
            ->orderBy('food.available_date', 'asc')
            ->whereBetween('food.available_date', [$startOfWeek->format('Y-m-d'), $endOfWeek->format('Y-m-d')])
            ->where('food.weekly_offer', true)
            ->get()
            ->map(function ($food) {
                $allergens_value = "";
                $food_allergens = FoodAllergen::where('food_id', $food->id)->get();
                foreach ($food_allergens as $food_allergen) {
                    $allergen = Allergen::find($food_allergen->allergen_id);
                    $allergens_value = $allergens_value . $allergen->shortcode . ", ";
                }

                //cut off last ,
                $allergens_value = substr($allergens_value, 0, -2);

                $food->allergens = $allergens_value;
                return $food;
            })
            ->groupBy('available_date'); // Group the results by available_date

        //dd($weekly_offers);

        $daysOfWeek = ['Nedelja', 'Ponedeljek', 'Torek', 'Sreda', 'Cetrtek', 'Petek', 'Sobota'];

        $allergens = Allergen::all();

        $pdf = PDF::loadView('pdf.weekly_offer', ['foods' => $weekly_offers, 'daysOfWeek' => $daysOfWeek, 'startOfWeek' => $startOfWeek, 'endOfWeek' => $endOfWeek, 'allergens' => $allergens])->setOptions(['isRemoteEnabled' => true, 'defaultFont' => 'sans-serif']);

        return $pdf->download('Tedenska ponudba.pdf');
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
                'food.description as description',
                'food.available_date as available_date',
                'weekly_categories.name as category_name',
            )
            ->join('weekly_categories', 'food.weekly_category_id', '=', 'weekly_categories.id')
            ->orderBy('food.available_date', 'desc')
            ->where('weekly_offer', true);

        if ($search_query != null) {
            $query->where('food.name', 'LIKE', $search_query . '%');
        }
        $food = $query->get();
        return response($food);
    }

    public function delete($food_id){
        $food = Food::find($food_id);
        $food->delete();
        return redirect()->back();
    }
}
