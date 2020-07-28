<?php


namespace App\Services;


use App\MenuCategory;

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
        $menuCategory->forceDelete();
//        $menuCategory->save();
    }
}
