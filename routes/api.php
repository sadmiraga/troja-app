<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get-locations', [App\Http\Controllers\api\ApiController::class, 'getLocations']);
Route::get('/get-categories/{location_id}', [App\Http\Controllers\api\ApiController::class, 'getCategories']);



Route::group(['prefix' => 'translation', 'as' => 'translation.'], function () {
    Route::get('/create-product', [App\Http\Controllers\api\TranslationsController::class, 'createProduct']);
});




//TRANSLATIONS