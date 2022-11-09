<?php

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {

    $this->user = User::factory()->create();
    $this->product = Product::factory()->create();

    $this->actingAs($this->user);
});

it('logged in user can list items in their cart', function () {

    Cart::factory(4)->create([
        "userID" => $this->user->id
    ]);

    $response = $this->getJson('/api/v1/cart');

    $response->assertStatus(200);

    $items = $response->json();

    expect($items)->toBeArray()
        ->and($items)->each(function ($item) {
            return $item->productID->toBeInt()->quantity->toBeInt()->cartItemID->toBeInt()->productName->toBeString()->amount->toBeInt();
        });
});

it('logged in user can add an item to their cart', function () {

    $qty = fake()->randomNumber(2);

    $response = $this->postJson('/api/v1/cart', [
        "productID" => $this->product->id,
        "quantity" => $qty
    ]);

    $response->assertStatus(200);

    $message = $response->json()["message"] ?? null;

    expect($message)->toBe("Product Successfully added to cart");

    assertDatabaseHas((new Cart())->getTable(), [
        "productID" => $this->product->id,
        "qty" => $qty,
        "userID" => $this->user->id
    ]);
});

it('logged in user can remove an item from their cart', function () {

    $qty = fake()->randomNumber(2);

    $item = Cart::factory()->create([
        "userID" => $this->user->id,
        "productID" => $this->product->id,
        "qty" => $qty
    ]);

    $response = $this->deleteJson('/api/v1/cart/' . $item->id);

    $response->assertStatus(200);

    $message = $response->json()["message"] ?? null;

    expect($message)->toBe("Cart Successfully removed from cart");

    assertDatabaseMissing((new Cart())->getTable(), [
        "productID" => $this->product->id,
        "qty" => $qty,
        "userID" => $this->user->id
    ]);
});
