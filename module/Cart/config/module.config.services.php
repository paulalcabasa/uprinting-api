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

use Cart\Controller\CartItemController;
use Cart\ServiceFactory\Controller\CartItemControllerFactory;

use Product\Model\Product;
use Product\Model\ProductTable;
use Product\ServiceFactory\Model\ProductTableFactory;


use Cart\Helper\CartIdEncryptionHelper;
use Cart\ServiceFactory\Helper\CartIdEncryptionHelperFactory;


return array(
    'controllers' => [
        'factories' => [
            CartController::class => CartControllerFactory::class,
            CartItemController::class => CartItemControllerFactory::class,
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
            ProductTable::class => ProductTableFactory::class,
            CartIdEncryptionHelper::class => CartIdEncryptionHelperFactory::class,
        ]
    ],
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy'
        ),
    )
);
