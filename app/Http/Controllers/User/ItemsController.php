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
        $stocks = DB::table('t_stocks')
            ->select('product_id', DB::raw('sum(quantity) as quantity'))
            ->groupBy('product_id')
            ->having('quantity', '>', 1);

        $products = DB::table('products')
            ->joinSub($stocks, 'stocks', function ($join) {
                $join->on('products.id', '=', 'stocks.product_id');
            })
            ->join('shops', 'shops.id', '=', 'products.shop_id')
            ->join('secondary_categories', 'secondary_categories.id', '=', 'products.secondary_category_id')
            ->join('images', 'images.id', '=', 'products.image1')
            ->where('shops.is_selling', true)
            ->where('products.is_selling', true)
            ->select(
                'products.id',
                'products.name as name',
                'products.price',
                'products.information',
                'secondary_categories.name as categoryName',
                'images.filename'
            )
            ->get();

        return view('user.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('user.show', compact('product'));
    }
}
