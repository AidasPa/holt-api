<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuCategoryStoreRequest;
use App\MenuCategory;
use App\Services\MenuService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MenuCategoryController extends Controller
{
    protected MenuService $menuService;

    /**
     * MenuController constructor.
     * @param MenuService $menuService
     */
    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }


    /**
     * @param int $restaurant
     * @return View
     */
    public function index(int $restaurantId): View
    {
        $menuCategories = $this->menuService->getAllMenuCategories($restaurantId);
        return view('menu.categories.list', [
            'items' => $menuCategories,
            'restaurantId' => $restaurantId,
        ]);
    }

    /**
     * @param int $restaurantId
     * @return View
     */
    public function create(int $restaurantId): View
    {
        return view('menu.categories.form', [
            'restaurantId' => $restaurantId
        ]);
    }

    /**
     * @param int $restaurantId
     * @param MenuCategoryStoreRequest $request
     * @return RedirectResponse
     */
    public function store(int $restaurantId, MenuCategoryStoreRequest $request): RedirectResponse
    {
        $this->menuService->createMenuCategory($request->getData(), $restaurantId);

        return redirect()->route('restaurants.menu.categories.index', [
            'restaurant' => $restaurantId
        ])->with('status', 'Menu category created.');

    }

    /**
     * @param int $restaurantId
     * @param MenuCategory $category
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(int $restaurantId, MenuCategory $category): RedirectResponse
    {
        $this->menuService->deleteCategory($category);

        return redirect()->route('restaurants.menu.categories.index', ['restaurant' => $restaurantId])
            ->with('status', 'Menu category deleted.');
    }
}
