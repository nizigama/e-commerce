<?php

namespace Domains\Catalog\Classes\Objects;

class Product
{

    public function __construct(
        readonly public ?int $id,
        readonly public string $name,
        readonly public string $sku,
        readonly public string $imageUrl,
        readonly public int $amount,
    ) {
    }
}
