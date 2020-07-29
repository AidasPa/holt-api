<?php

namespace App\Http\Controllers\API;

use App\DTO\Base\CollectionDTO;
use App\DTO\Base\PaginateLengthAwareDTO;
use App\DTO\RestaurantDTO;
use App\Http\Controllers\Controller;
use App\Restaurant;
use App\Services\RestaurantService;
use Illuminate\Http\JsonResponse;

class RestaurantController extends Controller
{
    protected RestaurantService $restaurantService;

    /**
     * RestaurantController constructor.
     * @param RestaurantService $restaurantService
     */
    public function __construct(RestaurantService $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }


    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {

        $restaurants = $this->restaurantService->getAllRestaurantsJson();
        return response()->json($restaurants);
    }

    /**
     * @return JsonResponse
     */
    public function recent(): JsonResponse
    {
        $restaurants = $this->restaurantService->getLast3RestaurantsJson();

        return response()->json($restaurants);
    }

    public function show(Restaurant $restaurant): JsonResponse
    {
        $restaurantDTO = new RestaurantDTO($restaurant);

        return response()->json($restaurantDTO->extendedJsonData());
    }
}
