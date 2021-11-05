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
            'image' => ['file', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'files.*.image' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png', 'max:2048']
        ];
    }

    public function messages()
    {
        return [
            'file' => '指定されたファイルが正常にアップロードされませんでした。',
            'image' => '指定されたファイルが画像ではありません。',
            'mimes' => '指定された拡張子(jpg/jpeg/png)ではありません。',
            'max' => 'ファイルサイズは2MB以内にしてください。',
        ];
    }
}
