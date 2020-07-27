<?php


namespace App\DTO\Base;


use App\Category;
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
            'title' => $this->category->title,
            'image' => Storage::url($this->category->image),
        ];
    }
}
