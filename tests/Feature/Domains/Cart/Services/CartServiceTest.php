<?php

use App\Exceptions\ForbiddenException;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Domains\Cart\Classes\CartItemData;
use Infrastructure\Cart\Services\CartServiceContract;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {

    $this->user = User::factory()->create();
    $this->product = Product::factory()->create();

    $this->cartService = app(CartServiceContract::class);
});

test('user can add a product item to the cart', function (int $productID, int $qty, ?Exception $exception) {

    if (!is_null($exception)) {
        expect(function () use ($productID, $qty) {
            $this->cartService->addToCart($productID, $qty, $this->user->id);
        })->toThrow($exception::class, $exception->getMessage());
        return;
    }

    $this->cartService->addToCart($productID, $qty, $this->user->id);

    assertDatabaseHas((new Cart())->getTable(), [
        "productID" => $productID,
        "qty" => $qty,
        "userID" => $this->user->id
    ]);
})->with([
    [
        function () {
            return $this->product->id;
        },
        function () {
            return fake()->randomNumber(1);
        },
        null
    ],
    [
        function () {
            Cart::factory()->create([
                "productID" => $this->product->id,
                "userID" => $this->user->id
            ]);
            return $this->product->id;
        },
        function () {
            return fake()->randomNumber(1);
        },
        new ForbiddenException("Product already added to cart")
    ],
]);

test('user can view product items in cart', function (bool $itemsExist) {

    $items = $this->cartService->viewCart($this->user->id);

    if (!$itemsExist) {
        expect($items)->toHaveCount(0);
        return;
    }

    expect($items)->each->toBeInstanceOf(CartItemData::class)
        ->and($items)->each(function ($item) {
            return $item->productID->toBeInt()->quantity->toBeInt()->cartItemID->toBeInt()->productName->toBeString()->amount->toBeFloat();
        });
})->with([
    function () {

        Cart::factory(4)->create([
            "userID" => $this->user->id
        ]);

        return true;
    },
    function () {
        return false;
    },
]);

test('user cart contains an item with given ID', function (int $itemID, bool $exists) {

    $status = $this->cartService->itemExists($itemID, $this->user->id);

    expect($status)->toBe($exists);
})->with([
    [
        function () {
            return Cart::factory()->create([
                "userID" => $this->user->id
            ])->id;
        },
        true
    ],
    [
        function () {
            return fake()->randomNumber(2);
        },
        false
    ]
]);

test('user has product already added to the cart', function (int $productID, bool $exists) {

    $status = $this->cartService->userHasProductInCart($productID, $this->user->id);

    expect($status)->toBe($exists);
})->with([
    [
        function () {
            return Cart::factory()->create([
                "userID" => $this->user->id,
                "productID" => Product::factory()->create()
            ])->productID;
        },
        true
    ],
    [
        function () {
            return fake()->randomNumber(2);
        },
        false
    ]
]);

test('user can remove an item from the cart', function () {

    $cartItem = Cart::factory()->create([
        "userID" => $this->user->id,
        "productID" => Product::factory()->create()
    ]);

    $deleted = $this->cartService->deleteItem($cartItem->id);

    expect($deleted)->toBeTrue();

    assertDatabaseMissing((new Cart())->getTable(), [
        "id" => $cartItem->id,
        "userID" => $this->user->id,
        "productID" => Product::factory()->create()
    ]);
});
