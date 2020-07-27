<?php

namespace App\Http\Controllers\API;

use App\DTO\Base\CollectionDTO;
use App\DTO\Base\PaginateDTO;
use App\DTO\Base\PaginateLengthAwareDTO;
use App\DTO\RestaurantDTO;
use App\Http\Controllers\Controller;
use App\Restaurant;
use Illuminate\Http\JsonResponse;

class RestaurantController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $restaurants = Restaurant::query()
        ->with('categories')
        ->orderBy('created_at')
        ->paginate(1);

        $paginateDTO = new PaginateLengthAwareDTO($restaurants);
        $restaurantsDTO = new CollectionDTO();
        foreach ($restaurants as $restaurant) {
            $restaurantsDTO->pushItem(new RestaurantDTO($restaurant));
        }

        $paginateDTO->setData($restaurantsDTO);

        return response()->json($paginateDTO);
    }
}
