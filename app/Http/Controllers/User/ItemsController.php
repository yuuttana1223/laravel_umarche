<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    private Product $product;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->product = Product::findOrFail($request->route('item'));
            if ($this->product->is_selling === 0) {
                abort(404);
            }
            return $next($request);
        })->only('show');
    }

    public function index(Request $request)
    {
        $products = Product::availableItems()
            ->sortOrder($request->sort)
            ->paginate($request->pagination ?? '20'); // 初期値は15

        return view('user.items.index', compact('products'));
    }

    public function show($id)
    {
        $product = $this->product;
        $quantity = $product->stocks()->sum('quantity');

        return view(
            'user.items.show',
            compact('product', 'quantity')
        );
    }
}
