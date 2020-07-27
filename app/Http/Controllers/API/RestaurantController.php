<?php

namespace App\Http\Controllers\API;

use App\DTO\Base\CollectionDTO;
use App\DTO\RestaurantDTO;
use App\Http\Controllers\Controller;
use App\Restaurant;
use Illuminate\Http\JsonResponse;

class RestaurantController extends Controller
{
    public function index(): JsonResponse
    {
        $restaurants = Restaurant::all();

        $restaurantsDTO = new CollectionDTO();
        foreach ($restaurants as $restaurant) {
            $restaurantsDTO->pushItem(new RestaurantDTO($restaurant));
        }

        return response()->json($restaurantsDTO);
    }
}
