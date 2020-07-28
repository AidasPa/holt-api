<?php


namespace App\Services;


use App\MenuCategory;
use App\MenuItem;
use Illuminate\Database\Eloquent\Collection;

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
     * @return Collection
     */
    public function getAllMenuCategories(): Collection
    {
        return MenuCategory::all();
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
     * @param int $menuCategoryId
     */
    public function createMenuItem(array $data, int $menuCategoryId): void
    {
        $menuItem = new MenuItem($data);
        $menuItem->menu_category_id = $menuCategoryId;

        $menuItem->save();
    }

    /**
     * @return Collection
     */
    public function getAllMenuItems(): Collection
    {
        return MenuItem::query()->with('category')->get();
    }
}
