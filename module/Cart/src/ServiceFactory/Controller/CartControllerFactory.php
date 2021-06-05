<?php


namespace Cart\ServiceFactory\Controller;

use Cart\Controller\CartController;

use Cart\Model\Cart;
use Cart\Model\CartTable;

use Cart\Model\CartItem;
use Cart\Model\CartItemTable;

use Product\Model\Product;
use Product\Model\ProductTable;

//use Cart\Filter\CartIdFilter;

use Interop\Container\ContainerInterface;

use Cart\Helper\CartIdEncryptionHelper;

class CartControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $serviceLocator = $container->getServiceLocator();

        $cartTable = $serviceLocator->get(CartTable::class);
        $cart = $serviceLocator->get(Cart::class);

        $cartItemTable = $serviceLocator->get(CartItemTable::class);
        $cartItem = $serviceLocator->get(CartItem::class);

        $productTable = $serviceLocator->get(ProductTable::class);
        $product = $serviceLocator->get(Product::class);

        $cartIdEncryptionHelper = $serviceLocator->get(CartIdEncryptionHelper::class);


    //    $CartIdFilter = $serviceLocator->get(CartIdFilter::class);
        return new CartController(
            $cartTable,
            $cart,
            
            $cartItemTable,
            $cartItem,
        
            $productTable,
            $product,

            $cartIdEncryptionHelper
            
         //   $CartIdFilter
        );
    }
}
