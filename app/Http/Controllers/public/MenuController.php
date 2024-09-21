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


        $drink_categories = Category::where('drink_or_food', 'drink')->orderBy('position', 'asc')->get();
        $food_categories = Category::where('drink_or_food', 'food')->orderBy('position', 'asc')->get();

        //$menu_items = MenuItem::all();

        //link allergens to MENU ITEMS
        $menu_items = MenuItem::where('drink_or_food', '!=', null)->get()->map(function ($menu_items) {

            $allergens_value = "";

            $menu_item_allergens = MenuItemAllergen::where('menu_item_id', $menu_items->id)->get(); // check here error

            foreach ($menu_item_allergens as $menu_item_allergen) {

                $allergen = Allergen::find($menu_item_allergen->allergen_id);
                $allergens_value = $allergens_value . $allergen->shortcode . ", ";
            }

            //cut off last , 
            $allergens_value = substr($allergens_value, 0, -2);

            $menu_items->allergens = $allergens_value;
            return $menu_items;
        });
        //dd($menu_items);


        /*
        // link allergens to FOOD
        $food = Food::where('weekly_offer', false)->get()->map(function ($food) {
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

        /*
        //link allergens to DRINK
        $drinks = Drink::where('category_id', '!=', null)->get()->map(function ($drink) {
            $allergens_value = "";

            $drink_allergens = DrinkAllergen::where('drink_id', $drink->id)->get();

            foreach ($drink_allergens as $drink_allergen) {
                $allergen = Allergen::find($drink_allergen->allergen_id);
                $allergens_value = $allergens_value . $allergen->shortcode . ", ";
            }

            //cut off last , 
            $allergens_value = substr($allergens_value, 0, -2);

            $drink->allergens = $allergens_value;
            return $drink;
        });

        

        $default_food = $food->groupBy('category_id');
        $default_drinks = $drinks->groupBy('category_id');

        */


        //CRAFT WEEKLY OFFER
        $currentDate = Carbon::now();

        $startOfWeek = $currentDate->copy()->startOfWeek();
        $endOfWeek = $startOfWeek->copy()->addDays(6);

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


        //dd($menu_items);

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
