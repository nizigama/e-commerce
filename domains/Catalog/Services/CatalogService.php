<?php

declare(strict_types=1);

namespace Domains\Catalog\Services;

use Domains\Catalog\Classes\Objects\Product;
use Infrastructure\Catalog\Factories\Objects\ProductFactoryContract;
use Infrastructure\Catalog\Queries\ProductQueryContract;
use Infrastructure\Catalog\Services\CatalogServiceContract;

class CatalogService implements CatalogServiceContract
{

    public function __construct(
        protected ProductQueryContract $productQuery,
        protected ProductFactoryContract $productFactory
    ) {
    }

    /**
     * @return Product[]
     */
    public function listProducts(): array
    {
        $products = $this->productQuery->all();

        return array_map(function ($px) {
            $px->amount = $px->amount / 100;
            return $this->productFactory->fromArray((array)$px);
        }, $products);
    }

    public function getProductDetails(int $productID): ?Product
    {
        return $this->productQuery->find($productID);
    }

    public function productExists(int $productID): bool
    {
        return $this->productQuery->exists($productID);
    }
}
