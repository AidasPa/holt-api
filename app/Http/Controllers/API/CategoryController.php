<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\DTO\Base\CollectionDTO;
use App\DTO\CategoryDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::all();
        $categories->load('restaurants');
        $categoriesDTO = new CollectionDTO();

        foreach ($categories as $category) {
            $categoriesDTO->pushItem(new CategoryDTO($category));
        }

        return response()->json($categoriesDTO);
    }

}
