<?php

namespace Product;

use Product\Controller\ProductController;

return [
    'router' => [
        'routes' => [
            'get-products' => [
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/product',
                    'defaults' => array(
                        'controller' => ProductController::class
                   
                    ),
                ),
            ],
            'get-product' => [
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/product[/:id]',
                    'defaults' => array(
                        'controller' => ProductController::class
                    ),
                ),
            ],
            'add-product' => [
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/product',
                    'defaults' => array(
                        'controller' => ProductController::class
                    ),
                ),
            ],
            'update-product' => [
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/product[/:id]',
                    'defaults' => array(
                        'controller' => ProductController::class
                    ),
                ),
            ],
            'delete-product' => [
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/product[/:id]',
                    'defaults' => array(
                        'controller' => ProductController::class
                    ),
                ),
            ]
        ],
    ]
];