<?php


namespace App\DTO;


use App\MenuCategory;

class MenuCategoryDTO extends Base\DTO
{
    private MenuCategory $menuCategory;

    /**
     * MenuCategoryDTO constructor.
     * @param MenuCategory $menuCategory
     */
    public function __construct(MenuCategory $menuCategory)
    {
        $this->menuCategory = $menuCategory;
    }


    /**
     * @inheritDoc
     */
    protected function jsonData(): array
    {
        return [
            'id' => $this->menuCategory->id,
            'title' => $this->menuCategory->title,
        ];
    }
}
