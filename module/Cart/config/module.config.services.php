<?php
namespace Cart;

use Cart\Model\Cart;
use Cart\Model\CartTable;
use Cart\ServiceFactory\Model\CartTableFactory;

use Cart\Model\CartItem;
use Cart\Model\CartItemTable;
use Cart\ServiceFactory\Model\CartItemTableFactory;

use Cart\Controller\CartController;
use Cart\ServiceFactory\Controller\CartControllerFactory;
use Cart\Controller\ShippingController;
use Cart\ServiceFactory\Controller\ShippingControllerFactory;


use Cart\ServiceFactory\Storage\CartSessionFactory;
use Cart\ServiceFactory\ViewHelper\CartViewFactory;

use Customer\ServiceFactory\Storage\CustomerSessionFactory;

use Product\Model\Product;
use Product\Model\ProductTable;
use Product\ServiceFactory\Model\ProductTableFactory;

return array(
    'controllers' => [
        'factories' => [
            CartController::class => CartControllerFactory::class,
            ShippingController::class => ShippingControllerFactory::class
        ]
    ],
    'service_manager' => [
        'invokables' => [
            Cart::class => Cart::class,
            CartItem::class => CartItem::class,
            Product::class => Product::class
        ],
        'factories' => [
            CartTable::class => CartTableFactory::class,
            CartItemTable::class => CartItemTableFactory::class,
           'CartSessionContainer' => CartSessionFactory::class,
           'CustomerSessionContainer' => CustomerSessionFactory::class,
            ProductTable::class => ProductTableFactory::class
        ]
    ],
    'view_helpers' => [
        'factories' => [
            'cart' => CartViewFactory::class
        ]
    ],
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy'
        ),
    )
);
