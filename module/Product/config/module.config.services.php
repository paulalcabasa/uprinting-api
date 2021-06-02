<?php

namespace Product;

use Product\Controller\ProductController;
use Product\ServiceFactory\Controller\ProductControllerFactory;

use Product\Model\Product;
use Product\Model\ProductTable;
use Product\ServiceFactory\Model\ProductTableFactory;

return [
    'controllers' => [
        'factories' => [
            ProductController::class => ProductControllerFactory::class
        ]
    ],
    'service_manager' => array(
        'invokables' => [
            Product::class => Product::class
        ],
        'factories' => [
            ProductTable::class => ProductTableFactory::class
        ],
    ),
    'view_manager' => [
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ]
];
