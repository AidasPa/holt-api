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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('API\Auth')->prefix('auth')->group(function () {
    Route::post('register', 'RegisterController@register');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout');
});

Route::namespace('API')->group(function () {
    Route::prefix('restaurants')->group(function () {
        Route::get('/', 'RestaurantController@index');
        Route::get('recent', 'RestaurantController@recent');

        Route::get('search', 'RestaurantController@search');

        Route::get('{restaurant}', 'RestaurantController@show');

        Route::get('{restaurant}/menu', 'MenuController@show');

    });

    Route::get('/categories', 'CategoryController@index');
    Route::get('/categories/{category}', 'CategoryController@restaurants');
});
