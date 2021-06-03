<?php
namespace Cart;

use Cart\Controller\CartController;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return array(
    'router' => [
        'routes' => [
            'cart-info' => [
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/cart',
                    'defaults' => array(
                        'controller' => CartController::class
                   
                    ),
                ),
            ],
      
            // 'cart-info' => [
            //     'type' => Literal::class,
            //     'options' => [
            //         'route'    => '/cart',
            //         'defaults' => [
            //             'controller' => CartController::class,
            //             'action'     => 'index',
            //             'viewTemplate' => 'CART',
            //             'template' => 'MAIN_TPL'
            //         ],
            //     ],
            // ],
            'add-to-cart' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/api/cart/add',
                    'defaults' => [
                        'controller' => CartController::class,
                        'action'     => 'addToCart'
                    ],
                ],
            ],
            'remove-to-cart' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/api/cart/remove',
                    'defaults' => [
                        'controller' => CartController::class,
                        'action'     => 'removeToCart'
                    ],
                ],
            ],
            'update-cart-item' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/api/cart-item/update',
                    'defaults' => [
                        'controller' => CartController::class,
                        'action'     => 'updateItem'
                    ],
                ],
            ]
        ]
    ]
);
