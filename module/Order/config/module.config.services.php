<?php
namespace Order;

use Order\Controller\OrderController;
use Order\ServiceFactory\Controller\OrderControllerFactory;

use Order\Filter\JobOrderFilter;

use Order\Model\JobOrder;
use Order\Model\JobOrderTable;
use Order\ServiceFactory\Model\JobOrderTableFactory;

use Order\Model\JobItem;
use Order\Model\JobItemTable;
use Order\ServiceFactory\Model\JobItemTableFactory;

use Cart\Model\CartItem;
use Cart\Model\CartItemTable;
use Cart\ServiceFactory\Model\CartItemTableFactory;


use Cart\Model\Cart;
use Cart\Model\CartTable;
use Cart\ServiceFactory\Model\CartTableFactory;

use Product\Model\Product;
use Product\Model\ProductTable;
use Product\ServiceFactory\Model\ProductTableFactory;

use Order\Controller\ShippingController;
use Order\ServiceFactory\Controller\ShippingControllerFactory;

use Order\Model\Shipping;
use Order\Model\ShippingTable;
use Order\ServiceFactory\Model\ShippingTableFactory;

use Customer\Model\Customer;
use Customer\Model\CustomerTable;
use Customer\ServiceFactory\Model\CustomerTableFactory;

use Auth\Service\TokenService;
use Auth\ServiceFactory\Service\TokenServiceFactory;


use Order\Service\OrderService;
use Order\ServiceFactory\Service\OrderServiceFactory;

return array(
    'controllers' => [
        'factories' => [
            ShippingController::class => ShippingControllerFactory::class,
            OrderController::class => OrderControllerFactory::class
        ]
    ],
    'service_manager' => [
        'invokables' => [
            JobOrder::class => JobOrder::class,
            JobItem::class => JobItem::class,
            CartItem::class => CartItem::class,
            Shipping::class => Shipping::class,
            Cart::class => Cart::class,
            Product::class => Product::class,
            JobOrderFilter::class => JobOrderFilter::class,
            Customer::class => Customer::class,
        ],
        'factories' => [
            CustomerTable::class => CustomerTableFactory::class,
            JobOrderTable::class => JobOrderTableFactory::class,
            JobItemTable::class => JobItemTableFactory::class,
            CartItemTable::class => CartItemTableFactory::class,
            ShippingTable::class => ShippingTableFactory::class,
            CartTable::class => CartTableFactory::class,
            ProductTable::class => ProductTableFactory::class,
            TokenService::class => TokenServiceFactory::class,
            OrderService::class => OrderServiceFactory::class,
        ]
    ],

    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy'
        ),
    )
);
