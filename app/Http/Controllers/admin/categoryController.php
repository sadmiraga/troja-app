<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Drink;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Queue\Failed\PrunableFailedJobProvider;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function index(){

        $location = $this->getCurrentLocation();

        $categories = Category::where('location_id',$location->id)
                    ->whereNull('deleted_at')
                    ->orderBy('position','asc')
                    ->get();

        $translations = json_encode([
            'Delete' => trans('Delete'),
            'Edit' => trans('Edit'),
            'Yes' => trans('Yes'),
            'No' => trans('No'),
            'Confirm' => trans('Confirm'),
            'Search_categories' => trans('Search categories'),
            'Are_you_sure_you_want_to_delete_this_category' => trans('Are you sure you want to delete this category?'),
            'This_will_result_deleting' => trans('This will result deleting'),
            'categories_in_different_locations' => trans('categories in different locations'),
            'Delete_from_locations' => trans('Delete from: (locations)'),
            'Choose_locations_to_delete_category_from' => trans('Choose locations to delete category from'),
            'You_successfully_deleted_category' => trans('You successfully deleted category.'),
        ]);

        return view('admin.categories.index',compact('categories','translations'));
    }

    public function create(){

        $translations = json_encode([
            'Create_category' => trans('Create category'),
            'Enter_category_name' => trans('Enter category name'),
            'Food_or_drink' => trans('Food or drink ?'),
            'food' => trans('food'),
            'drink' => trans('drink'),
            'Yes' => trans('Yes'),
            'No' => trans('No'),
            'You_already_have_category_with_that_name_in_selected_location' => trans('You already have category with that name in selected location.'),
            'Choose_location' => trans('Choose location'),
            'All_locations' => trans('All locations'),
            'Choose_category_type' => trans('Choose category type'),
            'Choose_locations' => trans('Choose locations'),
            'You_sucessfully_created_new_category' => trans('You sucessfully created new category'),
            'You_have_unsaved_changes_are_you_sure_you_want_to_exit' => trans('You have unsaved changes are you sure you want to exit?'),
        ]);

        return view('admin.categories.create',compact('translations'));
    }

    public function edit($category_id){
        $category = Category::find($category_id);
        $category_count = Category::where('categoryName', $category->categoryName)->count();

        $locations = DB::table('categories')
                ->select(
                    'locations.id as id',
                    'locations.name as name',
                )
                ->join('locations', 'locations.id', '=', 'categories.location_id')
                ->where('categories.categoryName',$category->categoryName)
                ->whereNull('categories.deleted_at')
                ->get();

        $translations = json_encode([
            'Edit_on_all_locations' => trans('Edit on all locations'),
            'Save' => trans('Save'),
            'food' => trans('food'),
            'drink' => trans('drink'),
            'Choose_locations' => trans('Choose locations'),
            'Name' => trans('Name'),
            'Type' => trans('Type'),
            'Enter_category_name' => trans('Enter category name'),
            'Update_on_locations' => trans('Update on locations:'),
            'Food_or_drink' => trans('Food or drink ?'),

            'Choose_category_type' => trans('Choose category type'),
            'You_cant_change_category_type_just_for_one_category_without_changing_name' => trans('You cant change category type just for one category, without changing name'),

        ]);

        return view('admin.categories.edit',compact('category','category_count','translations','locations'));
    }

    public function delete($category_id){


        $category = Category::find($category_id);
        $category_count = Category::where('categoryName', $category->categoryName)->count();

        if($category_count > 1){
            //delete all locations 
            $categories = Category::where('categoryName', $category->categoryName)->get();
            
            foreach($categories as $category){
                $category->delete();
            }

        } else {
            //delete just one
            $category->delete();
        }
        return redirect()->route('category.index');
    }

    public function deleteMultiple(Request $request){
        $selected_locations = $request->input('selected_locations');
        $category_id = $request->input('category_id');
        
        $category = Category::find($category_id);

        $categories = Category::where('categoryName',$category->categoryName)
                    ->whereIn('location_id',$selected_locations)
                    ->delete();
        return response('success');
    }
    

    public function store(Request $request){

        $new_category_name = $request->name;

        $drink_or_food = $request->input('drink_or_food');
        $selected_locations = $request->input('selected_locations');
        $icon = $request->input('icon');


        $category_count = Category::where('categoryName',$new_category_name)->whereIn('location_id',$selected_locations)->count();

        if($category_count > 0){
            return response('duplicate');
        }

        foreach($selected_locations as $location_id){

            $category = new Category();
            $category->categoryName = $request->input('name');
            $category->drink_or_food = $drink_or_food;
            $category->location_id = $location_id;
            $category->icon = $icon;
            $category->save();
        }
        return response('success');
    }

    public function update(Request $request){

        //dd($request->all());
        //new data
        $name = $request->input('name');
        $category_id = $request->input('category_id');
        $drink_or_food = $request->input('drink_or_food');

        $category = Category::find($request->category_id);
        $categories = Category::where('categoryName',$category->categoryName)->get();
        
        //selected locations
        $selected_locations = $request->input('selected_locations');
        
        //dd($selected_locations);
        //slaba praksa. REFACTOR THIS.
        foreach($categories as $category){
            foreach($selected_locations as $location){
            
                if($category->location_id == $location){
                    $this->updateCategory($category->id,$name,$drink_or_food);
                }
            }
        }
        return response('success');
    }

    public function updateCategory($category_id,$name,$drink_or_food){
        $category = Category::find($category_id);
        $category->categoryName = $name;
        $category->drink_or_food = $drink_or_food;
        $category->save();
        return 'true';
    }

    public function search(Request $request){
        $query = $request->input('query');

        $location = $this->getCurrentLocation();

        if($query == "" || $query == null){
            $categories = Category::orderBy('created_at','desc')
                        ->where('location_id',$location->id)
                        ->whereNull('deleted_at')
                        ->get();
        } else {
            $categories = Category::where('categoryName','LIKE','%'.$query.'%')
                            ->where('location_id',$location->id)
                            ->whereNull('deleted_at')
                            ->orderBy('created_at','desc')
                            ->get();
        }
        return response($categories);

    }


    public function getCount(Request $request){
        $category = Category::find($request->input('category_id'));
        $categoryName = $category->categoryName;
        // Count categories with the same name
        $count = Category::where('categoryName', $categoryName)->count();
        return response($count);
    }
    
    public function getLocations(Request $request){

        $category = Category::find($request->category_id);
        //$categories = Category::where('categoryName',$category->categoryName)->get();

        $locations = DB::table('categories')
                ->select(
                    'locations.id as id',
                    'locations.name as name',
                )
                ->join('locations', 'locations.id', '=', 'categories.location_id')
                ->where('categories.categoryName',$category->categoryName)
                ->whereNull('categories.deleted_at')
                ->get();
        

        return response(json_encode($locations));

    }
}
