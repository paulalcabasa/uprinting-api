<?php
namespace Customer;

use Customer\Controller\CustomerController;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return array(
    'router' => [
        'routes' => [
            'get-customers' => [
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/customers',
                    'defaults' => array(
                        'controller' => CustomerController::class
                    ),
                ),
            ],
        ]
    ]
);
