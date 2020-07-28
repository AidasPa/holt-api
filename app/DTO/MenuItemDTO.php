<?php


namespace App\DTO;


use App\MenuItem;
use Illuminate\Support\Facades\Storage;

class MenuItemDTO extends Base\DTO
{
    private MenuItem $menuItem;

    /**
     * MenuItemDTO constructor.
     * @param MenuItem $menuItem
     */
    public function __construct(MenuItem $menuItem)
    {
        $this->menuItem = $menuItem;
    }

    /**
     * @inheritDoc
     */
    protected function jsonData(): array
    {
        return [
            'title' => $this->menuItem->title,
            'description' => $this->menuItem->description,
            'price' => $this->menuItem->price,
            'image' => [
                'url' => $this->getImageUrl(),
                'blurhash' => $this->menuItem->image_blurhash
            ],
            'category_id' => $this->menuItem->category->id,
        ];
    }

    /**
     * @return string
     */
    private function getImageUrl(): string
    {
        return env('APP_URL') . Storage::url($this->menuItem->image);
    }
}
