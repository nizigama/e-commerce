<?php

namespace Infrastructure\Cart\Services;

use Domains\Catalog\Classes\Objects\Product;
use Infrastructure\Catalog\Factories\Objects\ProductFactoryContract;
use Infrastructure\Catalog\Queries\ProductQueryContract;

interface CartServiceContract
{

    /**
     * @throws Exception
     */
    public function addToCart(int $productID, int $qty, int $userID): void;

    /**
     * @return CartItemData[]
     */
    public function viewCart(int $userID): array;

    public function itemExists(int $itemID, int $userID): bool;

    public function userHasProductInCart(int $productID, int $userID): bool;
    
    public function deleteItem(int $itemID): bool;
}
