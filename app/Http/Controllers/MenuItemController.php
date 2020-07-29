<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuItemStoreRequest;
use App\MenuItem;
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
        $menuItems = $this->menuService->getAllMenuItems($restaurantId);

        return view('menu.items.list', [
            'items' => $menuItems,
            'restaurantId' => $restaurantId
        ]);
    }

    /**
     * @param int $restaurantId
     * @return View|RedirectResponse
     */
    public function create(int $restaurantId)
    {
        $menuCategories = $this->menuService->getAllMenuCategories($restaurantId);
        if (count($menuCategories) < 1) {
            return redirect()->route('restaurants.menu.categories.create', [
                'restaurant' => $restaurantId
            ])->with('status', 'Must create a menu category first!');
        }
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
        $this->menuService->createMenuItem($request->getData(), $request->getImage(), $request->getMenuCategoryId());

        return redirect()->route('restaurants.menu.items.index', [
            'restaurant' => $restaurantId
        ])->with('status', 'Menu item created.');
    }

    /**
     * @param int $restaurantId
     * @param MenuItem $item
     * @return View
     */
    public function edit(int $restaurantId, MenuItem $item): View
    {
        $menuCategories = $this->menuService->getAllMenuCategories($restaurantId);

        return view('menu.items.form', [
            'item' => $item,
            'restaurantId' => $restaurantId,
            'menuCategories' => $menuCategories
        ]);
    }

    /**
     * @param int $restaurantId
     * @param MenuItem $item
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(int $restaurantId, MenuItem $item): RedirectResponse
    {
        $this->menuService->deleteMenuItem($item);

        return redirect()->route('restaurants.menu.items.index', [
            'restaurant' => $restaurantId
        ])->with('status', 'Menu item deleted.');
    }

}
