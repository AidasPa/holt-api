<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemUpdateRequest extends MenuItemStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|unique:restaurants,title',
            'description' => 'required|string|min:3',
            'rating' => 'required|numeric|min:0.1|max:10',
            'avg_delivery_time' => 'required|numeric|min:0',
            'phone_number' => 'required|string|min:12',
            'address' => 'required|string|min:3',
            'image' => 'nullable|image',
            'banner' => 'nullable|image'
        ];
    }
}
