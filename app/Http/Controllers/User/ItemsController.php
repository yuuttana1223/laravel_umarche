<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
{
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
