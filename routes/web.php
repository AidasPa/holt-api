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
    Route::resource('categories', 'CategoryController')->only(['index', 'create', 'store']);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
