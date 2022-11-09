<?php

namespace Domains\Catalog\Factories\Objects;

use Domains\Catalog\Classes\Objects\Product;
use Infrastructure\Catalog\Factories\Objects\ProductFactoryContract;

class ProductFactory implements ProductFactoryContract
{
    public static function fromArray(array $data): Product
    {
        return new Product(
            $data["id"] ?? null,
            $data["name"],
            $data["sku"],
            $data["imageUrl"],
            $data["amount"]
        );
    }

    public static function toArray(Product $product): array
    {
        return [
            "id" => $product->id,
            "name" => $product->name,
            "sku" => $product->sku,
            "imageUrl" => $product->imageUrl,
            "amount" => $product->amount,
        ];
    }
}
