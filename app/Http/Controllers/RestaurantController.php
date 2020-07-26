<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantStoreRequest;
use App\Restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RestaurantController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $restaurants = Restaurant::all();
        $restaurants->load('categories');

        return view('restaurants.list', [
            'items' => $restaurants
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('restaurants.form');
    }

    public function store(RestaurantStoreRequest $request): RedirectResponse
    {
        Restaurant::query()->create($request->getData());

        return redirect()->route('restaurants.index')
            ->with('status', 'Restaurant created.');
    }
}
