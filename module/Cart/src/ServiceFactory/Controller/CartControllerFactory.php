<?php


namespace Cart\ServiceFactory\Controller;

use Cart\Controller\CartController;
use Cart\Model\Cart;
use Cart\Model\CartTable;
use Cart\Model\CartItem;
use Cart\Model\CartItemTable;
use Cart\Model\DemoCartTable;

use Product\Model\Product;
use Product\Model\ProductTable;


use Psr\Container\ContainerInterface;

class CartControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $cartTable = $container->get(CartTable::class);
        $cart = $container->get(Cart::class);
        $cartItemTable = $container->get(CartItemTable::class);
        $cartItem = $container->get(CartItem::class);

        $productTable = $container->get(ProductTable::class);
        $product = $container->get(Product::class);

      	$CartSessionContainer = $container->get('CartSessionContainer');

        return new CartController(
            $cartTable,
            $cart,
            $cartItemTable,
            $cartItem,
            $CartSessionContainer,
            $productTable,
            $product
        );
    }
}
