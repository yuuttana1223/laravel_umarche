<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\PrimaryCategory;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

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
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'information' => ['required', 'string', 'max:1000'],
            'price' => ['required', 'integer'],
            'shop_id' => ['required', 'exists:shops,id'],
            'secondary_category_id' => ['required', 'exists:secondary_categories,id'],
            'is_selling' => ['required'],
            'image1' => ['nullable', 'exists:images,id'],
            'image2' => ['nullable', 'exists:images,id'],
            'image3' => ['nullable', 'exists:images,id'],
            'image4' => ['nullable', 'exists:images,id'],
        ]);


        try {
            // useに使う変数を記述
            DB::transaction(function () use ($request) {
                $product = Product::create([
                    'name' => $request->name,
                    'information' => $request->information,
                    'price' => $request->price,
                    'quantity' => $request->quantity,
                    'shop_id' => $request->shop_id,
                    'secondary_category_id' => $request->secondary_category_id,
                    'owner_id' => Auth::id(),
                    'is_selling' => $request->is_selling,
                    'image1' => $request->image1,
                    'image2' => $request->image2,
                    'image3' => $request->image3,
                    'image4' => $request->image4,
                ]);

                Stock::create([
                    'product_id' => $product->id,
                    'type' => 1, //入庫在庫を増やす場合
                    'quantity' => $request->quantity,
                ]);
            });
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
        }

        return redirect()
            ->route('owner.products.index')
            ->with([
                'message' => '商品登録を実施しました。',
                'status' => 'info'
            ]);
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
