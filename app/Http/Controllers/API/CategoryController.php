<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\DTO\Base\CollectionDTO;
use App\DTO\CategoryDTO;
use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\RestaurantService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    /**
     * CategoryController constructor.
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }


    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAllCategoriesJson();
        return response()->json($categories);
    }

}
