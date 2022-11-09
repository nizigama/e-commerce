<?php

namespace App\Http\Controllers;

use Infrastructure\Catalog\Services\CatalogServiceContract;

class CatalogController extends Controller
{

    public function __construct(protected CatalogServiceContract $catalogService)
    {
        // $this->middleware("auth:sanctum");
    }

    public function index()
    {
        $products = $this->catalogService->listProducts();

        return response()->json($products);
    }
}
