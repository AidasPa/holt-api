<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|unique:restaurants,title',
            'description' => 'required|string|min:20',
            'rating' => 'required|numeric|min:0.1|max:10',
            'avg_delivery_time' => 'required|numeric|min:0',
            'phone_number' => 'required|string|min:12',
            'address' => 'required|string|min:3'
        ];
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'rating' => $this->getRating(),
            'avg_delivery_time' => $this->getAverageDeliveryTime(),
            'phone_number' => $this->getPhoneNumber(),
            'address' => $this->getAddress(),
            'categories' => $this->getCategories()
        ];
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->input('title');
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->input('description');
    }

    /**
     * @return float
     */
    public function getRating(): float
    {
        return $this->input('rating');
    }

    /**
     * @return int
     */
    public function getAverageDeliveryTime(): int
    {
        return $this->input('avg_delivery_time');
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->input('phone_number');
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->input('address');
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->input('categories', []);
    }
}
