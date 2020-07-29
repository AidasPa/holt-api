<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantStoreRequest;
use App\Http\Requests\RestaurantUpdateRequest;
use App\Restaurant;
use App\Services\CategoryService;
use App\Services\RestaurantService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RestaurantController extends Controller
{
    protected RestaurantService $restaurantService;
    protected CategoryService $categoryService;

    /**
     * RestaurantController constructor.
     * @param RestaurantService $restaurantService
     * @param CategoryService $categoryService
     */
    public function __construct(
        RestaurantService $restaurantService,
        CategoryService $categoryService)
    {
        $this->restaurantService = $restaurantService;
        $this->categoryService = $categoryService;
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
        $categories = $this->categoryService->getPluckedCategories();

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

    /**
     * @param Restaurant $restaurant
     * @return View
     */
    public function edit(Restaurant $restaurant): View
    {
        $categories = $this->categoryService->getPluckedCategories();

        // Nededam i servisa, nes restorana automatiskai uzkrauna laravelis
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
        $this->restaurantService->updateRestaurantWithRelations(
            $restaurant,
            $request->getData(),
            $request->getCategories(),
            $request->getImage(),
            $request->getBanner()
        );

        return redirect()->route('restaurants.index')
            ->with('status', 'Restaurant updated');
    }

}
