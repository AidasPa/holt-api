<?php

namespace App\Http\Controllers;

use App\MenuCategory;
use Illuminate\View\View;

class MenuCategoryController extends Controller
{
    /**
     * @param int $restaurantId
     * @return View
     */
    public function index(int $restaurantId): View
    {
        $menuCategories = MenuCategory::all();
        return view('menu.categories.list', [
            'items' => $menuCategories,
            'restaurantId' => $restaurantId
        ]);
    }
}
