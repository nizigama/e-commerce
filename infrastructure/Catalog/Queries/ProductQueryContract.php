<?php

namespace Infrastructure\Catalog\Queries;

use Domains\Catalog\Classes\Objects\Product;

interface ProductQueryContract {

    public function all(): array;

    public function find(int $id): ?Product;
    
    public function exists(int $id): bool;
}