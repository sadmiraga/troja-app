<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return redirect()->route('onboarding');
});

Route::get('/rate-us', [App\Http\Controllers\feedbackController::class, 'public'])->name('rate-us');
Route::post('/rate-us/store', [App\Http\Controllers\feedbackController::class, 'store'])->name('rate-us.store');

Route::get('/reviews', [App\Http\Controllers\feedbackController::class, 'reviewList'])->name('reviews');

Route::get('/admin', [App\Http\Controllers\public\rootController::class, 'admin'])->name('admin');

Route::get('/change-lang/{locale}', [App\Http\Controllers\HomeController::class, 'changeLang'])->name('change.language');

//Public localized pages
Route::group(['prefix' => '{locale}', 'where' => ['locale' => '[a-zA-Z]{2}'], 'middleware' => 'localize'], function () {
    Route::get('/meni', [App\Http\Controllers\public\MenuController::class, 'indexLocalized'])->name('meni.localized');
});




Route::group(['middleware' => 'locale'], function () {

    Route::get('/meni', [App\Http\Controllers\public\MenuController::class, 'index'])->name('meni');


    Route::group(['middleware' => 'AdminMiddleware'], function () {

        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        //Settings
        Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {

            Route::get('/', [App\Http\Controllers\admin\settingsController::class, 'index'])->name('index');


            //parent category 
            Route::post('/parent_category/store', [App\Http\Controllers\parentCategoryController::class, 'store'])->name('parent_category.store');

            
            //style
            Route::get('/style', [App\Http\Controllers\admin\settingsController::class, 'style'])->name('style');
            Route::post('/style/save', [App\Http\Controllers\admin\settingsController::class, 'saveStyle'])->name('save.style');

            //locations
            Route::get('/locations', [App\Http\Controllers\admin\settingsController::class, 'locations'])->name('locations');
            Route::get('/locations/create', [App\Http\Controllers\admin\settingsController::class, 'createLocation'])->name('locations.create');
            Route::post('/locations/store', [App\Http\Controllers\admin\settingsController::class, 'storeLocation'])->name('locations.store');
            Route::get('/locations/{location_id}/edit', [App\Http\Controllers\admin\settingsController::class, 'editLocation'])->name('locations.edit');
            Route::post('/locations/update', [App\Http\Controllers\admin\settingsController::class, 'updateLocation'])->name('locations.update');

            //languages
            Route::get('/languages', [App\Http\Controllers\admin\settingsController::class, 'languages'])->name('languages');
            Route::get('/languages/create', [App\Http\Controllers\admin\settingsController::class, 'createLanguage'])->name('languages.create');
            Route::post('/languages/store', [App\Http\Controllers\admin\settingsController::class, 'storeLanguage'])->name('languages.store');
            Route::post('/languages/enable-disable', [App\Http\Controllers\admin\settingsController::class, 'enableDisableLanguage'])->name('languages.enable-disable');

            Route::get('/menu-settings', [App\Http\Controllers\admin\settingsController::class, 'menuSettings'])->name('menu.settings');
            Route::post('/toggle-extra-categories', [App\Http\Controllers\admin\settingsController::class, 'toggleExtraCategories'])->name('togle.extra-categories');
        });

    
        //USERS
        Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
            Route::get('/', [App\Http\Controllers\admin\usersController::class, 'index'])->name('index');
            Route::get('{user_id}/edit/', [App\Http\Controllers\admin\usersController::class, 'edit'])->name('edit');
            Route::post('/update', [App\Http\Controllers\admin\usersController::class, 'update'])->name('update');
    
            Route::post('/search', [App\Http\Controllers\admin\usersController::class, 'search'])->name('search');
    
            Route::get('/delete/{user_id}', [App\Http\Controllers\admin\usersController::class, 'delete'])->name('delete');
    
            Route::get('/invite', [App\Http\Controllers\admin\usersController::class, 'invite'])->name('invite');
            Route::post('/invite/send', [App\Http\Controllers\admin\usersController::class, 'sendInvite'])->name('send.invite');
        });
    
        //PRODUCTS
        Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
            Route::get('/', [App\Http\Controllers\admin\productController::class, 'index'])->name('index');
            Route::get('/create/{storage}', [App\Http\Controllers\admin\productController::class, 'create'])->name('create');
            Route::post('/store', [App\Http\Controllers\admin\productController::class, 'store'])->name('store');
            Route::post('/search', [App\Http\Controllers\admin\productController::class, 'search'])->name('search');
            Route::get('/edit/{product_id}', [App\Http\Controllers\admin\productController::class, 'edit'])->name('edit');
            Route::get('/delete/{product_id}', [App\Http\Controllers\admin\productController::class, 'delete'])->name('delete');
            Route::post('/update', [App\Http\Controllers\admin\productController::class, 'update'])->name('update');
    
            //api routes 
            Route::post('/get-locations', [App\Http\Controllers\admin\productController::class, 'getLocations'])->name('get.locations');
            Route::post('/delete/multiple', [App\Http\Controllers\admin\productController::class, 'deleteMultiple'])->name('api.delete');
        });

        //MENU ITEMS 
        Route::group(['prefix' => 'menu_items', 'as' => 'menu_items.'], function () {
           
            Route::get('/', [App\Http\Controllers\menuItemsController::class, 'index'])->name('index');
            Route::post('/search', [App\Http\Controllers\menuItemsController::class, 'search'])->name('search');
            
            //create
            Route::get('/create/{type}', [App\Http\Controllers\menuItemsController::class, 'create'])->name('create');
            Route::post('/store', [App\Http\Controllers\menuItemsController::class, 'store'])->name('store');

            //edit
            Route::get('/edit/{menu_item_id}', [App\Http\Controllers\menuItemsController::class, 'edit'])->name('edit');
            Route::post('/update', [App\Http\Controllers\menuItemsController::class, 'update'])->name('update');

            //translations
            Route::get('/translations/{menu_item_id}', [App\Http\Controllers\menuItemsController::class, 'translationsMenuItem'])->name('translations');
            Route::post('/translations/save', [App\Http\Controllers\menuItemsController::class, 'saveTranslationsMenuItem'])->name('translations.save');

            //delete
            Route::get('/delete/{menu_item_id}', [App\Http\Controllers\menuItemsController::class, 'delete'])->name('delete');
            
        });
    
    
        //NEEDINGS
        Route::group(['prefix' => 'needing', 'as' => 'needing.'], function (){
    
            Route::get('/', [App\Http\Controllers\admin\needingController::class, 'index'])->name('index');
    
            Route::get('/{needing_id}/view', [App\Http\Controllers\admin\needingController::class, 'view'])->name('view');
            Route::post('/view/search', [App\Http\Controllers\admin\needingController::class, 'searchView'])->name('view.search');
    
            Route::get('/{needing_id}/edit', [App\Http\Controllers\admin\needingController::class, 'edit'])->name('edit');
            Route::get('/{needing_id}/delete', [App\Http\Controllers\admin\needingController::class, 'delete'])->name('delete');
            Route::get('/{needing_id}/confirm', [App\Http\Controllers\admin\needingController::class, 'confirm'])->name('confirm');
            Route::get('/{needing_id}/export', [App\Http\Controllers\admin\needingController::class, 'export'])->name('export');
    
            Route::get('/{needing_id}/unfinished', [App\Http\Controllers\admin\needingController::class, 'unfinished'])->name('unfinished');
            
    
            Route::get('/start', [App\Http\Controllers\admin\needingController::class, 'start'])->name('start');
            Route::post('/start/create', [App\Http\Controllers\admin\needingController::class, 'startCreate'])->name('start.create');
    
            //app
            Route::get('/{needing_id}/app', [App\Http\Controllers\admin\needingController::class, 'app'])->name('app');
            Route::post('/cancel', [App\Http\Controllers\admin\needingController::class, 'cancel'])->name('cancel');
            Route::post('/app/complete', [App\Http\Controllers\admin\needingController::class, 'complete'])->name('complete');
    
            Route::post('/app/search', [App\Http\Controllers\admin\needingController::class, 'appSearch'])->name('app.search');
            Route::post('/app/add-value', [App\Http\Controllers\admin\needingController::class, 'addValue'])->name('app.add.value');
            Route::post('/app/add-extra-value', [App\Http\Controllers\admin\needingController::class, 'addExtraValue'])->name('app.add.extra.value');
        });
    
    
        //MY STOCKTAKING
        Route::group(['prefix' => 'mystocktaking', 'as' => 'mystocktaking.'], function () {
            Route::get('/', [App\Http\Controllers\admin\mystocktakingController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\admin\mystocktakingController::class, 'create'])->name('create');
            Route::get('/{stocktaking_id}/delete', [App\Http\Controllers\admin\mystocktakingController::class, 'delete'])->name('delete');
            Route::get('/{stocktaking_id}/save', [App\Http\Controllers\admin\mystocktakingController::class, 'save'])->name('save');
            Route::post('/store', [App\Http\Controllers\admin\mystocktakingController::class, 'store'])->name('store');
    
            //cancel
            Route::post('/cancel', [App\Http\Controllers\admin\mystocktakingController::class, 'cancel'])->name('cancel');
    
    
    
            // WHEN USER EDITS 
            Route::get('/{stocktaking_id}/update', [App\Http\Controllers\admin\mystocktakingController::class, 'update'])->name('update');
    
            //APP
            Route::get('/{stocktaking_id}/app', [App\Http\Controllers\admin\mystocktakingController::class, 'app'])->name('app');
            Route::post('/app/search', [App\Http\Controllers\admin\mystocktakingController::class, 'appSearch'])->name('app.search');
    
            //pcs
            Route::post('/app/add-pcs', [App\Http\Controllers\admin\mystocktakingController::class, 'addPcs'])->name('app.add.pcs');
            Route::post('/app/add-extra-pcs', [App\Http\Controllers\admin\mystocktakingController::class, 'addExtraPcs'])->name('app.add.extra-pcs');
    
            //weight
            Route::post('/app/add-weight', [App\Http\Controllers\admin\mystocktakingController::class, 'addWeight'])->name('app.add.weight');
            Route::post('/app/add-extra-weight', [App\Http\Controllers\admin\mystocktakingController::class, 'addExtraWeight'])->name('app.add.extra-weight');
    
            //liters
            Route::post('/app/add-liters', [App\Http\Controllers\admin\mystocktakingController::class, 'addLiters'])->name('app.add.liters');
            Route::post('/app/add-extra-liters', [App\Http\Controllers\admin\mystocktakingController::class, 'addExtraLiters'])->name('app.add.extra-liters');
    
        });
    
        //STOCKTAKING HISTORY
        Route::group(['prefix' => 'stocktaking', 'as' => 'stocktaking.'], function () {
    
            Route::get('/', [App\Http\Controllers\admin\stocktakingController::class, 'index'])->name('index');
            Route::post('/search', [App\Http\Controllers\admin\stocktakingController::class, 'search'])->name('search');
    
            Route::get('/{stocktaking_id}/single', [App\Http\Controllers\admin\stocktakingController::class, 'single'])->name('single');
            Route::post('/single/search', [App\Http\Controllers\admin\stocktakingController::class, 'singleSearch'])->name('single.search');

            Route::get('/{stocktaking_id}/single/compare', [App\Http\Controllers\admin\stocktakingController::class, 'compare'])->name('single.compare');
            Route::post('/compare', [App\Http\Controllers\admin\stocktakingController::class, 'compareExe'])->name('single.compare.exe');
     
            Route::get('/delete/{stocktaking_id}', [App\Http\Controllers\admin\stocktakingController::class, 'delete'])->name('delete');
            Route::get('/export/{stocktaking_id}', [App\Http\Controllers\admin\stocktakingController::class, 'export'])->name('export');
            Route::get('/export-pdf/{stocktaking_id}', [App\Http\Controllers\admin\stocktakingController::class, 'exportPDF'])->name('export.pdf');
        }); 
    
        //DELIVERIES
        Route::group(['prefix' => 'delivery', 'as' => 'delivery.'], function () {
    
            Route::get('/', [App\Http\Controllers\admin\deliveryController::class, 'index'])->name('index');
            Route::post('/search', [App\Http\Controllers\admin\deliveryController::class, 'search'])->name('search');
            Route::post('/delete', [App\Http\Controllers\admin\deliveryController::class, 'delete'])->name('delete');

            //single
            Route::get('/{delivery_id}/single', [App\Http\Controllers\admin\deliveryController::class, 'single'])->name('single');
            Route::post('/single/search', [App\Http\Controllers\admin\deliveryController::class, 'singleSearch'])->name('single.search');

            //export 
            Route::get('/{delivery_id}/export', [App\Http\Controllers\admin\deliveryController::class, 'export'])->name('export');
            Route::get('/import', [App\Http\Controllers\admin\deliveryController::class, 'import'])->name('import');
            Route::post('/import-excel', [App\Http\Controllers\admin\deliveryController::class, 'importExcel'])->name('import.excel');


    
            Route::get('/create', [App\Http\Controllers\admin\deliveryController::class, 'create'])->name('create');
            Route::post('/store', [App\Http\Controllers\admin\deliveryController::class, 'store'])->name('store');
            Route::get('/{product_id}/edit', [App\Http\Controllers\admin\deliveryController::class, 'edit'])->name('edit');
            Route::post('/update', [App\Http\Controllers\admin\deliveryController::class, 'update'])->name('update');
            Route::post('/search', [App\Http\Controllers\admin\deliveryController::class, 'search'])->name('search');
    
            //app update
            Route::get('/app/{delivery_id}/edit', [App\Http\Controllers\admin\deliveryController::class, 'editApp'])->name('app.edit');
     
            Route::get('/{delivery_id}/unfinished', [App\Http\Controllers\admin\deliveryController::class, 'unfinished'])->name('unfinished');
    
            //deliveries APP 
            Route::get('/{delivery_id}/app', [App\Http\Controllers\admin\deliveryController::class, 'app'])->name('app');
            Route::post('/app/search', [App\Http\Controllers\admin\deliveryController::class, 'searchApp'])->name('app.search');
    
            //exe
            Route::post('/app/send-value', [App\Http\Controllers\admin\deliveryController::class, 'sendValue'])->name('app.send.value');
            Route::post('/app/send-extra-value', [App\Http\Controllers\admin\deliveryController::class, 'sendExtraValue'])->name('app.send.extra.value');
            //old exe
            Route::post('/app/add-pcs', [App\Http\Controllers\admin\deliveryController::class, 'addPcs'])->name('app.add.pcs');
            Route::post('/app/add-weight', [App\Http\Controllers\admin\deliveryController::class, 'addWeight'])->name('app.add.weight');
                //extra
            Route::post('/app/add-extra-pcs', [App\Http\Controllers\admin\deliveryController::class, 'addExtraPcs'])->name('app.add.extra-pcs');
            Route::post('/app/add-extra-weight', [App\Http\Controllers\admin\deliveryController::class, 'addExtraWeight'])->name('app.add.extra-weight');
            Route::post('/app/complete', [App\Http\Controllers\admin\deliveryController::class, 'complete'])->name('app.add.complete');
    
        });
    
        //CATEGORIES
        Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
            Route::get('/index', [App\Http\Controllers\admin\categoryController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\admin\categoryController::class, 'create'])->name('create');
            Route::get('/edit/{category_id}', [App\Http\Controllers\admin\categoryController::class, 'edit'])->name('edit');
            Route::get('/delete/{category_id}', [App\Http\Controllers\admin\categoryController::class, 'delete'])->name('delete');
    
            //apis
            Route::post('/delete/multiple', [App\Http\Controllers\admin\categoryController::class, 'deleteMultiple'])->name('api.delete');
            Route::post('/get-locations', [App\Http\Controllers\admin\categoryController::class, 'getLocations'])->name('get.locations');
            Route::post('/store', [App\Http\Controllers\admin\categoryController::class, 'store'])->name('store');
            Route::post('/update', [App\Http\Controllers\admin\categoryController::class, 'update'])->name('update');
            Route::post('/search', [App\Http\Controllers\admin\categoryController::class, 'search'])->name('search');

            //translations
            Route::get('/translations/{category_id}', [App\Http\Controllers\admin\categoryController::class, 'translationsCategory'])->name('translations');
            Route::post('/translations/save', [App\Http\Controllers\admin\categoryController::class, 'saveTranslationsCategory'])->name('translations.save');
    
            Route::post('/get-count', [App\Http\Controllers\admin\categoryController::class, 'getCount'])->name('get.count');
    
        });
    
        //DRINKS
        Route::group(['prefix' => 'drink', 'as' => 'drink.'], function () {
            Route::get('/index', [App\Http\Controllers\admin\drinkController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\admin\drinkController::class, 'create'])->name('create');
            Route::get('/edit/{drink_id}', [App\Http\Controllers\admin\drinkController::class, 'edit'])->name('edit');
            Route::get('/delete/{drink_id}', [App\Http\Controllers\admin\drinkController::class, 'delete'])->name('delete');
    
            Route::get('/export', [App\Http\Controllers\admin\drinkController::class, 'export'])->name('export');
    
            Route::post('/store', [App\Http\Controllers\admin\drinkController::class, 'store'])->name('store');
            Route::post('/update', [App\Http\Controllers\admin\drinkController::class, 'update'])->name('update');
    
            Route::post('/search', [App\Http\Controllers\admin\drinkController::class, 'search'])->name('search');
        });
    
        //FOOD
        Route::group(['prefix' => 'food', 'as' => 'food.'], function () {
            Route::get('/index', [App\Http\Controllers\admin\FoodController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\admin\FoodController::class, 'create'])->name('create');
            Route::get('/edit/{food_id}', [App\Http\Controllers\admin\FoodController::class, 'edit'])->name('edit');
            Route::get('/delete/{food_id}', [App\Http\Controllers\admin\FoodController::class, 'delete'])->name('delete');
    
            Route::get('/export', [App\Http\Controllers\admin\FoodController::class, 'export'])->name('export');
    
            Route::post('/store', [App\Http\Controllers\admin\FoodController::class, 'store'])->name('store');
            Route::post('/update', [App\Http\Controllers\admin\FoodController::class, 'update'])->name('update');
    
            Route::post('/search', [App\Http\Controllers\admin\FoodController::class, 'search'])->name('search');
        });
    
        /* WEEKLY
        Route::group(['prefix' => 'weekly', 'as' => 'weekly.'], function () {
            Route::get('/index', [App\Http\Controllers\admin\weeklyController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\admin\weeklyController::class, 'create'])->name('create');
            Route::get('/edit/{food_id}', [App\Http\Controllers\admin\weeklyController::class, 'edit'])->name('edit');
    
            Route::get('/delete/{food_id}', [App\Http\Controllers\admin\weeklyController::class, 'delete'])->name('delete');
    
            
    
            Route::post('/store', [App\Http\Controllers\admin\weeklyController::class, 'store'])->name('store');
            Route::post('/update', [App\Http\Controllers\admin\weeklyController::class, 'update'])->name('update');
    
            Route::post('/search', [App\Http\Controllers\admin\weeklyController::class, 'search'])->name('search');
    
            //wich -> this || next
            Route::get('/export/{wich}', [App\Http\Controllers\admin\weeklyController::class, 'export'])->name('export');
        });
        */
    
        /* Events
        Route::group(['prefix' => 'event', 'as' => 'event.'], function () {
            Route::get('/index', [App\Http\Controllers\admin\EventController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\admin\EventController::class, 'create'])->name('create');
            Route::get('/edit/{event_id}', [App\Http\Controllers\admin\EventController::class, 'edit'])->name('edit');
    
            Route::post('/store', [App\Http\Controllers\admin\EventController::class, 'store'])->name('store');
            Route::post('/update', [App\Http\Controllers\admin\EventController::class, 'update'])->name('update');
    
            Route::post('/search', [App\Http\Controllers\admin\EventController::class, 'search'])->name('search');
        });
    
        */
    });
    
    Route::middleware('auth')->group(function () {
        Route::get('/onboarding', [App\Http\Controllers\admin\onboardingController::class, 'onboarding'])->name('onboarding');
        Route::get('/continue-stocktaking/{stocktaking_id}', [App\Http\Controllers\admin\onboardingController::class, 'continueStocktaking'])->name('continue.stocktaking');
        Route::get('/locations', [App\Http\Controllers\admin\onboardingController::class, 'locations'])->name('locations');
        Route::get('/choose-location/{location_id}', [App\Http\Controllers\admin\onboardingController::class, 'chooselocation'])->name('choose.location');
    
        Route::get('/dashboard', [App\Http\Controllers\admin\onboardingController::class, 'dashboard'])->name('dashboard');    
    });
    
    //SUPPORT
    Route::get('/support', [App\Http\Controllers\HomeController::class, 'support'])->name('support');
    Route::post('/ticket/create', [App\Http\Controllers\HomeController::class, 'createTicket'])->name('ticket.create');
    
    Route::get('/no-access', [\App\Http\Controllers\adminController::class, 'noAccess'])->name('no-access');
});


//api route
Route::post('/get-categories', [App\Http\Controllers\api\ApiController::class, 'getCategories']);
Route::get('/get-current-location-id', [App\Http\Controllers\api\ApiController::class, 'getCurrentLocationID']);


//general routes
Route::get('/login-vue', [\App\Http\Controllers\adminController::class, 'logout'])->name('admin.login');
Route::get('/logout', [\App\Http\Controllers\adminController::class, 'logout'])->name('admin.logout');



//temp
Route::get('/admin-layout', [App\Http\Controllers\HomeController::class, 'adminLayout']);
Route::get('/db-backup', [App\Http\Controllers\HomeController::class, 'backupDB']);
//Route::get('/change-lang/{lang}', [App\Http\Controllers\admin\onboardingController::class, 'changeLang'])->name('change.lang');


Route::get('/calculator', [App\Http\Controllers\HomeController::class, 'bottleCalculator']);




