<?php

namespace Infrastructure\Catalog\Factories\Objects;

use Domains\Catalog\Classes\Objects\Product;

interface ProductFactoryContract
{
    public static function fromArray(array $data): Product;
    public static function toArray(Product $product): array;
}
