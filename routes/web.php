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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('restaurants', 'RestaurantController')->only(['index', 'create', 'store', 'destroy', 'edit', 'update']);
    Route::resource('categories', 'CategoryController')->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('/restaurants/{restaurant}/menu/categories', 'MenuController')->only(['index']);

    Route::prefix('restaurants/{restaurant}/menu')->name('restaurants.menu.')->group(function () {
        Route::resource('categories', 'MenuCategoryController')->only(['index', 'create', 'store', 'destroy', 'update', 'edit']);
        Route::resource('items', 'MenuItemController')->only(['index', 'create', 'store', 'destroy', 'edit', 'update']);
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
