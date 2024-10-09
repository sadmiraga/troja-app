<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use App\Models\{Allergen, Category, Food, Drink, DrinkAllergen, FoodAllergen, Language, Location, MenuItem, MenuItemAllergen, Settings};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class MenuController extends Controller
{
    public function tedenska()
    {
        return redirect('/meni?page=3');
    }

    public function index()
    {

        $locale = strtolower(session('locale'));

        if($locale == null){
            app()->setLocale(strtolower( 'si'));
            session()->put('locale', 'si');
        }

        $language = Language::where('shortcode',$locale)->first();
        
        if($language == null){
            $translated = false;
        } else{

            if($language->main_language == true){
                $translated = false;
            } else {
                $translated = true;
            }

        }
        

        $drink_categories = Category::where('drink_or_food', 'drink')->orderBy('position', 'asc')->get();
        $food_categories = Category::where('drink_or_food', 'food')->orderBy('position', 'asc')->get();

        if($translated == false){
            $menu_items = MenuItem::whereNotNull('drink_or_food')
            ->orderBy('position', 'asc')
            ->get();
        } else {

            $menu_items = DB::table('menu_items')
            ->select(
                'menu_items.id as id',
                'menu_item_translations.name as name',
                'menu_item_translations.description as description',
                'menu_items.drink_or_food as drink_or_food',
                'menu_items.allergens as allergens',
                'menu_items.price as price',
                'menu_items.night_price as night_price',
                'menu_items.image as image',
                'menu_items.packing_size as packing_size',
                'menu_items.weight as weight',
                'menu_items.position as position',
                'menu_items.category_id as category_id',
                'menu_items.created_at as created_at',
                'menu_items.updated_at as updated_at',

            )->join('menu_item_translations','menu_item_translations.menu_item_id','menu_items.id')
            ->where('menu_item_translations.language_id',$language->id)
            ->orderBy('menu_items.position')
            ->get();
        }
        

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
        $languages = Language::where('enabled',true)->get();


        $location = Location::first();

        //return view('public.menu', compact('drink_categories', 'food_categories', 'food', 'drinks', 'default_food', 'default_drinks','allergens'));
        return view('public.menu', compact('menu_items', 'drink_categories', 'food_categories', 'allergens', 'settings','languages','location','locale'));
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
