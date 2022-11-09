<?php

namespace Infrastructure\Cart\Queries;

use Domains\Cart\Classes\CartItemData;

interface CartQueryContract
{

    public function createItemCart(CartItemData $item, int $userID): ?int;

    /** @return CartItemData[] */
    public function getCartItems(int $userID): array;

    public function itemExists(int $itemID, int $userID): bool;

    public function userHasProductInCart(int $productID, int $userID): bool;
    
    public function deleteItem(int $itemID): bool;
}
