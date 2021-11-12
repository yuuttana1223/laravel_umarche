<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $product = Product::findOrFail($request->route('item'));
            if ($product->is_selling === 0) {
                abort(404);
            }
            return $next($request);
        })->only('show');
    }

    public function index(Request $request)
    {
        $products = Product::availableItems()->get();

        return view('user.items.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $quantity = $product->stocks()->sum('quantity');

        return view(
            'user.items.show',
            compact('product', 'quantity')
        );
    }
}
