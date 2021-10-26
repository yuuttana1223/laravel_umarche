<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService
{
    public static function upload($imageFile, $folderName)
    {
        // 画像ファイルの名前と乱数の組み合わせ
        $prefix = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME) . rand();
        // 名前が同じだと上書きされてしまう(ユニークなidを混ぜる)
        $fileName = uniqid("{$prefix}_");

        $resizedImage = Image::make($imageFile)->resize(1920, 1080)->encode();
        Storage::put("public/{$folderName}/{$fileName}", $resizedImage);
    }
}
