<?php


namespace App\Services;


use App\Helpers\BlurhashHelper;
use App\Restaurant;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class RestaurantService
{
    protected BlurhashHelper $blurhashHelper;

    /**
     * RestaurantService constructor.
     * @param BlurhashHelper $blurhashHelper
     */
    public function __construct(BlurhashHelper $blurhashHelper)
    {
        $this->blurhashHelper = $blurhashHelper;
    }


    /**
     * @param array $data
     * @param array $categoryIds
     * @param UploadedFile $image
     * @param UploadedFile|null $banner
     */
    public function createRestaurant
    (array $data,
     array $categoryIds,
     UploadedFile $image,
     ?UploadedFile $banner): void
    {

        $imageBlurhash = $this->blurhashHelper->generateBlurhash($image);
        $bannerBlurhash = $banner ? $this->blurhashHelper->generateBlurhash($banner) : null;

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
