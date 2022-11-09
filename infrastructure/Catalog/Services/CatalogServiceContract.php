<?php

namespace Infrastructure\Catalog\Services;

use Domains\Catalog\Classes\Objects\Product;

interface CatalogServiceContract
{
    /**
     * @return Product[]
     */
    public function listProducts(): array;

    public function getProductDetails(int $productID): ?Product;
    
    public function productExists(int $productID): bool;
}
