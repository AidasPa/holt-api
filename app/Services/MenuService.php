<?php


namespace App\Services;


use App\Helpers\BlurhashHelper;
use App\MenuCategory;
use App\MenuItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MenuService
{
    protected BlurhashHelper $blurhashHelper;

    /**
     * MenuService constructor.
     * @param BlurhashHelper $blurhashHelper
     */
    public function __construct(BlurhashHelper $blurhashHelper)
    {
        $this->blurhashHelper = $blurhashHelper;
    }


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
     * @return Collection
     */
    public function getAllMenuCategories(int $restaurantId): Collection
    {
        return MenuCategory::query()->where('restaurant_id', '=', $restaurantId)->get();
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
        $menuItem->image_blurhash = $this->blurhashHelper->generateBlurhash($image);
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

    /**
     * @return Collection
     */
    public function getAllMenuItems(int $restaurantId): Collection
    {
//        return MenuItem::query()
//            ->with('category.restaurant', function ($query) use ($restaurantId) {
//                $query->where('restaurant_id', '=', $restaurantId);
//            })
//            ->with('category')
//            ->get();
        return MenuItem::query()
            ->whereHas('category.restaurant', function (Builder $query) use ($restaurantId) {
                $query->where('restaurant_id', '=', $restaurantId);
            })
            ->get();
    }
}
