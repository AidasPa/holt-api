<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuItemStoreRequest;
use App\Services\MenuService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    protected MenuService $menuService;

    /**
     * MenuItemController constructor.
     * @param MenuService $menuService
     */
    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * @param int $restaurantId
     * @return View
     */
    public function index(int $restaurantId): View
    {
        $menuItems = $this->menuService->getAllMenuItems();
        return view('menu.items.list', [
            'items' => $menuItems,
            'restaurantId' => $restaurantId
        ]);
    }

    /**
     * @param int $restaurantId
     * @return View
     */
    public function create(int $restaurantId): View
    {
        $menuCategories = $this->menuService->getAllMenuCategories();
        return view('menu.items.form', [
            'restaurantId' => $restaurantId,
            'menuCategories' => $menuCategories
        ]);
    }

    /**
     * @param int $restaurantId
     * @param MenuItemStoreRequest $request
     * @return RedirectResponse
     */
    public function store(int $restaurantId, MenuItemStoreRequest $request): RedirectResponse
    {
        $this->menuService->createMenuItem($request->getData(), $request->getMenuCategoryId());

        return redirect()->route('restaurants.menu.items.index', [
            'restaurant' => $restaurantId
        ])->with('status', 'Menu item created.');
    }

}
