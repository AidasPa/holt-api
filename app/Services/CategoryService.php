<?php


namespace App\Services;


use App\Category;
use App\DTO\Base\CollectionDTO;
use App\DTO\Base\PaginateDTO;
use App\DTO\Base\PaginateLengthAwareDTO;
use App\DTO\CategoryDTO;
use App\DTO\RestaurantDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CategoryService
{

    /**
     * @param array $data
     * @param UploadedFile|null $image
     */
    public function createCategory(array $data, ?UploadedFile $image): void
    {
        $category = new Category($data);
        if ($image) {
            $category->image = Storage::disk('public')->putFile('category_images', $image);
        }
        $category->save();
    }

    /**
     * @return Collection
     */
    public function getAllCategories(): Collection
    {
        return Category::all();
    }

    /**
     * @return CollectionDTO
     */
    public function getAllCategoriesJson(): CollectionDTO
    {
        $categories = Category::all();
        $categories->load('restaurants');
        $categoriesDTO = new CollectionDTO();

        foreach ($categories as $category) {
            $categoriesDTO->pushItem(new CategoryDTO($category));
        }

        return $categoriesDTO;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function getPluckedCategories(): \Illuminate\Support\Collection
    {
        return Category::all()->pluck('title', 'id');
    }

    /**
     * @param Category $category
     * @return PaginateLengthAwareDTO
     */
    public function getRestaurantsByCategoryJson(Category $category): PaginateLengthAwareDTO
    {
        $restaurants = $category->restaurants()->paginate();

        $paginateDTO = new PaginateLengthAwareDTO($restaurants);
        $restaurantsDTO = new CollectionDTO();
        foreach ($restaurants as $restaurant) {
            $restaurantsDTO->pushItem(new RestaurantDTO($restaurant));
        }

        $paginateDTO->setData($restaurantsDTO);
        return $paginateDTO;
    }
}
