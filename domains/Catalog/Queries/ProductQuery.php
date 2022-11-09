<?php

namespace Domains\Catalog\Queries;

use App\Models\Product as ModelsProduct;
use Domains\Catalog\Classes\Objects\Product;
use Domains\Catalog\Factories\Objects\ProductFactory;
use Illuminate\Support\Facades\DB;
use Infrastructure\Catalog\Queries\ProductQueryContract;

class ProductQuery implements ProductQueryContract
{

    public function all(): array
    {
        return DB::select("SELECT
                                id, name, sku, imageUrl, amount
                                FROM Product
                            ");
    }

    public function find(int $id): ?Product
    {
        $product = ModelsProduct::find($id);

        if (is_null($product)) {
            return null;
        }

        return ProductFactory::fromArray([
            $product->id,
            $product->name,
            $product->sku,
            $product->imageUrl,
            $product->amount
        ]);
    }

    public function exists(int $id): bool
    {

        return ModelsProduct::where("id", $id)->exists();
    }
}
