<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService
{
    public static function upload($imageFile, $dirname)
    {
        $prefix = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME) . rand();
        $fileName = uniqid("{$prefix}_");
        $extension = $imageFile->extension();
        $basename = "{$fileName}.{$extension}";

        $resizedImage = Image::make($imageFile)->resize(1920, 1080)->encode();
        Storage::put("public/{$dirname}/{$basename}", $resizedImage);

        return $basename;
    }
}
