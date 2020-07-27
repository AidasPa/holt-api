<?php

namespace App\DTO;

use App\DTO\Base\DTO;
use App\Restaurant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class RestaurantDTO extends DTO
{
    private $restaurant;

    /**
     * RestaurantDTO constructor.
     * @param Restaurant $restaurant
     */
    public function __construct(Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;
    }

    /**
     * @return array
     */
    protected function jsonData(): array
    {
        return [
            'id' => $this->restaurant->id,
            'title' => $this->restaurant->title,
            'description' => $this->restaurant->description,
            'rating' => $this->restaurant->rating,
            'categories' => $this->getCategoryTitles(),
            'image' => env('APP_URL') . Storage::url($this->restaurant->image),
            'image_blurhash' => $this->restaurant->image_blurhash
        ];
    }

    /**
     * @return Collection
     */
    private function getCategoryTitles(): Collection
    {
        return $this->restaurant->categories()->pluck('title');
    }

    protected function extendedJsonData(): array
    {
        // TODO: Implement extendedJsonData() method.
    }

}
