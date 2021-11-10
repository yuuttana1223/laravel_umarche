<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:50'],
            'information' => ['required', 'string', 'max:1000'],
            'price' => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'between:0,100000000'],
            'shop_id' => ['required', 'exists:shops,id'],
            'secondary_category_id' => ['required', 'exists:secondary_categories,id'],
            'is_selling' => ['required', 'boolean'],
            'image1' => ['nullable', 'exists:images,id'],
            'image2' => ['nullable', 'exists:images,id'],
            'image3' => ['nullable', 'exists:images,id'],
            'image4' => ['nullable', 'exists:images,id'],
        ];
    }

    public function messages()
    {
        return [
            'quantity.between' => '正の数を指定してください。',
        ];
    }
}
