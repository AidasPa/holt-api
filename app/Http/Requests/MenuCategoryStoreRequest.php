<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuCategoryStoreRequest extends FormRequest
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
            'title' => 'required|string|min:3'
        ];
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'title' => $this->getTitle()
        ];
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->input('title');
    }
}
