<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\DTO\Base\CategoryDTO;
use App\DTO\Base\CollectionDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::all();
        $categoriesDTO = new CollectionDTO();

        foreach ($categories as $category) {
            $categoriesDTO->pushItem(new CategoryDTO($category));
        }

        return response()->json($categoriesDTO);
    }

}
