<?php


namespace App\DTO;


use App\DTO\Base\CollectionDTO;

class MenuDTO extends Base\DTO
{
    private CollectionDTO $menuCategoryDTO;
    private CollectionDTO $menuItemDTO;

    /**
     * MenuDTO constructor.
     * @param CollectionDTO $menuCategoryDTO
     * @param CollectionDTO $menuItemDTO
     */
    public function __construct(CollectionDTO $menuCategoryDTO, CollectionDTO $menuItemDTO)
    {
        $this->menuItemDTO = $menuItemDTO;
        $this->menuCategoryDTO = $menuCategoryDTO;
    }


    /**
     * @inheritDoc
     */
    public function jsonData(): array
    {
        return [
            'menu_categories' => $this->menuCategoryDTO->jsonData(),
            'menu_items' => $this->menuItemDTO->jsonData()
        ];
    }
}
