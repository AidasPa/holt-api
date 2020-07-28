<?php

namespace App\DTO;

use App\DTO\Base\DTO;
use App\Restaurant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class RestaurantDTO extends DTO
{
    private Restaurant $restaurant;

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
    public function jsonData(): array
    {
        return [
            'id' => $this->restaurant->id,
            'title' => $this->restaurant->title,
            'description' => $this->restaurant->description,
            'rating' => $this->restaurant->rating,
            'categories' => $this->getCategoryTitles(),
            'image' => [
                'url' => env('APP_URL') . Storage::url($this->restaurant->image),
                'blurhash' => $this->restaurant->image_blurhash
            ],
        ];
    }

    /**
     * @return Collection
     */
    private function getCategoryTitles(): Collection
    {
        return $this->restaurant->categories()->pluck('title');
    }

    /**
     * @return array
     */
    public function extendedJsonData(): array
    {
        return [
            'id' => $this->restaurant->id,
            'title' => $this->restaurant->title,
            'description' => $this->restaurant->description,
            'rating' => $this->restaurant->rating,
            'categories' => $this->getCategoryTitles(),
            'phone_number' => $this->restaurant->phone_number,
            'avg_delivery_time' => $this->restaurant->avg_delivery_time,
            'image' => [
                'url' => $this->getImageUrl(),
                'blurhash' => $this->restaurant->image_blurhash
            ],
            'banner' => [
                'url' => $this->getBannerUrl(),
                'blurhash' => $this->restaurant->banner_blurhash
            ],
        ];
    }

    /**
     * @return string
     */
    private function getImageUrl(): string
    {
        return env('APP_URL') . Storage::url($this->restaurant->image);
    }

    /**
     * @return string|null
     */
    private function getBannerUrl(): ?string
    {
        return env('APP_URL') . Storage::url($this->restaurant->banner);

    }

}
