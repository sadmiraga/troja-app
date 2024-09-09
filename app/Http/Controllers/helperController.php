<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Category;

class helperController extends Controller
{
    //

    public function getCategories($location_id)
    {

        $location = $this->getCurrentLocation();

        if ($location_id == 0) {
            $categories = DB::table(DB::raw("(SELECT categoryName, COUNT(*) as category_count FROM categories GROUP BY categoryName HAVING COUNT(*) = 5) as subquery"))
                ->join('categories', 'categories.categoryName', '=', 'subquery.categoryName')
                ->whereNull('categories.deleted_at')
                ->select('categories.id', 'categories.categoryName', 'categories.drink_or_food')
                //->where('location_id',$location_id)
                ->get();
            return response(json_encode($categories));
        } else {
            $categories = Category::where('location_id', $location_id)->get();
            return response($categories);
        }
    }
}
