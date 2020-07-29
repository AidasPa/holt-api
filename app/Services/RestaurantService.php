<?php


namespace App\Services;


use App\DTO\Base\CollectionDTO;
use App\DTO\Base\PaginateLengthAwareDTO;
use App\DTO\RestaurantDTO;
use App\Helpers\BlurhashHelper;
use App\Restaurant;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
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

    /**
     * @return PaginateLengthAwareDTO
     */
    public function getAllRestaurantsJson(): PaginateLengthAwareDTO
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
        return $paginateDTO;
    }

    /**
     * @return array
     */
    public function getLast3RestaurantsJson(): array
    {
        $restaurants = Restaurant::query()
            ->orderBy('created_at')
            ->limit(3)
            ->get();
        $restaurantsDTO = new CollectionDTO();

        foreach ($restaurants as $restaurant) {
            $restaurantsDTO->pushItem(new RestaurantDTO($restaurant));
        }

        return $restaurantsDTO->jsonData();
    }

    /**
     * @param Restaurant $restaurant
     * @param array $data
     * @param array $categoryIds
     * @param UploadedFile|null $image
     * @param UploadedFile|null $banner
     */
    public function updateRestaurantWithRelations(
        Restaurant $restaurant,
        array $data,
        array $categoryIds,
        ?UploadedFile $image,
        ?UploadedFile $banner): void
    {
        if ($image) {
            $data['image'] = Storage::disk('public')->putFile('restaurant_images', $image);
            $data['image_blurhash'] = $this->blurhashHelper->generateBlurhash($image);
        }
        if($banner) {
            $data['banner'] = Storage::disk('public')->putFile('restaurant_images', $banner);
            $data['banner_blurhash'] = $this->blurhashHelper->generateBlurhash($banner);
        }
        $restaurant->update($data);
        $restaurant->categories()->sync($categoryIds);

    }

    /**
     * @param Restaurant $restaurant
     * @throws \Exception
     */
    public function deleteRestaurant(Restaurant $restaurant): void
    {
        $restaurant->delete();
    }

    /**
     * @param string $query
     * @return array
     */
    public function searchByTitleJson(string $query): array
    {
        $results = Restaurant::query()->where('title', 'like', "%$query%")->get();

        $resultsDTO = new CollectionDTO();

        foreach ($results as $restaurant) {
            $resultsDTO->pushItem(new RestaurantDTO($restaurant));
        }

        return $resultsDTO->jsonData();
    }


}
