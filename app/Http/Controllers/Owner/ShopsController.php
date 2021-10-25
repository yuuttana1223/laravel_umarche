<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $shop->name = $request->name;
        $shop->email = $request->email;
        $shop->password = Hash::make($request->password);

        return redirect()
            ->route('admin.owner.index')
            ->with([
                'message' => 'オーナー情報を更新しました。',
                'status' => 'info'
            ]);
    }
}
