<?php

namespace App\Providers;

use Domains\Cart\Queries\CartQuery;
use Domains\Cart\Services\CartService;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Cart\Queries\CartQueryContract;
use Infrastructure\Cart\Services\CartServiceContract;

class CartProvider extends ServiceProvider
{

    public $bindings = [
        CartQueryContract::class => CartQuery::class,
        CartServiceContract::class => CartService::class
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
