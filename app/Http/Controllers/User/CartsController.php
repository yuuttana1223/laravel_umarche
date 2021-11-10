<?php

namespace App\Http\Controllers\User;

use App\Constants\ProductConstant;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CartsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = $request->route('user');
            if (Auth::id() !== $user->id) {
                abort(404);
            }
            return $next($request);
        });
    }

    public function index(User $user)
    {
        $products = $user->products;
        $totalAmount = 0;
        foreach ($products as $product) {
            $totalAmount += $product->price * $product->pivot->quantity;
        }

        return view(
            'user.carts.index',
            compact('products', 'totalAmount')
        );
    }

    public function destroy(User $user, Cart $cart)
    {
        $cart->delete();

        return redirect()
            ->route('user.carts.index', $user)
            ->with([
                'message' => 'カートの商品を削除しました。',
                'status' => 'alert',
            ]);
    }

    public function add(Request $request, User $user)
    {
        $cart = Cart::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if (is_null($cart)) {
            $user->products()->attach(
                $request->product_id,
                [
                    'quantity' => $request->quantity,
                ]
            );
        } else {
            $cart->quantity += $request->quantity;
            $cart->save();
        }

        return redirect()
            ->route('user.carts.index', $user)
            ->with([
                'message' => 'カートに商品を追加しました。',
                'status' => 'info',
            ]);
    }

    public function checkout(User $user)
    {
        $products = $user->products;

        $lineItems = [];
        foreach ($products as $product) {
            $quantity = $product->stocks->sum('quantity');
            if ($product->pivot->quanatity > $quantity) {
                return redirect()
                    ->route('user.carts.index', $user);
            } else {
                $lineItem = [
                    'name' => $product->name,
                    'description' => $product->information,
                    'amount' => $product->price,
                    'currency' => 'jpy',
                    'quantity' => $product->pivot->quantity,
                ];
                array_push($lineItems, $lineItem);
            }
        }

        // 決済の間は商品を保持するために一旦減らす
        foreach ($products as $product) {
            Stock::create([
                'product_id' => $product->id,
                'type' => ProductConstant::REDUCE,
                'quantity' => $product->pivot->quanatity * -1
            ]);
        }

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $checkoutSession = Session::create([
            'line_items' => [
                $lineItems
            ],
            'payment_method_types' => [
                'card',
            ],
            'mode' => 'payment',
            'success_url' => route('user.carts.success', $user),
            'cancel_url' => route('user.carts.index', $user),
        ]);
        return redirect($checkoutSession->url, 303);
    }

    public function success(User $user)
    {
        $user->products()->detach();
        return redirect()
            ->route('user.items.index');
    }
}
