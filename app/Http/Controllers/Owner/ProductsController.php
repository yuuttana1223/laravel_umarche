<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\PrimaryCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $owner = $request->route('product')->owner;
            if (Auth::id() !== $owner->id) {
                abort(404);
            }
            return $next($request);
        })->only(['edit', 'update', 'destroy']);
    }

    public function index()
    {
        $products = Auth::user()->products()->with('imageFirst')->get();

        return view('owner.products.index', compact('products'));
    }

    public function create()
    {
        $shops = Auth::user()->shops()
            ->select('id', 'name')
            ->get();

        $images = Auth::user()->images()
            ->select('id', 'title', 'filename')
            ->get();

        $categories = PrimaryCategory::with('categories')
            ->get();

        return view(
            'owner.products.create',
            compact('shops', 'images', 'categories')
        );
    }

    public function store(Request $request)
    {
    }

    public function edit(Product $product)
    {
    }

    public function update(Request $request, Product $product)
    {
    }

    public function destroy(Product $product)
    {
    }
}
