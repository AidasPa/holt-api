<?php

namespace App\Http\Controllers\API;

use App\DTO\Base\CollectionDTO;
use App\DTO\MenuCategoryDTO;
use App\DTO\MenuDTO;
use App\DTO\MenuItemDTO;
use App\Http\Controllers\Controller;
use App\Services\MenuService;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
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

    public function show(int $restaurant): JsonResponse
    {
        $menuCategories = $this->menuService->getAllMenuCategories($restaurant);
        $menuItems = $this->menuService->getAllMenuItems($restaurant);

        $menuCategoriesDTO = new CollectionDTO();
        foreach ($menuCategories as $menuCategory) {
            $menuCategoriesDTO->pushItem(new MenuCategoryDTO($menuCategory));
        }

        $menuItemsDTO = new CollectionDTO();

        foreach ($menuItems as $menuItem) {
            $menuItemsDTO->pushItem(new MenuItemDTO($menuItem));
        }

        $menuDTO = new MenuDTO($menuCategoriesDTO, $menuItemsDTO);

        return response()->json($menuDTO->jsonData());
    }


}
