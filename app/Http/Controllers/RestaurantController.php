<?php

namespace App\Http\Controllers;

use App\Restaurant;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RestaurantController extends Controller
{
    /**
     * @return View
     */
    public function index(): View {
        $restaurants = Restaurant::all();
        $restaurants->load('categories');

        return view('restaurants.list', [
            'items' => $restaurants
        ]);
    }
}
