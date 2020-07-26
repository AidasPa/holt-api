<?php

namespace App\Http\Controllers;

use App\Category;
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
        $categories = Category::all()->pluck('title', 'id');

        return view('restaurants.form', [
            'categories' => $categories
        ]);
    }

    /**
     * @param RestaurantStoreRequest $request
     * @return RedirectResponse
     */
    public function store(RestaurantStoreRequest $request): RedirectResponse
    {

        /** @var Restaurant $restaurant */
        $restaurant = Restaurant::query()->create($request->getData());

        $restaurant->categories()->sync($request->getCategories());

        return redirect()->route('restaurants.index')
            ->with('status', 'Restaurant created.');
    }

    public function edit(Restaurant $restaurant): View
    {
        $categories = Category::all();
        $categoryIds = $restaurant->categories()->pluck('title', 'id');


        return view('restaurants.form', [
            'restaurant' => $restaurant,
            'categories' => $categories,
            'categoryIds' => $categoryIds
        ]);
    }

    /**
     * @param Restaurant $restaurant
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Restaurant $restaurant): RedirectResponse
    {
        $restaurant->delete();

        return redirect()->route('restaurants.index')
            ->with('status', 'Restaurant deleted.');
    }
}
