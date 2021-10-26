<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ShopsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function ($request, $next) {
            $owner = $request->route('shop')->owner;
            if (Auth::id() !== $owner->id) {
                abort(404);
            }
            return $next($request);
        })->only(['edit', 'update']);
    }

    public function index()
    {
        $shops = Auth::user()->shops;
        return view('owner.shops.index', compact('shops'));
    }

    public function edit(Shop $shop)
    {
        return view('owner.shops.edit', compact('shop'));
    }

    public function update(Request $request, Shop $shop)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg, jpeg, png', 'max:2000'],
        ]);
        $imageFile = $request->image;
        // 画像ファイルの名前と乱数の組み合わせ
        $prefix = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME) . rand();
        // 名前が同じだと上書きされてしまう(ユニークなidを混ぜる)
        $fileName = uniqid("{$prefix}_");

        $resizedImage = Image::make($imageFile)->resize(1920, 1080)->encode();
        Storage::put("public/shops/{$fileName}", $resizedImage);
        return redirect()
            ->route('owner.shops.index')
            ->with([
                'message' => '画像を更新しました。',
                'status' => 'info'
            ]);
    }
}
