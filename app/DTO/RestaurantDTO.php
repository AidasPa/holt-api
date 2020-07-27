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
            'title' => $this->restaurant->title,
            'description' => $this->restaurant->description,
            'rating' => $this->restaurant->rating,
            'avg_delivery_time' => $this->restaurant->avg_delivery_time,
            'phone_number' => $this->restaurant->phone_number,
            'address' => $this->restaurant->address,
            'categories' => $this->getCategoryTitles(),
            'image' => Storage::url($this->restaurant->image)
        ];
    }

    /**
     * @return Collection
     */
    private function getCategoryTitles(): Collection
    {
        return $this->restaurant->categories()->pluck('title');
    }

}
