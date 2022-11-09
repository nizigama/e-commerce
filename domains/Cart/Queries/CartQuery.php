<?php

namespace Domains\Cart\Queries;

use App\Models\Cart;
use App\Models\Product;
use Domains\Cart\Classes\CartItemData;
use Illuminate\Support\Facades\DB;
use Infrastructure\Cart\Queries\CartQueryContract;

class CartQuery implements CartQueryContract
{

    public function createItemCart(CartItemData $item, int $userID): ?int
    {
        return Cart::create([
            "productID" => $item->productID,
            "qty" => $item->quantity,
            "userID" => $userID
        ])?->id;
    }

    /** @return CartItemData[] */
    public function getCartItems(int $userID): array
    {
        return Cart::where("userID", $userID)->with("product")
            ->get()
            ->map(function (Cart $cart) {
                return new CartItemData(
                    $cart->product->id,
                    $cart->qty,
                    $cart->id,
                    $cart->product->name,
                    $cart->product->amount * $cart->qty
                );
            })
            ->toArray();
    }

    public function itemExists(int $itemID, int $userID): bool
    {
        return Cart::where([["userID", $userID], ["id", $itemID]])->exists();
    }

    public function userHasProductInCart(int $productID, int $userID): bool
    {
        return Cart::where([["userID", $userID], ["productID", $productID]])->exists();
    }

    public function deleteItem(int $itemID): bool
    {
        return Cart::find($itemID)?->delete() ?? false;
    }
}
