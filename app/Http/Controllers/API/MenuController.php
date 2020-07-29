<?php

namespace App\Http\Controllers\API;

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

    /**
     * @param int $restaurantId
     * @return JsonResponse
     */
    public function show(int $restaurantId): JsonResponse
    {
        $menu = $this->menuService->getMenuJson($restaurantId);

        return response()->json($menu);
    }


}
