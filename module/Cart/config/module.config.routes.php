<?php
namespace Cart;

use Cart\Controller\CartController;
use Cart\Controller\CartItemController;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return array(
    'router' => [
        'routes' => [
            'cart' => [
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/cart',
                    'defaults' => array(
                        'controller' => CartController::class
                    ),
                ),
            ],
            'cart-items' => [
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/cart-items[/:id]',
                    'defaults' => array(
                        'controller' => CartItemController::class
                    ),
                ),
            ],
        ]
    ]
);
