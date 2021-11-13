<?php

namespace App\Services;

class CartService
{
    public static function getProductInCart($cartItems)
    {
        $products = [];
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->select('id', 'name', 'price')->find($cartItem->id)->toArray();
            $owner = $cartItem->owner->select('name as ownerName', 'email')->find($cartItem->owner_id)->toArray();
            $quanaity = [
                'quanaity' => $cartItem->pivot->quantity
            ];
            array_push($products, array_merge($product, $owner,  $quanaity));
        }
        dd($products);
        return $products;
    }
}
