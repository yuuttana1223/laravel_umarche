<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $imageFile = $request->image;
        // 空じゃないかつアップロードされているか(有効か)
        if (!empty($imageFile) && $imageFile->isValid()) {
            // shopsがなければ作成してくれる
            Storage::putFile('public/shops', $imageFile);
        }

        return redirect()
            ->route('owner.shops.index')
            ->with([
                'message' => '画像を更新しました。',
                'status' => 'info'
            ]);
    }
}
