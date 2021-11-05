<?php

namespace App\Http\Controllers\Owner;

use App\Constants\ProductConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\PrimaryCategory;
use App\Models\Product;
use App\Models\Stock;
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

    public function store(ProductRequest $request)
    {
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
        $quantity = $product->stocks()->sum('quantity');

        $shops = Auth::user()->shops()
            ->select('id', 'name')
            ->get();

        $images = Auth::user()->images()
            ->select('id', 'title', 'filename')
            ->get();

        $currentImages = [
            $product->imageFirst,
            $product->imageSecond,
            $product->imageThird,
            $product->imageFourth,
        ];

        $categories = PrimaryCategory::with('categories')
            ->get();

        return view(
            'owner.products.edit',
            compact('product', 'quantity', 'shops', 'images', 'currentImages', 'categories')
        );
    }

    public function update(ProductRequest $request, Product $product)
    {
        $request->validate([
            'current_quantity' => ['required', 'integer', 'between:0,100000000'],
            'type' => ['required', 'integer', 'between:1,2'],
        ]);

        $quantity = $product->stocks()->sum('quantity');

        if ($request->current_quantity !== $quantity) {
            return redirect()
                ->route('owner.products.edit', $product)
                ->with([
                    'message' => '在庫数が変更されています。再度確認してください。',
                    'status' => 'alert',
                ]);
        }

        try {
            // useに使う変数を記述
            DB::transaction(function () use ($request, $product) {
                $product->name = $request->name;
                $product->information = $request->information;
                $product->price = $request->price;
                $product->shop_id = $request->shop_id;
                $product->secondary_category_id = $request->secondary_category_id;
                $product->is_selling = $request->is_selling;
                $product->image1 = $request->image1;
                $product->image2 = $request->image2;
                $product->image3 = $request->image3;
                $product->image4 = $request->image4;
                $product->save();

                $quantity = (int) $request->quantity;
                $type = $request->type;
                $quantity = ($type === \ProductConstant::REDUCE) ? $quantity * -1 : $quantity;

                Stock::create([
                    'product_id' => $product->id,
                    'type' => $type,
                    'quantity' => $quantity,
                ]);
            });
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
        }

        return redirect()
            ->route('owner.products.index')
            ->with([
                'message' => '商品情報を更新しました。',
                'status' => 'info',
            ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('owner.products.index')
            ->with([
                'message' => '商品を削除しました。',
                'status' => 'alert'
            ]);
    }
}
