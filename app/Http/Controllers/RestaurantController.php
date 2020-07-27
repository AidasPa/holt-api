<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\RestaurantStoreRequest;
use App\Http\Requests\RestaurantUpdateRequest;
use App\Restaurant;
use App\Services\BlurhashService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;
use kornrunner\Blurhash\Blurhash;

class RestaurantController extends Controller
{
    protected $blurhashService;

    /**
     * RestaurantController constructor.
     * @param $blurhashService
     */
    public function __construct(BlurhashService $blurhashService)
    {
        $this->blurhashService = $blurhashService;
    }


    /**
     * @return View
     */
    public function index(): View
    {
        $restaurants = Restaurant::all();
        $restaurants->load('categories');

        return view('restaurants.list', [
            'items' => $restaurants
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $categories = Category::all()->pluck('title', 'id');

        return view('restaurants.form', [
            'categories' => $categories
        ]);
    }

    /**
     * @param RestaurantStoreRequest $request
     * @return RedirectResponse
     */
    public function store(RestaurantStoreRequest $request): RedirectResponse
    {

        /* BLURHASH GENERATION */

        $image = Image::make($request->getImage());
        $instance = $image->getCore();

        $width = imagesx($instance);
        $height = imagesy($instance);

        $pixels = [];
        for ($y = 0; $y < $height; ++$y) {
            $row = [];
            for ($x = 0; $x < $width; ++$x) {
                $index = imagecolorat($instance, $x, $y);
                $colors = imagecolorsforindex($instance, $index);

                $row[] = [$colors['red'], $colors['green'], $colors['blue']];
            }
            $pixels[] = $row;
        }

        $components_x = 4;
        $components_y = 3;
        $blurhash = Blurhash::encode($pixels, $components_x, $components_y);

        dd($blurhash);

        $restaurant = new Restaurant($request->getData());
        $restaurant->image = Storage::disk('public')->putFile('restaurant_images', $request->getImage());
        if ($banner = $request->getBanner()) {
            $restaurant->banner = $banner;
        }

        $restaurant->save();

        dd('yeet');
        $restaurant->categories()->sync($request->getCategories());

        return redirect()->route('restaurants.index')
            ->with('status', 'Restaurant created.');
    }

    public function edit(Restaurant $restaurant): View
    {
        $categories = Category::all()->pluck('title', 'id');
        $categoryIds = $restaurant->categories()->pluck('id')->toArray();


        return view('restaurants.form', [
            'restaurant' => $restaurant,
            'categories' => $categories,
            'categoryIds' => $categoryIds
        ]);
    }

    /**
     * @param Restaurant $restaurant
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Restaurant $restaurant): RedirectResponse
    {
        $restaurant->delete();

        return redirect()->route('restaurants.index')
            ->with('status', 'Restaurant deleted.');
    }

    public function update(Restaurant $restaurant, RestaurantUpdateRequest $request): RedirectResponse
    {
        $restaurant->update($request->getData());
        $restaurant->categories()->sync($request->getCategories());

        return redirect()->route('restaurants.index')
            ->with('status', 'Restaurant updated');
    }
}
