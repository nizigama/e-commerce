<?php

namespace App\Providers;

use Domains\Catalog\Factories\Objects\ProductFactory;
use Domains\Catalog\Queries\ProductQuery;
use Domains\Catalog\Services\CatalogService;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Catalog\Factories\Objects\ProductFactoryContract;
use Infrastructure\Catalog\Queries\ProductQueryContract;
use Infrastructure\Catalog\Services\CatalogServiceContract;

class CatalogProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public $bindings = [
        ProductQueryContract::class => ProductQuery::class,
        ProductFactoryContract::class => ProductFactory::class,
        CatalogServiceContract::class => CatalogService::class
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
