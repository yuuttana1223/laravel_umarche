<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        })->only(['add', 'index']);
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
            ->route('user.carts.index', $user);
    }

    public function add(Request $request, User $user)
    {
        $cart = Cart::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if (is_null($cart)) {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        } else {
            $cart->quantity += $request->quantity;
            $cart->save();
        }

        return redirect()
            ->route('user.carts.index', $user)
            ->with([
                'message' => '',
                'status' => 'info',
            ]);
    }
}
