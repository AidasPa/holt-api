<?php

namespace App\Http\Controllers;

use App\Category;
use App\Helpers\BlurhashHelper;
use App\Http\Requests\RestaurantStoreRequest;
use App\Http\Requests\RestaurantUpdateRequest;
use App\Restaurant;
use App\Services\RestaurantService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RestaurantController extends Controller
{
    protected BlurhashHelper $blurhashHelper;
    protected RestaurantService $restaurantService;

    /**
     * RestaurantController constructor.
     * @param BlurhashHelper $blurhashHelper
     * @param RestaurantService $restaurantService
     */
    public function __construct(BlurhashHelper $blurhashHelper, RestaurantService $restaurantService)
    {
        $this->blurhashHelper = $blurhashHelper;
        $this->restaurantService = $restaurantService;
    }


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

        $this->restaurantService->createRestaurant(
            $request->getData(),
            $request->getCategories(),
            $request->getImage(),
            $request->getBanner(),
        );

        return redirect()->route('restaurants.index')
            ->with('status', 'Restaurant created.');
    }

    public function edit(Restaurant $restaurant): View
    {
        $categories = Category::all()->pluck('title', 'id');
        $categoryIds = $restaurant->categories()->pluck('id')->toArray();


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

    public function update(Restaurant $restaurant, RestaurantUpdateRequest $request): RedirectResponse
    {
        $restaurant->update($request->getData());
        $restaurant->categories()->sync($request->getCategories());

        return redirect()->route('restaurants.index')
            ->with('status', 'Restaurant updated');
    }
}
