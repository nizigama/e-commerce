<?php

namespace Domains\Cart\Services;

use App\Exceptions\ForbiddenException;
use App\Exceptions\UnknownException;
use Domains\Cart\Classes\CartItemData;
use Exception;
use Infrastructure\Cart\Queries\CartQueryContract;
use Infrastructure\Cart\Services\CartServiceContract;

class CartService implements CartServiceContract
{

    public function __construct(protected CartQueryContract $query)
    {
    }

    /**
     * @throws Exception
     */
    public function addToCart(int $productID, int $qty, int $userID): void
    {
        $alreadyAddedToCart = $this->query->userHasProductInCart($productID, $userID);

        if($alreadyAddedToCart){
            throw new ForbiddenException("Product already added to cart");
        }

        $cartItem = new CartItemData($productID, $qty, $userID);
        throw_if($this->query->createItemCart($cartItem, $userID) === null, new UnknownException("Failed to add item to cart"));
    }

    /**
     * @return CartItemData[]
     */
    public function viewCart(int $userID): array
    {
        return $this->query->getCartItems($userID);
    }

    public function itemExists(int $itemID, int $userID): bool
    {
        return $this->query->itemExists($itemID, $userID);
    }

    public function userHasProductInCart(int $productID, int $userID): bool{
        return $this->query->userHasProductInCart($productID, $userID);
    }

    public function deleteItem(int $itemID): bool
    {
        return $this->query->deleteItem($itemID);
    }
}
