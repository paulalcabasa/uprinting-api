<?php


namespace Cart\ServiceFactory\Controller;

use Cart\Controller\CartItemController;

use Cart\Model\Cart;
use Cart\Model\CartTable;

use Cart\Model\CartItem;
use Cart\Model\CartItemTable;

use Product\Model\Product;
use Product\Model\ProductTable;

//use Cart\Filter\CartIdFilter;

use Interop\Container\ContainerInterface;

class CartItemControllerFactory
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

      //  $CartIdFilter = $serviceLocator->get(CartIdFilter::class);
      
        return new CartItemController(
            $cartTable,
            $cart,
            
            $cartItemTable,
            $cartItem,
        
            $productTable,
            $product
            
          //  $CartIdFilter
        );
    }
}
