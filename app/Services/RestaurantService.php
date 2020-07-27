<?php


namespace App\Services;


use App\Restaurant;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class RestaurantService
{
    /**
     * @param array $data
     * @param array $categoryIds
     * @param UploadedFile $image
     * @param UploadedFile|null $banner
     * @param string $imageBlurhash
     * @param string|null $bannerBlurhash
     */
    public function createRestaurant
    (array $data,
     array $categoryIds,
     UploadedFile $image,
     ?UploadedFile $banner,
     string $imageBlurhash,
     ?string $bannerBlurhash): void
    {
        $restaurant = new Restaurant($data);
        $restaurant->image = Storage::disk('public')->putFile('restaurant_images', $image);
        $restaurant->image_blurhash = $imageBlurhash;
        if ($banner) {
            $restaurant->banner = Storage::disk('public')->putFile('restaurant_images', $banner);
            $restaurant->banner_blurhash = $bannerBlurhash;
        }

        $restaurant->save();
    }
}
