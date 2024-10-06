<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\{Language, Settings,Location};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class settingsController extends Controller
{
    //

    public function index(){
        return view('admin.settings.index');
    }


    //  LOCATIONS
    public function locations(){
        $locations = Location::all();
        return view('admin.settings.locations.index',compact('locations'));
    }

    public function createLocation(){
        return view('admin.settings.locations.create');
    }

    public function storeLocation(Request $request){
        $location = new Location();
        $location->name = $request->input('name');
        $location->address = $request->input('address');
        $image = $request->file('image');
        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->input('name') . $image->getClientOriginalName()) .".". $image->getClientOriginalExtension(); // Change extension to webp
            //upload image & save in DB
            $image->move(public_path('images_dynamic/settings/locations'), $imageName);
            $location->image = $imageName;
        }
        $location->save();
        return redirect()->route('settings.locations');
    }

    public function editLocation($location_id){
        $location = Location::find($location_id);
        return view('admin.settings.locations.edit',compact('location'));
    }

    public function updateLocation(Request $request){
        
        $location = Location::find($request->input('location_id'));
        $location->name = $request->input('name');
        $location->address = $request->input('address');

        $image = $request->file('image');
        if ($request->hasFile('image')) {

            try {
                $imagePath = public_path('images_dynamic/settings/locations' . $location->image);
                // Check if the file exists before attempting to delete
                if (file_exists($imagePath) && $location->image != null) {
                    unlink($imagePath);
                }
            } catch (Exception $e) {
                // Log::error($e->getMessage());
            }

            $imageName = Str::slug($request->input('name') . $image->getClientOriginalName()) .".". $image->getClientOriginalExtension(); // Change extension to webp
            //upload image & save in DB
            $image->move(public_path('images_dynamic/settings/locations'), $imageName);
            $location->image = $imageName;
        }

        $location->save();
        return redirect()->route('settings.locations');

    }

    //  LANGUAGES
    public function languages(){
        $languages = Language::all();
        return view('admin.settings.languages.index',compact('languages'));
    }

    public function createLanguage(){
        return view('admin.settings.languages.create');
    }

    public function storeLanguage(Request $request){
        
        $language = new Language();
        $language->name = $request->input('name');
        $language->shortcode = $request->input('shortcode');
        $language->icon = $request->input('icon');
        $language->enabled = true;
        $language->save();

        return redirect()->route('settings.languages');
    }

    public function style(){
        $settings = Settings::first();
        return view('admin.settings.style',compact('settings'));
    }

    public function saveStyle(Request $request){

        $settings = Settings::first();

        //create settings record if it doesnt exist.
        if($settings == null){
            $settings = new Settings();
        }

        $settings->primary_color = $request->input('primary_color');
        $settings->secondary_color = $request->input('secondary_color');
        $settings->tertiary_color = $request->input('tertiary_color');
        $settings->tertiary_color = $request->input('tertiary_color');
        $settings->accent_color = $request->input('accent_color');
        $settings->accent_opacity_color = $request->input('accent_opacity_color');
        $settings->light_color = $request->input('light_color');
        $settings->dark_color = $request->input('dark_color');
        $settings->instagram = $request->input('instagram');
        $settings->facebook = $request->input('facebook');

        $image = $request->file('logo');
        if ($request->hasFile('logo')) {
            $imageName = Str::slug($request->input('name') . $image->getClientOriginalName()) .".". $image->getClientOriginalExtension(); // Change extension to webp
            //upload image & save in DB
            $image->move(public_path('images_dynamic/settings'), $imageName);
            $settings->logo = $imageName;
        }

        $settings->save();
        return redirect()->route('settings.index');
    }


    public function menuSettings(){
        $settings = Settings::first();
        return view('admin.settings.menuSettings',compact('settings'));
    }


    public function toggleExtraCategories(Request $request){

        $value = $request->input('value');

        $settings = Settings::first();
        $settings->extra_categories_enabled = $value;
        $settings->save();
        return response('success');
    }


    public function enableDisableLanguage(Request $request){
        
        $language_id = $request->input('language_id');
        $value = $request->input('value');

        $language = Language::find($language_id);
        $language->enabled = $value;
        $language->save();

        return response('success');
    }
}
