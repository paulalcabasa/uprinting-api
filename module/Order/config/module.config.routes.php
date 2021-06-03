<?php
namespace Order;

use Order\Controller\OrderController;
use Order\Controller\ShippingController;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return array(
    'router' => [
        'routes' => [
            'get-shipping' => [
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/shipping[/:id]',
                    'defaults' => array(
                        'controller' => ShippingController::class
                    ),
                ),
            ],
            // 'shipping-info' => [
            //     'type' => Literal::class,
            //     'options' => [
            //         'route'    => '/shipping',
            //         'defaults' => [
            //             'controller' => OrderController::class,
            //             'action'     => 'shipping',
            //             'viewTemplate' => 'SHIPPING',
            //             'template' => 'MAIN_TPL'
            //         ],
            //     ],
            // ],
            // 'order-confirmation' => [
            //     'type' => Segment::class,
            //     'options' => [
            //         'route'    => '/order-confirmation[/:id]',
            //         'defaults' => [
            //             'controller' => OrderController::class,
            //             'action'     => 'index',
            //             'viewTemplate' => 'ORDER_CONFIRMATION',
            //             'template' => 'MAIN_TPL'
            //         ],
            //     ],
            // ],
        ]
    ]
);
