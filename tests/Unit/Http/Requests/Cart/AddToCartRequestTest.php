<?php

use App\Http\Requests\Cart\AddToCartRequest;
use Illuminate\Support\Facades\Validator;

test('that the add to cart request is validated properly', function (string $field, mixed $value, array $dependingFields, bool $shouldFail) {

    $rules = (new AddToCartRequest())->rules();

    $validator = Validator::make(
        [$field => $value, ...$dependingFields],
        [$field => $rules[$field]]
    );

    expect($validator->fails())->toBe($shouldFail);
})->with([
    [
        "productID",
        null,
        [],
        true,
    ],
    [
        "productID",
        12.4,
        [],
        true,
    ],
    [
        "productID",
        -4,
        [],
        true,
    ],
    [
        "productID",
        5,
        [],
        false,
    ],
    [
        "quantity",
        null,
        [],
        true,
    ],
    [
        "quantity",
        12.4,
        [],
        true,
    ],
    [
        "quantity",
        -4,
        [],
        true,
    ],
    [
        "quantity",
        5,
        [],
        false,
    ],
]);
