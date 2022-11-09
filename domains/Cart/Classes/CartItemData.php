<?php

namespace Domains\Cart\Classes;

class CartItemData
{

    public function __construct(
        public int $productID,
        public int $quantity,
        public ?int $cartItemID = null,
        public ?string $productName = null,
        public ?float $amount = null
    ) {
    }
}
