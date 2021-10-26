<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // trueにしないとエラーメッセージではなく403エラーを返す
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
            // 画像投稿は必須ではない
            'image' => ['image', 'mimes:jpg, jpeg, png', 'max:2048'],
        ];
    }
}
