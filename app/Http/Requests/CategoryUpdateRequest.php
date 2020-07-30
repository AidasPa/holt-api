<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends CategoryStoreRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string',
            'image' => 'nullable|image'
        ];
    }
}
