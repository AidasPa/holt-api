<?php


namespace App\Services;


use App\Category;
use App\DTO\Base\CollectionDTO;
use App\DTO\Base\ExtendedPaginateLengthAwareDTO;
use App\DTO\Base\PaginateLengthAwareDTO;
use App\DTO\CategoryDTO;
use App\DTO\RestaurantDTO;
use App\Helpers\BlurhashHelper;
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
        $restaurants = $category->restaurants()->paginate(1);

        $paginateDTO = new ExtendedPaginateLengthAwareDTO($restaurants);
        $restaurantsDTO = new CollectionDTO();
        foreach ($restaurants as $restaurant) {
            $restaurantsDTO->pushItem(new RestaurantDTO($restaurant));
        }

        $paginateDTO->setData($restaurantsDTO);
        $paginateDTO->setExtendedData(new CategoryDTO($category));
        return $paginateDTO;
    }

    /**
     * @param array $data
     * @param UploadedFile|null $image
     * @param Category $category
     */
    public function updateCategory(array $data, ?UploadedFile $image, Category $category): void
    {
        if($image) {
            $data['image'] = Storage::disk('public')->putFile('category_images', $image);
            $data['image_blurhash'] = BlurhashHelper::generateBlurhash($image);
        }
        $category->update($data);
    }

    /**
     * @param Category $category
     * @throws \Exception
     */
    public function deleteCategory(Category $category): void
    {
        $category->delete();
    }
}
