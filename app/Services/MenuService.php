<?php


namespace App\Services;


use App\DTO\Base\CollectionDTO;
use App\DTO\MenuCategoryDTO;
use App\DTO\MenuDTO;
use App\DTO\MenuItemDTO;
use App\Helpers\BlurhashHelper;
use App\MenuCategory;
use App\MenuItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MenuService
{

    /**
     * @param array $data
     * @param int $restaurantId
     */
    public function createMenuCategory(array $data, int $restaurantId): void
    {
        $menuCategory = new MenuCategory($data);
        $menuCategory->restaurant_id = $restaurantId;

        $menuCategory->save();
    }

    /**
     * @param MenuCategory $menuCategory
     * @throws \Exception
     */
    public function deleteCategory(MenuCategory $menuCategory): void
    {
        $menuCategory->delete();
    }

    /**
     * @param array $data
     * @param UploadedFile $image
     * @param int $menuCategoryId
     */
    public function createMenuItem(array $data, UploadedFile $image, int $menuCategoryId): void
    {
        $menuItem = new MenuItem($data);
        $menuItem->image = Storage::disk('public')->putFile('menu_item_images', $image);
        $menuItem->image_blurhash = BlurhashHelper::generateBlurhash($image);
        $menuItem->menu_category_id = $menuCategoryId;

        $menuItem->save();
    }

    /**
     * @param MenuItem $menuItem
     * @throws \Exception
     */
    public function deleteMenuItem(MenuItem $menuItem): void
    {
        $menuItem->delete();
    }

    public function getMenuJson(int $restaurant): array
    {
        $menuCategories = $this->getAllMenuCategories($restaurant);
        $menuItems = $this->getAllMenuItems($restaurant);

        $menuCategoriesDTO = new CollectionDTO();
        foreach ($menuCategories as $menuCategory) {
            $menuCategoriesDTO->pushItem(new MenuCategoryDTO($menuCategory));
        }

        $menuItemsDTO = new CollectionDTO();

        foreach ($menuItems as $menuItem) {
            $menuItemsDTO->pushItem(new MenuItemDTO($menuItem));
        }

        $menuDTO = new MenuDTO($menuCategoriesDTO, $menuItemsDTO);
        return $menuDTO->jsonData();
    }

    /**
     * @return Collection
     */
    public function getAllMenuCategories(int $restaurantId): Collection
    {
        return MenuCategory::query()->where('restaurant_id', '=', $restaurantId)->get();
    }

    /**
     * @return Collection
     */
    public function getAllMenuItems(int $restaurantId): Collection
    {
        return MenuItem::query()
            ->whereHas('category.restaurant', function (Builder $query) use ($restaurantId) {
                $query->where('restaurant_id', '=', $restaurantId);
            })
            ->get();
    }

    /**
     * @param array $data
     * @param UploadedFile|null $image
     * @param MenuItem $menuItem
     */
    public function updateMenuItem(array $data, ?UploadedFile $image, MenuItem $menuItem): void
    {
        if($image) {
            $data['image'] = Storage::disk('public')->putFile($image);
            $data['image_blurhash'] = BlurhashHelper::generateBlurhash($image);
        }
        $menuItem->update($data);
    }
}
