<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddToCartRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Infrastructure\Cart\Services\CartServiceContract;
use Infrastructure\Catalog\Services\CatalogServiceContract;

class CartController extends Controller
{
    public function __construct(protected CartServiceContract $cartService, protected CatalogServiceContract $catalogService)
    {
        $this->middleware("auth:sanctum");
    }

    public function index()
    {
        $cartItems = $this->cartService->viewCart(Auth::id());

        return response()->json($cartItems);
    }

    public function store(AddToCartRequest $request)
    {
        $productExists = $this->catalogService->productExists($request->productID);

        if (!$productExists) {
            return response()->json(["message" => "Product not found"], Response::HTTP_NOT_FOUND);
        }

        try {

            $this->cartService->addToCart($request->productID, $request->quantity, Auth::id());

            return response()->json(["message" => "Product Successfully added to cart"]);
        } catch (\Throwable $th) {

            Log::error("Failed to add product item to cart", [
                "request" => $request,
                "user" => Auth::user(),
                "class" => __CLASS__,
                "function" => __FUNCTION__,
                "exception" => $th
            ]);

            $error = getHttpMessageAndStatusCodeFromException($th);

            return \response()->json(['message' => $error[0]], $error[1]);
        }
    }

    public function destroy(int $itemID)
    {

        $itemExists = $this->cartService->itemExists($itemID, Auth::id());

        if (!$itemExists) {
            return response()->json(["message" => "Item not found"], Response::HTTP_NOT_FOUND);
        }

        if ($this->cartService->deleteItem($itemID)) {
            return response()->json(["message" => "Cart Successfully removed from cart"]);
        }

        return response()->json(["message" => "Failed to remove the item from cart"], Response::HTTP_BAD_REQUEST);
    }
}
