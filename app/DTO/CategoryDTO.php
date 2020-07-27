<?php


namespace App\DTO;


use App\Category;
use App\DTO\Base\DTO;
use Illuminate\Support\Facades\Storage;

class CategoryDTO extends DTO
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return array
     */
    protected function jsonData(): array
    {
        return [
            'id' => $this->category->id,
            'title' => $this->category->title,
            'image' => $this->getCategoryImage(),
            'restaurant_count' => $this->getRestaurantCount()
        ];
    }

    /**
     * @return int
     */
    private function getRestaurantCount(): int
    {
        return count($this->category->restaurants);
    }

    /**
     * @return string|null
     */
    private function getCategoryImage(): ?string
    {
        return $this->category->image ? env('APP_URL') . Storage::url($this->category->image) : null;
    }
}
