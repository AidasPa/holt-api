<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemStoreRequest extends FormRequest
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
            'title' => 'required|string|min:3',
            'description' => 'required|string|min:12',
            'price' => 'required|numeric|min:0.1',
            'menu_category' => 'required|numeric|exists:menu_categories,id'
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
            'price' => $this->getPrice(),
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
    public function getPrice(): float
    {
        return $this->input('price');
    }

    /**
     * @return int
     */
    public function getMenuCategoryId(): int
    {
        return (int)$this->input('menu_category');
    }
}
