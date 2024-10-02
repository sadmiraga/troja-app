<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use App\Models\{Allergen, Category, Food, Drink, DrinkAllergen, FoodAllergen, MenuItem, MenuItemAllergen, Settings};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MenuController extends Controller
{
    public function tedenska()
    {
        return redirect('/meni?page=3');
    }

    public function index()
    {


        $drink_categories = Category::where('drink_or_food', 'drink')->orderBy('position', 'desc')->get();
        $food_categories = Category::where('drink_or_food', 'food')->orderBy('position', 'desc')->get();

        //$menu_items = MenuItem::all();

        //link allergens to MENU ITEMS
        $menu_items = MenuItem::where('drink_or_food', '!=', null)
        ->orderBy('created_at', 'asc')
        ->get();


        //CRAFT WEEKLY OFFER
        $currentDate = Carbon::now();

        $startOfWeek = $currentDate->copy()->startOfWeek();
        $endOfWeek = $startOfWeek->copy()->addDays(6);

        //weekly offer.
        /*
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
            });
        */

        $allergens = Allergen::all();

        $settings = Settings::first();


        //dd($menu_items[4]);

        //return view('public.menu', compact('drink_categories', 'food_categories', 'food', 'drinks', 'default_food', 'default_drinks','allergens'));
        return view('public.menu', compact('menu_items', 'drink_categories', 'food_categories', 'allergens', 'settings'));
    }

    public function getFood($category_id)
    {

        // link allergens to FOOD
        $food = Food::where('weekly_offer', false)->where('category_id', $category_id)->get()->map(function ($food) {
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
        });

        return response($food);
    }

    public function getDrinks($category_id)
    {

        // link allergens to FOOD
        $drinks = Drink::where('category_id', $category_id)->get()->map(function ($drinks) {
            $allergens_value = "";

            $food_allergens = DrinkAllergen::where('drink_id', $drinks->id)->get();

            foreach ($food_allergens as $food_allergen) {
                $allergen = Allergen::find($food_allergen->allergen_id);
                $allergens_value = $allergens_value . $allergen->shortcode . ", ";
            }

            //cut off last , 
            $allergens_value = substr($allergens_value, 0, -2);

            $drinks->allergens = $allergens_value;
            return $drinks;
        });

        return response($drinks);
    }
}
