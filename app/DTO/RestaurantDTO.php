<?php

namespace App\DTO;

use App\DTO\Base\DTO;
use App\Restaurant;

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
        ];
    }

}
