<?php

namespace App\Http\Controllers\API;

use App\DTO\Base\CollectionDTO;
use App\DTO\Base\PaginateDTO;
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
        $restaurants = Restaurant::query()
        ->with('categories')
        ->orderBy('created_at')
        ->paginate(15);

        $paginateDTO = new PaginateLengthAwareDTO($restaurants);
        $restaurantsDTO = new CollectionDTO();
        foreach ($restaurants as $restaurant) {
            $restaurantsDTO->pushItem(new RestaurantDTO($restaurant));
        }

        $paginateDTO->setData($restaurantsDTO);

        return response()->json($paginateDTO);
    }

    /**
     * @return JsonResponse
     */
    public function recent(): JsonResponse
    {
        $restaurants = Restaurant::query()
            ->orderBy('created_at')
            ->limit(10)
            ->get();
        $restaurantsDTO = new CollectionDTO();

        foreach ($restaurants as $restaurant) {
            $restaurantsDTO->pushItem(new RestaurantDTO($restaurant));
        }

        return response()->json($restaurantsDTO);
    }

    public function show(Restaurant $restaurant): JsonResponse
    {
        $restaurantDTO = new RestaurantDTO($restaurant);

        return response()->json($restaurantDTO->extendedJsonData());
    }
}
